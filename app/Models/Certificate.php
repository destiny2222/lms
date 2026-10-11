<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable([
    'enrollment_id',
    'certificate_number',
    'share_token',
    'issued_at',
    'badge_image_path',
    'pdf_path',
])]
class Certificate extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Certificate $certificate) {
            if (empty($certificate->share_token)) {
                $certificate->share_token = Str::random(32);
            }
            if (empty($certificate->certificate_number)) {
                $certificate->certificate_number = 'CERT-' . date('Y') . '-' . strtoupper(Str::random(8));
            }
            if (empty($certificate->issued_at)) {
                $certificate->issued_at = now();
            }
        });
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Public verification URL.
     */
    public function getShareUrlAttribute(): string
    {
        return route('certificates.verify', $this->share_token);
    }

    /**
     * LinkedIn Add to Profile / Share URL.
     */
    public function getLinkedinShareUrlAttribute(): string
    {
        $courseTitle = $this->enrollment->course->title ?? 'Course';
        $summary = "I just earned my certification badge for {$courseTitle}!";
        return 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($this->share_url);
    }

    /**
     * Twitter / X share URL.
     */
    public function getTwitterShareUrlAttribute(): string
    {
        $courseTitle = $this->enrollment->course->title ?? 'Course';
        $text = "🎉 I just completed and earned my certificate in {$courseTitle}! Check out my verified badge:";
        return 'https://twitter.com/intent/tweet?text=' . urlencode($text) . '&url=' . urlencode($this->share_url);
    }

    /**
     * Facebook share URL.
     */
    public function getFacebookShareUrlAttribute(): string
    {
        return 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($this->share_url);
    }

    /**
     * WhatsApp share URL.
     */
    public function getWhatsappShareUrlAttribute(): string
    {
        $courseTitle = $this->enrollment->course->title ?? 'Course';
        $text = "🎓 Hey! I just completed {$courseTitle} and earned my official Certificate of Completion! View my verified badge here: " . $this->share_url;
        return 'https://api.whatsapp.com/send?text=' . urlencode($text);
    }
}
