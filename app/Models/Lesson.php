<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

#[Fillable([
    'course_id',
    'title',
    'slug',
    'description',
    'video_url',
    'video_provider',
    'video_duration_minutes',
    'sort_order',
    'is_free_preview',
])]
class Lesson extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'video_duration_minutes' => 'integer',
            'sort_order' => 'integer',
            'is_free_preview' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Lesson $lesson) {
            if (empty($lesson->slug)) {
                $lesson->slug = Str::slug($lesson->title).'-'.Str::random(5);
            }
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function quiz(): HasOne
    {
        return $this->hasOne(Quiz::class);
    }

    public function progressRecords(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function nextLesson(): ?Lesson
    {
        return static::where('course_id', $this->course_id)
            ->where('sort_order', '>', $this->sort_order)
            ->orderBy('sort_order', 'asc')
            ->first();
    }

    public function previousLesson(): ?Lesson
    {
        return static::where('course_id', $this->course_id)
            ->where('sort_order', '<', $this->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first();
    }

    /**
     * Generate secure online-only video embed HTML with download disabled.
     */
    public function getEmbedPlayerHtmlAttribute(): string
    {
        $url = $this->video_url;

        // YouTube
        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
            $videoId = $matches[1] ?? '';

            return '<iframe class="w-100 h-100 rounded-3" style="min-height: 480px;" src="https://www.youtube-nocookie.com/embed/'.htmlspecialchars($videoId).'?rel=0&modestbranding=1&controls=1" title="'.htmlspecialchars($this->title).'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        }

        // Vimeo
        if (str_contains($url, 'vimeo.com')) {
            preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)/', $url, $matches);
            $videoId = $matches[3] ?? '';

            return '<iframe class="w-100 h-100 rounded-3" style="min-height: 480px;" src="https://player.vimeo.com/video/'.htmlspecialchars($videoId).'?dnt=1&app_id=122963" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
        }

        // Cloudinary video stream with automated poster and protected HTML5 player
        if (str_contains($url, 'cloudinary.com') || $this->video_provider === 'cloudinary') {
            $posterUrl = str_ends_with($url, '.mp4') ? str_replace('.mp4', '.jpg', $url) : '';
            $posterAttr = $posterUrl ? ' poster="'.htmlspecialchars($posterUrl).'"' : '';

            return '<video class="w-100 h-100 rounded-3" style="min-height: 480px; background: #000;" controls controlsList="nodownload noplaybackrate" oncontextmenu="return false;" preload="metadata" playsinline'.$posterAttr.' src="'.htmlspecialchars($url).'">Your browser does not support HTML5 video streaming.</video>';
        }

        // Direct stream / HLS / MP4 with controlsList="nodownload" and contextmenu disabled
        return '<video class="w-100 h-100 rounded-3" style="min-height: 480px; background: #000;" controls controlsList="nodownload noplaybackrate" oncontextmenu="return false;" src="'.htmlspecialchars($url).'">Your browser does not support the video tag.</video>';
    }
}
