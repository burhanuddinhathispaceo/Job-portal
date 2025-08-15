<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'logo',
        'description',
        'industry_id',
        'company_size',
        'website',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'founded_year',
        'linkedin_url',
    ];

    protected $casts = [
        'founded_year' => 'integer',
    ];

    /**
     * Get the user that owns the company
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the industry that the company belongs to
     */
    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    /**
     * Get the jobs for the company
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Get the projects for the company
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get active jobs for the company
     */
    public function activeJobs()
    {
        return $this->jobs()->where('status', 'active');
    }

    /**
     * Get active projects for the company
     */
    public function activeProjects()
    {
        return $this->projects()->where('status', 'active');
    }

    /**
     * Get company subscriptions
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get current active subscription
     */
    public function currentSubscription()
    {
        return $this->subscriptions()
                    ->where('status', 'active')
                    ->where('end_date', '>=', now())
                    ->latest()
                    ->first();
    }

    /**
     * Check if company has active subscription
     */
    public function hasActiveSubscription(): bool
    {
        return $this->currentSubscription() !== null;
    }
}
