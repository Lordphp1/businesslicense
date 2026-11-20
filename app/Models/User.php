<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'company',
        'investor_type',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Enquiries submitted by this investor.
     *
     * @return HasMany<Enquiry, $this>
     */
    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class);
    }

    /**
     * Enquiries assigned to this staff member.
     *
     * @return HasMany<Enquiry, $this>
     */
    public function assignedEnquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class, 'assigned_to');
    }

    /**
     * Whether the investor has completed the onboarding profile.
     */
    public function hasCompletedProfile(): bool
    {
        return $this->onboarding_completed_at !== null;
    }

    /**
     * Whether this account can access the staff back office.
     */
    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
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
            'onboarding_completed_at' => 'datetime',
            'is_admin' => 'boolean',
            'password' => 'hashed',
        ];
    }
}
