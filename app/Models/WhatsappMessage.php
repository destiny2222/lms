<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'direction',
    'phone_number',
    'message_type',
    'message_body',
    'meta_message_id',
    'trigger_type',
    'status',
    'error_message',
])]
class WhatsappMessage extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isOutbound(): bool
    {
        return $this->direction === 'outbound';
    }

    public function isInbound(): bool
    {
        return $this->direction === 'inbound';
    }
}
