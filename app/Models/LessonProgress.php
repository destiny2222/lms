<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'enrollment_id',
    'lesson_id',
    'is_completed',
    'watched_seconds',
    'completed_at',
])]
class LessonProgress extends Model
{
    use HasFactory;

    protected $table = 'lesson_progress';

    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
            'watched_seconds' => 'integer',
            'completed_at' => 'datetime',
        ];
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
