<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'currency',
        'duration_days',
        'job_post_limit',
        'project_post_limit',
        'featured_job_limit',
        'featured_project_limit',
        'candidate_search_limit',
        'description',
        'features',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'features' => 'array',
        'is_active' => 'boolean',
        'job_post_limit' => 'integer',
        'project_post_limit' => 'integer',
        'featured_job_limit' => 'integer',
        'featured_project_limit' => 'integer',
        'candidate_search_limit' => 'integer',
        'duration_days' => 'integer',
    ];

    /**
     * Get the subscriptions for the plan
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Check if plan has unlimited jobs
     */
    public function hasUnlimitedJobs(): bool
    {
        return $this->job_post_limit === -1;
    }

    /**
     * Check if plan has unlimited projects
     */
    public function hasUnlimitedProjects(): bool
    {
        return $this->project_post_limit === -1;
    }

    /**
     * Check if plan has unlimited candidate search
     */
    public function hasUnlimitedCandidateSearch(): bool
    {
        return $this->candidate_search_limit === -1;
    }

    /**
     * Get active subscriptions count
     */
    public function activeSubscriptionsCount(): int
    {
        return $this->subscriptions()->where('status', 'active')->count();
    }
}