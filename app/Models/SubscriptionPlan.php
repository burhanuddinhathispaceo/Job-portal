<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'currency',
        'duration_days',
        'job_post_limit',
        'project_post_limit',
        'featured_posts',
        'highlighted_posts',
        'candidate_search',
        'candidate_view_limit',
        'analytics_access',
        'priority_support',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'job_post_limit' => 'integer',
        'project_post_limit' => 'integer',
        'featured_posts' => 'integer',
        'highlighted_posts' => 'integer',
        'candidate_search' => 'boolean',
        'candidate_view_limit' => 'integer',
        'analytics_access' => 'boolean',
        'priority_support' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get subscriptions for this plan
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }

    /**
     * Scope active plans
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if plan is free
     */
    public function isFree(): bool
    {
        return $this->price == 0;
    }
}
