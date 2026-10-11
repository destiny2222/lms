<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'course_id',
    'lesson_id',
    'title',
    'description',
    'pass_percentage',
    'time_limit_minutes',
])]
class Quiz extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'pass_percentage' => 'integer',
            'time_limit_minutes' => 'integer',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('sort_order');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Check if a given enrollment has passed this quiz.
     */
    public function isPassedBy(Enrollment $enrollment): bool
    {
        return $this->attempts()
            ->where('enrollment_id', $enrollment->id)
            ->where('is_passed', true)
            ->exists();
    }
}
