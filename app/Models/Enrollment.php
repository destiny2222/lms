<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'user_id',
    'course_id',
    'enrolled_at',
    'started_at',
    'last_activity_at',
    'completed_at',
    'deadline_at',
    'status',
    'last_reminded_at',
    'reminder_count',
])]
class Enrollment extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'enrolled_at' => 'datetime',
            'started_at' => 'datetime',
            'last_activity_at' => 'datetime',
            'completed_at' => 'datetime',
            'deadline_at' => 'datetime',
            'last_reminded_at' => 'datetime',
            'reminder_count' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function lessonProgress(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    /**
     * Check if the student has started the course.
     */
    public function hasStarted(): bool
    {
        return !is_null($this->started_at);
    }

    /**
     * Check if a specific lesson is completed by this student.
     */
    public function isLessonCompleted(int $lessonId): bool
    {
        return $this->lessonProgress()
            ->where('lesson_id', $lessonId)
            ->where('is_completed', true)
            ->exists();
    }

    /**
     * Sequential unlock: Student can access the lesson if it's the first one,
     * or if all prior lessons in the course have been marked completed.
     */
    public function canAccessLesson(Lesson $lesson): bool
    {
        // If it's the first lesson in the course
        $firstLesson = $this->course->lessons()->orderBy('sort_order', 'asc')->first();
        if (!$firstLesson || $firstLesson->id === $lesson->id) {
            return true;
        }

        // Check if all previous lessons are completed
        $previousLessonsCount = $this->course->lessons()
            ->where('sort_order', '<', $lesson->sort_order)
            ->count();

        $completedPreviousCount = $this->lessonProgress()
            ->where('is_completed', true)
            ->whereIn('lesson_id', function ($query) use ($lesson) {
                $query->select('id')
                    ->from('lessons')
                    ->where('course_id', $this->course_id)
                    ->where('sort_order', '<', $lesson->sort_order);
            })
            ->count();

        return $completedPreviousCount >= $previousLessonsCount;
    }

    /**
     * Calculate progress percentage (0 - 100).
     */
    public function getProgressPercentageAttribute(): int
    {
        $totalLessons = $this->course->lessons()->count();
        if ($totalLessons === 0) {
            return 100;
        }

        $completedLessons = $this->lessonProgress()->where('is_completed', true)->count();
        return (int) min(100, round(($completedLessons / $totalLessons) * 100));
    }

    /**
     * Days since last activity or enrollment.
     */
    public function getDaysInactiveAttribute(): int
    {
        $lastDate = $this->last_activity_at ?? $this->enrolled_at ?? $this->created_at;
        return (int) now()->diffInDays($lastDate);
    }

    /**
     * Record student activity.
     */
    public function touchActivity(): void
    {
        $this->update([
            'last_activity_at' => now(),
            'started_at' => $this->started_at ?? now(),
            'status' => $this->status === 'enrolled' ? 'in_progress' : $this->status,
        ]);
    }
}
