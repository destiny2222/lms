<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_title',
        'section_title_highlight',
        'form_title',
        'form_subtitle',
        'phone_primary',
        'phone_secondary',
        'email',
        'address',
        'weekday_hours',
        'weekend_hours',
        'whatsapp_number',
        'contact_image',
    ];

    /**
     * Retrieve the singleton contact settings instance.
     */
    public static function getSettings(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }

    /**
     * Get clean telephone string for phone_primary tel: links.
     */
    public function getPhonePrimaryTelAttribute(): string
    {
        return preg_replace('/[^0-9+]/', '', (string) $this->phone_primary);
    }

    /**
     * Get clean telephone string for phone_secondary tel: links.
     */
    public function getPhoneSecondaryTelAttribute(): string
    {
        return preg_replace('/[^0-9+]/', '', (string) $this->phone_secondary);
    }

    /**
     * Get resolved image URL for contact page image.
     */
    public function getContactImageUrlAttribute(): string
    {
        if (! empty($this->contact_image)) {
            if (str_starts_with($this->contact_image, 'http://') || str_starts_with($this->contact_image, 'https://')) {
                return $this->contact_image;
            }

            if (str_starts_with($this->contact_image, 'assets/') || str_starts_with($this->contact_image, 'storage/')) {
                return asset($this->contact_image);
            }

            return asset('storage/'.ltrim($this->contact_image, '/'));
        }

        return asset('assets/images/profile-image.jpg');
    }
}
