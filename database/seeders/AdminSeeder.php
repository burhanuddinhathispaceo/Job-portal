<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        \App\Models\Admin::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'System Administrator',
                'email' => 'admin@gmail.com',
                'password' => '123456', // Will be hashed automatically by the model
                'status' => 'active',
                'permissions' => [
                    'users.manage',
                    'companies.manage',
                    'candidates.manage',
                    'jobs.manage',
                    'projects.manage',
                    'subscriptions.manage',
                    'website.customize',
                    'system.configure',
                    'analytics.view',
                    'content.moderate'
                ],
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Create additional admin users for testing
        \App\Models\Admin::updateOrCreate(
            ['email' => 'moderator@gmail.com'],
            [
                'name' => 'Content Moderator',
                'email' => 'moderator@gmail.com',
                'password' => '123456',
                'status' => 'active',
                'permissions' => [
                    'jobs.manage',
                    'projects.manage',
                    'content.moderate',
                    'users.view'
                ],
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
