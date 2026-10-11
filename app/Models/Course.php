<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;

#[Fillable([
    'tutor_id',
    'title',
    'slug',
    'subtitle',
    'description',
    'thumbnail',
    'badge_image',
    'level',
    'duration_hours',
    'status',
    'published_at',
])]
class Course extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'duration_hours' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Course $course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title).'-'.Str::random(5);
            }
        });
    }

    /**
     * Get the resolved URL for the course thumbnail.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if (empty($this->thumbnail)) {
            return null;
        }

        if (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://')) {
            return $this->thumbnail;
        }

        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $this->thumbnail)) {
            return "https://img.youtube.com/vi/{$this->thumbnail}/hqdefault.jpg";
        }

        if (str_starts_with($this->thumbnail, 'uploads/') || str_starts_with($this->thumbnail, 'storage/')) {
            return asset($this->thumbnail);
        }

        return asset('storage/'.ltrim($this->thumbnail, '/'));
    }

    /**
     * Get the resolved URL for the course completion badge.
     */
    public function getBadgeImageUrlAttribute(): ?string
    {
        if (empty($this->badge_image)) {
            return null;
        }

        if (str_starts_with($this->badge_image, 'http://') || str_starts_with($this->badge_image, 'https://')) {
            return $this->badge_image;
        }

        return asset($this->badge_image);
    }

    /**
     * Tutor who created this course.
     */
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    /**
     * Lessons belonging to this course ordered sequentially.
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order');
    }

    /**
     * Quizzes and tests for this course.
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Enrollments in this course.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Certificates issued for this course.
     */
    public function certificates(): HasManyThrough
    {
        return $this->hasManyThrough(Certificate::class, Enrollment::class);
    }

    /**
     * Get the final course exam/quiz if one exists.
     */
    public function finalExam(): ?Quiz
    {
        return $this->quizzes()->whereNull('lesson_id')->first()
            ?? $this->quizzes()->latest()->first();
    }
}
