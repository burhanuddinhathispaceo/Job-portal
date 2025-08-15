<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            IndustrySeeder::class,
            JobTypeSeeder::class,
            ProjectTypeSeeder::class,
            SkillSeeder::class,
            SubscriptionPlanSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
