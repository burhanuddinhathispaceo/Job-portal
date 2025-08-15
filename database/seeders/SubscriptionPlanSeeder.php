<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free Plan',
                'description' => 'Basic plan with limited features for small businesses',
                'price' => 0.00,
                'currency' => 'USD',
                'duration_days' => 30,
                'job_post_limit' => 3,
                'project_post_limit' => 3,
                'featured_posts' => 0,
                'highlighted_posts' => 0,
                'candidate_search' => false,
                'candidate_view_limit' => 5,
                'analytics_access' => false,
                'priority_support' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Starter Plan',
                'description' => 'Perfect for growing companies with moderate hiring needs',
                'price' => 49.99,
                'currency' => 'USD',
                'duration_days' => 30,
                'job_post_limit' => 10,
                'project_post_limit' => 10,
                'featured_posts' => 2,
                'highlighted_posts' => 5,
                'candidate_search' => true,
                'candidate_view_limit' => 50,
                'analytics_access' => true,
                'priority_support' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Professional Plan',
                'description' => 'Advanced features for established companies with active hiring',
                'price' => 99.99,
                'currency' => 'USD',
                'duration_days' => 30,
                'job_post_limit' => 50,
                'project_post_limit' => 50,
                'featured_posts' => 10,
                'highlighted_posts' => 25,
                'candidate_search' => true,
                'candidate_view_limit' => 200,
                'analytics_access' => true,
                'priority_support' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Enterprise Plan',
                'description' => 'Unlimited access for large organizations with extensive hiring needs',
                'price' => 199.99,
                'currency' => 'USD',
                'duration_days' => 30,
                'job_post_limit' => -1, // Unlimited
                'project_post_limit' => -1, // Unlimited
                'featured_posts' => -1, // Unlimited
                'highlighted_posts' => -1, // Unlimited
                'candidate_search' => true,
                'candidate_view_limit' => -1, // Unlimited
                'analytics_access' => true,
                'priority_support' => true,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['name' => $plan['name']],
                $plan
            );
        }
    }
}
