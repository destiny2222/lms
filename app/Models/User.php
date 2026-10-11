<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'phone', 'whatsapp_opted_in', 'avatar', 'bio'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin() || $this->isTutor();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'whatsapp_opted_in' => 'boolean',
        ];
    }

    /**
     * Course enrollments for this user.
     *
     * @return HasMany<Enrollment>
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Courses the user is actively enrolled in.
     *
     * @return BelongsToMany<Course>
     */
    public function enrolledCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'enrollments')
            ->withPivot(['id', 'status', 'enrolled_at', 'started_at', 'completed_at', 'deadline_at'])
            ->withTimestamps();
    }

    /**
     * Courses taught by this tutor.
     *
     * @return HasMany<Course>
     */
    public function tutoredCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'tutor_id');
    }

    /**
     * WhatsApp communication log for this user.
     *
     * @return HasMany<WhatsappMessage>
     */
    public function whatsappMessages(): HasMany
    {
        return $this->hasMany(WhatsappMessage::class);
    }

    /**
     * Check if user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is a tutor.
     */
    public function isTutor(): bool
    {
        return $this->hasRole('tutor');
    }

    /**
     * Check if user is a student.
     */
    public function isStudent(): bool
    {
        return $this->hasRole('student') || (! $this->hasRole('admin') && ! $this->hasRole('tutor'));
    }

    /**
     * Get user avatar public URL.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if (! $this->avatar) {
            return null;
        }

        if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
            return $this->avatar;
        }

        return asset('storage/'.$this->avatar);
    }

    /**
     * Data milestone rewards for this user.
     *
     * @return HasMany<DataReward>
     */
    public function dataRewards(): HasMany
    {
        return $this->hasMany(DataReward::class);
    }
}
