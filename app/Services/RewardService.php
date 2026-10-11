<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\DataReward;
use App\Models\User;

class RewardService
{
    public const MILESTONE_BADGE_COUNT = 10;

    public const REWARD_TITLE = '1 Month Free Data Subscription';

    public function __construct(
        protected WhatsappService $whatsappService
    ) {}

    /**
     * Check if user qualifies for the 10-badge milestone and automatically unlock the data reward.
     */
    public function checkAndUnlockMilestone(User $user): ?DataReward
    {
        $badgeCount = Certificate::whereHas('enrollment', fn ($q) => $q->where('user_id', $user->id))->count();

        if ($badgeCount < self::MILESTONE_BADGE_COUNT) {
            return null;
        }

        // Check if reward already exists
        $existing = DataReward::where('user_id', $user->id)
            ->where('milestone_count', self::MILESTONE_BADGE_COUNT)
            ->first();

        if ($existing) {
            return $existing;
        }

        // Create new unlocked reward
        $reward = DataReward::create([
            'user_id' => $user->id,
            'milestone_count' => self::MILESTONE_BADGE_COUNT,
            'reward_title' => self::REWARD_TITLE,
            'status' => DataReward::STATUS_UNLOCKED,
            'unlocked_at' => now(),
        ]);

        // Send celebratory WhatsApp message
        $this->whatsappService->sendDataMilestoneUnlocked($user, $reward);

        return $reward;
    }

    /**
     * Get milestone progress data for dashboard displays.
     *
     * @return array{badge_count: int, target: int, percentage: int, remaining: int, reward: ?DataReward}
     */
    public function getMilestoneProgress(User $user): array
    {
        $badgeCount = Certificate::whereHas('enrollment', fn ($q) => $q->where('user_id', $user->id))->count();
        $reward = $this->checkAndUnlockMilestone($user);

        return [
            'badge_count' => $badgeCount,
            'target' => self::MILESTONE_BADGE_COUNT,
            'percentage' => min(100, (int) round(($badgeCount / self::MILESTONE_BADGE_COUNT) * 100)),
            'remaining' => max(0, self::MILESTONE_BADGE_COUNT - $badgeCount),
            'reward' => $reward,
        ];
    }
}
