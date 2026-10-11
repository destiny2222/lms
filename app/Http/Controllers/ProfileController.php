<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the user profile editing view.
     */
    public function edit(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $enrolledCount = $user->enrollments()->count();
        $completedCount = $user->enrollments()->where('status', 'completed')->count();
        $certificatesCount = $user->enrollments()->has('certificate')->count();

        return view('student.profile', compact('user', 'enrolledCount', 'completedCount', 'certificatesCount'));
    }

    /**
     * Update user general profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp_opted_in' => ['nullable', 'boolean'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'whatsapp_opted_in' => $request->has('whatsapp_opted_in'),
            'bio' => $validated['bio'] ?? null,
        ];

        if ($request->hasFile('avatar')) {
            // Delete old avatar if stored locally
            if ($user->avatar && ! str_starts_with($user->avatar, 'http') && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return redirect()->route('student.profile')
            ->with('success', 'Your profile details have been updated successfully.');
    }

    /**
     * Update user account security password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('student.profile')
            ->with('success', 'Your password has been changed securely.');
    }
}
