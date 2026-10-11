<?php

namespace App\Http\Controllers;

use App\Models\DataReward;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataRewardController extends Controller
{
    /**
     * Submit phone number and telecom provider to claim the unlocked free data subscription.
     */
    public function claim(Request $request, DataReward $reward): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($reward->user_id !== $user->id) {
            abort(403, 'Unauthorized reward action.');
        }

        if (! $reward->isUnlocked()) {
            return back()->with('info', 'This reward has already been claimed or processed.');
        }

        $validated = $request->validate([
            'phone_number' => ['required', 'string', 'min:10', 'max:15', 'regex:/^[0-9+\s\-()]+$/'],
            'network_provider' => ['required', 'string', 'in:MTN,Airtel,Glo,9mobile'],
        ], [
            'network_provider.in' => 'Please select a valid mobile network provider (MTN, Airtel, Glo, or 9mobile).',
            'phone_number.regex' => 'Please provide a valid phone number format.',
        ]);

        $reward->update([
            'phone_number' => $validated['phone_number'],
            'network_provider' => $validated['network_provider'],
            'status' => DataReward::STATUS_CLAIMED,
            'claimed_at' => now(),
        ]);

        // If student does not have phone set, save it as default
        if (empty($user->phone)) {
            $user->update(['phone' => $validated['phone_number']]);
        }

        return back()->with('success', "🎉 Milestone reward claim submitted! Your 1-Month Free Data on {$reward->network_provider} ({$reward->phone_number}) is queued for crediting.");
    }
}
