<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Company;
use App\Models\Candidate;
use App\Models\Industry;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Job;
use App\Models\Project;
use App\Models\JobType;
use App\Models\Skill;
use Carbon\Carbon;
use Faker\Factory as Faker;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Create Industries
        $industries = [
            'Technology', 'Healthcare', 'Finance', 'Education', 'Manufacturing',
            'Retail', 'Construction', 'Hospitality', 'Transportation', 'Real Estate',
            'Marketing', 'Consulting', 'Legal', 'Non-Profit', 'Government'
        ];
        
        foreach ($industries as $industry) {
            Industry::firstOrCreate(
                ['name' => $industry],
                [
                    'slug' => Str::slug($industry),
                    'is_active' => true
                ]
            );
        }
        
        // Create Job Types
        $jobTypes = [
            ['name' => 'Full-time', 'slug' => 'full-time'],
            ['name' => 'Part-time', 'slug' => 'part-time'],
            ['name' => 'Contract', 'slug' => 'contract'],
            ['name' => 'Freelance', 'slug' => 'freelance'],
            ['name' => 'Internship', 'slug' => 'internship'],
            ['name' => 'Remote', 'slug' => 'remote'],
            ['name' => 'On-site', 'slug' => 'on-site'],
            ['name' => 'Hybrid', 'slug' => 'hybrid']
        ];
        
        foreach ($jobTypes as $type) {
            JobType::firstOrCreate(
                ['slug' => $type['slug']],
                ['name' => $type['name'], 'is_active' => true]
            );
        }
        
        // Create Skills
        $skills = [
            'PHP', 'Laravel', 'Vue.js', 'React', 'JavaScript', 'Python', 'Java',
            'C++', 'C#', '.NET', 'Node.js', 'Angular', 'MySQL', 'PostgreSQL',
            'MongoDB', 'Redis', 'Docker', 'Kubernetes', 'AWS', 'Azure', 'GCP',
            'Git', 'CI/CD', 'Agile', 'Scrum', 'Project Management', 'Data Analysis',
            'Machine Learning', 'AI', 'DevOps', 'UI/UX Design', 'Photoshop',
            'Illustrator', 'Figma', 'Marketing', 'SEO', 'Content Writing',
            'Sales', 'Customer Service', 'Communication', 'Leadership'
        ];
        
        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill]);
        }
        
        // First, let's insert into subscription_plans table (not plans table)
        // Create Subscription Plans
        $plans = [
            [
                'name' => 'Free Plan',
                'slug' => 'free',
                'price' => 0,
                'currency' => 'USD',
                'duration_days' => 365,
                'job_post_limit' => 3,
                'project_post_limit' => 3,
                'featured_posts' => 0,
                'highlighted_posts' => 0,
                'candidate_search' => false,
                'candidate_view_limit' => 10,
                'analytics_access' => false,
                'priority_support' => false,
                'description' => 'Basic features for small companies',
                'is_active' => true
            ],
            [
                'name' => 'Basic Plan',
                'slug' => 'basic',
                'price' => 49.99,
                'currency' => 'USD',
                'duration_days' => 30,
                'job_post_limit' => 10,
                'project_post_limit' => 10,
                'featured_posts' => 2,
                'highlighted_posts' => 2,
                'candidate_search' => true,
                'candidate_view_limit' => 50,
                'analytics_access' => false,
                'priority_support' => true,
                'description' => 'Perfect for growing companies',
                'is_active' => true
            ],
            [
                'name' => 'Professional Plan',
                'slug' => 'professional',
                'price' => 99.99,
                'currency' => 'USD',
                'duration_days' => 30,
                'job_post_limit' => 25,
                'project_post_limit' => 25,
                'featured_posts' => 5,
                'highlighted_posts' => 5,
                'candidate_search' => true,
                'candidate_view_limit' => 200,
                'analytics_access' => true,
                'priority_support' => true,
                'description' => 'Advanced features for established companies',
                'is_active' => true
            ],
            [
                'name' => 'Enterprise Plan',
                'slug' => 'enterprise',
                'price' => 299.99,
                'currency' => 'USD',
                'duration_days' => 30,
                'job_post_limit' => 9999, // Unlimited
                'project_post_limit' => 9999, // Unlimited
                'featured_posts' => 20,
                'highlighted_posts' => 20,
                'candidate_search' => true,
                'candidate_view_limit' => 9999, // Unlimited
                'analytics_access' => true,
                'priority_support' => true,
                'description' => 'Complete solution for large enterprises',
                'is_active' => true
            ]
        ];
        
        foreach ($plans as $plan) {
            SubscriptionPlan::firstOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
        
        // Create Companies with Users and Subscriptions
        $companySizes = ['1-10', '11-50', '51-200', '201-500', '500+'];
        $plans = SubscriptionPlan::all();
        $industries = Industry::all();
        
        for ($i = 1; $i <= 20; $i++) {
            // Create company user
            $user = User::create([
                'name' => $faker->company,
                'email' => 'company' . $i . '@example.com',
                'password' => Hash::make('password123'),
                'role' => 'company',
                'status' => 'active',
                'email_verified_at' => now(),
                'mobile' => $faker->phoneNumber,
            ]);
            
            // Create company profile
            $company = Company::create([
                'user_id' => $user->id,
                'company_name' => $user->name,
                'description' => $faker->paragraph(5),
                'industry_id' => $industries->random()->id,
                'company_size' => $faker->randomElement($companySizes),
                'website' => $faker->url,
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'country' => $faker->country,
                'postal_code' => $faker->postcode,
                'founded_year' => $faker->numberBetween(1980, 2023),
                'linkedin_url' => 'https://linkedin.com/company/' . Str::slug($user->name),
                'verification_status' => $faker->randomElement(['pending', 'verified', 'rejected']),
                'verified_at' => $faker->boolean(70) ? now() : null,
            ]);
            
            // Assign subscription plan
            $selectedPlan = $plans->random();
            if ($selectedPlan->price > 0) {
                Subscription::create([
                    'company_id' => $company->id,
                    'plan_id' => $selectedPlan->id,
                    'start_date' => now(),
                    'end_date' => now()->addDays($selectedPlan->duration_days),
                    'status' => 'active',
                    'amount_paid' => $selectedPlan->price,
                    'currency' => $selectedPlan->currency,
                    'payment_method' => $faker->randomElement(['credit_card', 'paypal', 'stripe']),
                    'transaction_id' => 'TRX' . strtoupper(Str::random(10)),
                ]);
            }
        }
        
        // Create Candidates with Users
        for ($i = 1; $i <= 50; $i++) {
            // Create candidate user
            $user = User::create([
                'name' => $faker->firstName . ' ' . $faker->lastName,
                'email' => 'candidate' . $i . '@example.com',
                'password' => Hash::make('password123'),
                'role' => 'candidate',
                'status' => 'active',
                'email_verified_at' => now(),
                'mobile' => $faker->phoneNumber,
            ]);
            
            // Create candidate profile
            $candidate = Candidate::create([
                'user_id' => $user->id,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'date_of_birth' => $faker->dateTimeBetween('-50 years', '-20 years'),
                'gender' => $faker->randomElement(['male', 'female', 'other']),
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'country' => $faker->country,
                'postal_code' => $faker->postcode,
                'experience_years' => $faker->numberBetween(0, 25),
                'current_salary' => $faker->numberBetween(30000, 150000),
                'expected_salary' => $faker->numberBetween(35000, 200000),
                'professional_summary' => $faker->paragraph(3),
                'notice_period' => $faker->numberBetween(0, 90),
                'linkedin_url' => 'https://linkedin.com/in/' . Str::slug($user->name),
                'github_url' => 'https://github.com/' . Str::slug($user->name),
                'portfolio_url' => $faker->boolean(50) ? $faker->url : null,
                'profile_completion' => $faker->numberBetween(60, 100),
                'profile_views' => $faker->numberBetween(0, 500),
                'resume_downloads' => $faker->numberBetween(0, 50),
            ]);
            
            // Attach random skills
            $randomSkills = Skill::inRandomOrder()->limit(rand(3, 10))->pluck('id');
            $candidate->skills()->attach($randomSkills);
        }
        
        // Create Jobs
        $companies = Company::all();
        $jobTypes = JobType::all();
        $jobTitles = [
            'Senior Software Engineer', 'Frontend Developer', 'Backend Developer',
            'Full Stack Developer', 'DevOps Engineer', 'Data Scientist',
            'Product Manager', 'UI/UX Designer', 'Marketing Manager',
            'Sales Executive', 'Business Analyst', 'Project Manager',
            'HR Manager', 'Content Writer', 'SEO Specialist'
        ];
        
        for ($i = 1; $i <= 50; $i++) {
            $company = $companies->random();
            $minSalary = $faker->numberBetween(30000, 80000);
            $maxSalary = $minSalary + $faker->numberBetween(10000, 40000);
            
            $job = Job::create([
                'company_id' => $company->id,
                'title' => $faker->randomElement($jobTitles),
                'slug' => Str::slug($faker->randomElement($jobTitles) . '-' . $i),
                'description' => $faker->paragraph(10),
                'requirements' => $faker->paragraph(5),
                'benefits' => $faker->paragraph(3),
                'job_type_id' => $jobTypes->random()->id,
                'experience_level' => $faker->randomElement(['entry', 'mid', 'senior', 'executive']),
                'min_experience' => $faker->numberBetween(0, 5),
                'max_experience' => $faker->numberBetween(5, 15),
                'min_salary' => $minSalary,
                'max_salary' => $maxSalary,
                'currency' => 'USD',
                'location_type' => $faker->randomElement(['onsite', 'remote', 'hybrid']),
                'address' => $company->address,
                'city' => $company->city,
                'state' => $company->state,
                'country' => $company->country,
                'postal_code' => $company->postal_code,
                'deadline' => $faker->dateTimeBetween('now', '+3 months'),
                'status' => $faker->randomElement(['active', 'inactive', 'expired']),
                'is_featured' => $faker->boolean(20),
                'is_highlighted' => $faker->boolean(10),
                'views_count' => $faker->numberBetween(0, 1000),
                'applications_count' => $faker->numberBetween(0, 100),
            ]);
            
            // Attach random skills
            $randomSkills = Skill::inRandomOrder()->limit(rand(3, 8))->pluck('id');
            $job->skills()->attach($randomSkills);
        }
        
        // Create Projects
        $projectTitles = [
            'E-commerce Website Development', 'Mobile App Development',
            'Website Redesign', 'API Integration', 'Database Optimization',
            'Logo Design', 'Marketing Campaign', 'Content Creation',
            'SEO Optimization', 'Social Media Management', 'Data Analysis',
            'Business Consultation', 'Video Editing', 'Translation Services'
        ];
        
        for ($i = 1; $i <= 50; $i++) {
            $company = $companies->random();
            $minBudget = $faker->numberBetween(500, 5000);
            $maxBudget = $minBudget + $faker->numberBetween(1000, 10000);
            
            $project = Project::create([
                'company_id' => $company->id,
                'title' => $faker->randomElement($projectTitles),
                'slug' => Str::slug($faker->randomElement($projectTitles) . '-' . $i),
                'description' => $faker->paragraph(10),
                'requirements' => $faker->paragraph(5),
                'project_type' => $faker->randomElement(['fixed', 'hourly']),
                'min_budget' => $minBudget,
                'max_budget' => $maxBudget,
                'currency' => 'USD',
                'duration' => $faker->randomElement(['1 week', '2 weeks', '1 month', '2 months', '3 months', '6 months']),
                'experience_level' => $faker->randomElement(['beginner', 'intermediate', 'expert']),
                'deadline' => $faker->dateTimeBetween('now', '+2 months'),
                'status' => $faker->randomElement(['active', 'inactive', 'completed', 'cancelled']),
                'is_featured' => $faker->boolean(20),
                'is_highlighted' => $faker->boolean(10),
                'views_count' => $faker->numberBetween(0, 500),
                'proposals_count' => $faker->numberBetween(0, 50),
            ]);
            
            // Attach random skills
            $randomSkills = Skill::inRandomOrder()->limit(rand(2, 6))->pluck('id');
            $project->skills()->attach($randomSkills);
        }
        
        // Create Admin Users
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
                'mobile' => '+1234567890',
            ]
        );
        
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
                'mobile' => '+1234567891',
            ]
        );
        
        $this->command->info('Test data seeded successfully!');
        $this->command->info('Admin Logins:');
        $this->command->info('  - admin@gmail.com / 123456');
        $this->command->info('  - admin@example.com / admin123');
        $this->command->info('Company Logins: company1@example.com to company20@example.com / password123');
        $this->command->info('Candidate Logins: candidate1@example.com to candidate50@example.com / password123');
    }
}