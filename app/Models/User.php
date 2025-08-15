<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'mobile',
        'status',
        'preferred_locale',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
    ];

    /**
     * Get the company profile for the user (if role is company)
     */
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    /**
     * Get the candidate profile for the user (if role is candidate)
     */
    public function candidate()
    {
        return $this->hasOne(Candidate::class);
    }

    /**
     * Get user's bookmarks
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is company
     */
    public function isCompany(): bool
    {
        return $this->hasRole('company');
    }

    /**
     * Check if user is candidate
     */
    public function isCandidate(): bool
    {
        return $this->hasRole('candidate');
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get user activities
     */
    public function activities()
    {
        return $this->hasMany(UserActivity::class);
    }

    /**
     * Check if user has permission
     * Admin role has ALL permissions
     */
    public function hasPermission(string $permission): bool
    {
        // Admin has ALL permissions - always return true
        if ($this->role === 'admin') {
            return true;
        }

        // Add more granular permission logic here if needed
        // For now, we'll use role-based permissions for other roles
        $rolePermissions = [
            'company' => [
                'jobs.create', 'jobs.edit', 'jobs.delete',
                'projects.create', 'projects.edit', 'projects.delete',
                'applications.view', 'applications.manage',
                'company.edit', 'company.view'
            ],
            'candidate' => [
                'jobs.apply', 'projects.apply',
                'profile.edit', 'profile.view',
                'applications.view'
            ]
        ];

        $userPermissions = $rolePermissions[$this->role] ?? [];
        return in_array($permission, $userPermissions);
    }

    /**
     * Check if user can access admin panel
     */
    public function canAccessAdmin(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Get user's full name
     */
    public function getFullNameAttribute(): string
    {
        if ($this->isCandidate() && $this->candidate) {
            return $this->candidate->first_name . ' ' . $this->candidate->last_name;
        }
        return $this->name;
    }

    /**
     * Get user's profile photo URL
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        // Return default avatar for now
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
}
