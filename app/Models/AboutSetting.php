<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_title',
        'heading_prefix',
        'heading_highlight',
        'description_1',
        'description_2',
        'button_text',
        'button_link',
        'about_image',
        'stat_projects_count',
        'stat_projects_label',
        'stat_clients_count',
        'stat_clients_label',
        'stat_students_count',
        'stat_students_label',
        'stat_years_count',
        'stat_years_label',
        'help_title',
        'help_title_highlight',
        'help_title_suffix',
        'feature_1_title',
        'feature_1_desc',
        'feature_2_title',
        'feature_2_desc',
        'feature_3_title',
        'feature_3_desc',
        'feature_4_title',
        'feature_4_desc',
    ];

    /**
     * Retrieve the singleton about settings instance.
     */
    public static function getSettings(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }

    /**
     * Get resolved image URL for about page image.
     */
    public function getAboutImageUrlAttribute(): string
    {
        if (! empty($this->about_image)) {
            if (str_starts_with($this->about_image, 'http://') || str_starts_with($this->about_image, 'https://')) {
                return $this->about_image;
            }

            if (str_starts_with($this->about_image, 'assets/') || str_starts_with($this->about_image, 'storage/')) {
                return asset($this->about_image);
            }

            return asset('storage/'.ltrim($this->about_image, '/'));
        }

        return asset('assets/images/about-group-study.jpg');
    }
}
