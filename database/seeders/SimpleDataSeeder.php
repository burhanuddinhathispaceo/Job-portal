<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Company;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\Project;
use App\Models\Application;
use Faker\Factory as Faker;

class SimpleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Create 10 companies
        echo "Creating companies...\n";
        $companies = [];
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => $faker->company,
                'email' => 'testcompany' . $i . '@example.com',
                'password' => Hash::make('password123'),
                'role' => 'company',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
            
            $company = Company::create([
                'user_id' => $user->id,
                'company_name' => $user->name,
                'description' => $faker->paragraph(3),
                'website' => $faker->url,
                'city' => $faker->city,
                'state' => $faker->state,
                'country' => $faker->country,
                'verification_status' => 'verified',
                'verified_at' => now(),
            ]);
            
            $companies[] = $company;
        }
        
        // Create 50 candidates
        echo "Creating candidates...\n";
        $candidates = [];
        for ($i = 1; $i <= 50; $i++) {
            $user = User::create([
                'name' => $faker->firstName . ' ' . $faker->lastName,
                'email' => 'testcandidate' . $i . '@example.com',
                'password' => Hash::make('password123'),
                'role' => 'candidate',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
            
            $candidate = Candidate::create([
                'user_id' => $user->id,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'professional_summary' => $faker->paragraph(2),
                'city' => $faker->city,
                'state' => $faker->state,
                'country' => $faker->country,
                'experience_years' => rand(0, 15),
                'current_salary' => rand(30000, 100000),
                'expected_salary' => rand(35000, 120000),
                'profile_completion' => rand(50, 100),
            ]);
            
            $candidates[] = $candidate;
        }
        
        // Create 50 jobs
        echo "Creating jobs...\n";
        $jobs = [];
        $jobTitles = [
            'Software Engineer', 'Frontend Developer', 'Backend Developer',
            'Full Stack Developer', 'DevOps Engineer', 'Data Scientist',
            'Product Manager', 'UI/UX Designer', 'Marketing Manager',
            'Sales Executive', 'Business Analyst', 'Project Manager'
        ];
        
        for ($i = 1; $i <= 50; $i++) {
            $company = $companies[array_rand($companies)];
            
            $job = Job::create([
                'company_id' => $company->id,
                'title' => $jobTitles[array_rand($jobTitles)],
                'description' => $faker->paragraph(5),
                'requirements' => $faker->paragraph(3),
                'responsibilities' => $faker->paragraph(3),
                'location' => $company->city . ', ' . $company->state,
                'is_remote' => $faker->boolean(30),
                'salary_min' => rand(30000, 60000),
                'salary_max' => rand(60000, 150000),
                'salary_currency' => 'USD',
                'experience_min' => rand(0, 5),
                'experience_max' => rand(5, 15),
                'education_level' => $faker->randomElement(['High School', 'Bachelor', 'Master', 'PhD']),
                'application_deadline' => $faker->dateTimeBetween('now', '+3 months'),
                'status' => $faker->randomElement(['active', 'inactive', 'draft']),
                'visibility' => $faker->randomElement(['normal', 'highlighted', 'featured']),
                'views_count' => rand(0, 500),
                'applications_count' => 0,
                'published_at' => now(),
            ]);
            
            $jobs[] = $job;
        }
        
        // Create 50 projects
        echo "Creating projects...\n";
        $projects = [];
        $projectTitles = [
            'E-commerce Website', 'Mobile App Development',
            'Website Redesign', 'API Integration', 'Database Design',
            'Logo Design', 'Marketing Campaign', 'Content Creation',
            'SEO Optimization', 'Social Media Management'
        ];
        
        for ($i = 1; $i <= 50; $i++) {
            $company = $companies[array_rand($companies)];
            
            $project = Project::create([
                'company_id' => $company->id,
                'title' => $projectTitles[array_rand($projectTitles)],
                'description' => $faker->paragraph(5),
                'requirements' => $faker->paragraph(3),
                'deliverables' => $faker->paragraph(2),
                'budget_min' => rand(500, 5000),
                'budget_max' => rand(5000, 50000),
                'budget_currency' => 'USD',
                'duration_value' => rand(1, 6),
                'duration_unit' => $faker->randomElement(['days', 'weeks', 'months']),
                'start_date' => $faker->dateTimeBetween('now', '+1 month'),
                'application_deadline' => $faker->dateTimeBetween('now', '+2 months'),
                'status' => $faker->randomElement(['active', 'inactive', 'draft']),
                'visibility' => $faker->randomElement(['normal', 'highlighted', 'featured']),
                'views_count' => rand(0, 300),
                'applications_count' => 0,
                'published_at' => now(),
            ]);
            
            $projects[] = $project;
        }
        
        // Create applications for jobs
        echo "Creating job applications...\n";
        foreach ($jobs as $job) {
            $numApplications = rand(0, 10);
            $applicants = $faker->randomElements($candidates, min($numApplications, count($candidates)));
            
            foreach ($applicants as $candidate) {
                Application::create([
                    'candidate_id' => $candidate->id,
                    'job_id' => $job->id,
                    'cover_letter' => $faker->paragraph(2),
                    'status' => $faker->randomElement(['applied', 'viewed', 'shortlisted', 'rejected']),
                    'applied_at' => $faker->dateTimeBetween('-1 month', 'now'),
                ]);
            }
            
            // Update application count
            $job->update(['applications_count' => $numApplications]);
        }
        
        // Create applications for projects
        echo "Creating project proposals...\n";
        foreach ($projects as $project) {
            $numProposals = rand(0, 8);
            $applicants = $faker->randomElements($candidates, min($numProposals, count($candidates)));
            
            foreach ($applicants as $candidate) {
                Application::create([
                    'candidate_id' => $candidate->id,
                    'project_id' => $project->id,
                    'cover_letter' => $faker->paragraph(2),
                    'status' => $faker->randomElement(['applied', 'viewed', 'shortlisted', 'rejected']),
                    'applied_at' => $faker->dateTimeBetween('-1 month', 'now'),
                ]);
            }
            
            // Update applications count
            $project->update(['applications_count' => $numProposals]);
        }
        
        echo "\n=== Seeding Complete! ===\n";
        echo "Created:\n";
        echo "- 10 Companies (testcompany1@example.com to testcompany10@example.com)\n";
        echo "- 50 Candidates (testcandidate1@example.com to testcandidate50@example.com)\n";
        echo "- 50 Jobs with applications\n";
        echo "- 50 Projects with proposals\n";
        echo "All passwords: password123\n";
    }
}