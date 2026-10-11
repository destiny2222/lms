<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataReward extends Model
{
    use HasFactory;

    public const STATUS_UNLOCKED = 'unlocked';

    public const STATUS_CLAIMED = 'claimed';

    public const STATUS_FULFILLED = 'fulfilled';

    public const NETWORKS = ['MTN', 'Airtel', 'Glo', '9mobile'];

    protected $fillable = [
        'user_id',
        'milestone_count',
        'reward_title',
        'phone_number',
        'network_provider',
        'status',
        'unlocked_at',
        'claimed_at',
        'fulfilled_at',
        'admin_notes',
    ];

    protected $casts = [
        'unlocked_at' => 'datetime',
        'claimed_at' => 'datetime',
        'fulfilled_at' => 'datetime',
        'milestone_count' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isUnlocked(): bool
    {
        return $this->status === self::STATUS_UNLOCKED;
    }

    public function isClaimed(): bool
    {
        return $this->status === self::STATUS_CLAIMED;
    }

    public function isFulfilled(): bool
    {
        return $this->status === self::STATUS_FULFILLED;
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_CLAIMED);
    }

    public function scopeFulfilled($query)
    {
        return $query->where('status', self::STATUS_FULFILLED);
    }
}
