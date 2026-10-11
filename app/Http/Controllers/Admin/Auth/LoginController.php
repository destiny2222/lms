<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Mail\AdminLoginOtpMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(AdminLoginRequest $request)
    {
        $admin = $request->authenticate();
        $this->sendOtp($request, $admin, $request->boolean('remember'));

        $message = 'We sent a verification code to your email address.';
        if (session('local_otp')) {
            $message .= ' (Local test code: '.session('local_otp').')';
        }

        return redirect()->route('admin.otp.show')
            ->with('status', $message);
    }

    public function showOtpForm(Request $request)
    {
        if (! $request->session()->has('admin_login_otp')) {
            return redirect()->route('admin.login');
        }

        return view('admin.auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => ['required', 'digits:6']]);

        $challenge = $request->session()->get('admin_login_otp');

        if (! $challenge || now()->greaterThan($challenge['expires_at'])) {
            $request->session()->forget('admin_login_otp');

            return redirect()->route('admin.login')
                ->withErrors(['otp' => 'This verification code has expired. Please sign in again.']);
        }

        if (! Hash::check($request->input('otp'), $challenge['code'])) {
            $attempts = ((int) ($challenge['attempts'] ?? 0)) + 1;

            if ($attempts >= 5) {
                $request->session()->forget('admin_login_otp');

                return redirect()->route('admin.login')
                    ->withErrors(['otp' => 'Too many incorrect codes. Please sign in again.']);
            }

            $challenge['attempts'] = $attempts;
            $request->session()->put('admin_login_otp', $challenge);

            return back()->withErrors(['otp' => 'The verification code is incorrect.']);
        }

        $admin = Admin::find($challenge['admin_id']);

        if (! $admin) {
            $request->session()->forget('admin_login_otp');

            return redirect()->route('admin.login')
                ->withErrors(['email' => 'This admin account no longer exists.']);
        }

        Auth::guard('admin')->login($admin, $challenge['remember']);
        $request->session()->forget('admin_login_otp');
        $request->session()->regenerate();

        return redirect()->intended('/admin/dashboard');
    }

    public function resendOtp(Request $request)
    {
        $challenge = $request->session()->get('admin_login_otp');
        $admin = $challenge ? Admin::find($challenge['admin_id']) : null;

        if (! $admin) {
            $request->session()->forget('admin_login_otp');

            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Your sign-in session has expired. Please sign in again.']);
        }

        $this->sendOtp($request, $admin, (bool) $challenge['remember']);

        $message = 'A new verification code has been sent.';
        if (session('local_otp')) {
            $message .= ' (Local test code: '.session('local_otp').')';
        }

        return back()->with('status', $message);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/admin/login');
    }

    private function sendOtp(Request $request, Admin $admin, bool $remember): void
    {
        $otp = (string) random_int(100000, 999999);

        $request->session()->put('admin_login_otp', [
            'admin_id' => $admin->id,
            'code' => Hash::make($otp),
            'expires_at' => now()->addMinutes(10)->toDateTimeString(),
            'remember' => $remember,
            'attempts' => 0,
        ]);

        if (app()->environment('local') || config('mail.default') === 'log') {
            $request->session()->flash('local_otp', $otp);
        }

        try {
            Mail::to($admin->email)->send(new AdminLoginOtpMail($otp));
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
