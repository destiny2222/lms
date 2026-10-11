<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataReward;
use App\Services\WhatsappService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DataRewardController extends Controller
{
    /**
     * Display all student milestone data rewards and claims.
     */
    public function index(Request $request): View
    {
        $query = DataReward::with(['user'])->latest();

        $status = $request->get('status', 'all');
        if (in_array($status, [DataReward::STATUS_UNLOCKED, DataReward::STATUS_CLAIMED, DataReward::STATUS_FULFILLED], true)) {
            $query->where('status', $status);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('phone_number', 'like', "%{$search}%")
                    ->orWhere('network_provider', 'like', "%{$search}%")
                    ->orWhere('admin_notes', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        $rewards = $query->paginate(15)->withQueryString();

        $metrics = [
            'total_qualified' => DataReward::count(),
            'pending_claims' => DataReward::where('status', DataReward::STATUS_CLAIMED)->count(),
            'fulfilled_rewards' => DataReward::where('status', DataReward::STATUS_FULFILLED)->count(),
            'unclaimed_rewards' => DataReward::where('status', DataReward::STATUS_UNLOCKED)->count(),
        ];

        return view('admin.rewards.index', compact('rewards', 'metrics', 'status'));
    }

    /**
     * Mark a student's data subscription claim as credited/fulfilled.
     */
    public function fulfill(Request $request, DataReward $reward, WhatsappService $whatsapp): RedirectResponse
    {
        $validated = $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $reward->update([
            'status' => DataReward::STATUS_FULFILLED,
            'fulfilled_at' => now(),
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        // Send celebration via WhatsApp
        $whatsapp->sendDataRewardFulfilled($reward);

        return back()->with('success', "✅ 1-Month Free Data Reward marked as fulfilled for {$reward->user->name}! Student has been notified.");
    }
}
