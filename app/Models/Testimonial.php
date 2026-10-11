<?php

namespace App\Models;

use Database\Factories\TestimonialFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    /** @use HasFactory<TestimonialFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'designation',
        'content',
        'image',
        'rating',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Scope to retrieve only active testimonials.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the resolved URL for the reviewer's avatar image.
     */
    public function getAvatarUrlAttribute(): string
    {
        if (! empty($this->image)) {
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                return $this->image;
            }

            if (str_starts_with($this->image, 'assets/') || str_starts_with($this->image, 'storage/')) {
                return asset($this->image);
            }

            return asset('storage/'.ltrim($this->image, '/'));
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=eff6ff&color=2563eb&bold=true&size=128';
    }
}
