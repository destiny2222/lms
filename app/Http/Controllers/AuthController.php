<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\WhatsappService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();
            if ($user->isAdmin() || $user->isTutor()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('student.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request, WhatsappService $whatsapp): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:25'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'whatsapp_opted_in' => true,
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole('student');

        Auth::login($user);

        // Send Welcome WhatsApp Message if phone number was provided
        if (!empty($user->phone)) {
            $whatsapp->sendTextMessage(
                $user->phone,
                "🎉 Welcome to LMS, {$user->name}!\n\nYour student account has been created. Browse our courses and start learning today:\n" . route('courses.index') . "\n\nReply *HELP* anytime for bot commands!",
                $user,
                'welcome_registration'
            );
        }

        return redirect()->route('student.dashboard')->with('success', 'Account created successfully! Welcome to the LMS.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
