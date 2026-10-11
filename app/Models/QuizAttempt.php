<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'enrollment_id',
    'quiz_id',
    'score_percentage',
    'is_passed',
    'answers',
    'attempted_at',
])]
class QuizAttempt extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'score_percentage' => 'integer',
            'is_passed' => 'boolean',
            'answers' => 'array',
            'attempted_at' => 'datetime',
        ];
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
