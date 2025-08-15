<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Programming Languages
            ['name' => 'PHP', 'category' => 'Programming Languages'],
            ['name' => 'JavaScript', 'category' => 'Programming Languages'],
            ['name' => 'Python', 'category' => 'Programming Languages'],
            ['name' => 'Java', 'category' => 'Programming Languages'],
            ['name' => 'C#', 'category' => 'Programming Languages'],
            ['name' => 'TypeScript', 'category' => 'Programming Languages'],
            ['name' => 'Go', 'category' => 'Programming Languages'],
            ['name' => 'Ruby', 'category' => 'Programming Languages'],
            
            // Frontend
            ['name' => 'Vue.js', 'category' => 'Frontend'],
            ['name' => 'React', 'category' => 'Frontend'],
            ['name' => 'Angular', 'category' => 'Frontend'],
            ['name' => 'HTML/CSS', 'category' => 'Frontend'],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend'],
            ['name' => 'Bootstrap', 'category' => 'Frontend'],
            
            // Backend
            ['name' => 'Laravel', 'category' => 'Backend'],
            ['name' => 'Node.js', 'category' => 'Backend'],
            ['name' => 'Django', 'category' => 'Backend'],
            ['name' => 'Spring Boot', 'category' => 'Backend'],
            ['name' => 'Express.js', 'category' => 'Backend'],
            
            // Databases
            ['name' => 'MySQL', 'category' => 'Databases'],
            ['name' => 'PostgreSQL', 'category' => 'Databases'],
            ['name' => 'MongoDB', 'category' => 'Databases'],
            ['name' => 'Redis', 'category' => 'Databases'],
            
            // DevOps
            ['name' => 'Docker', 'category' => 'DevOps'],
            ['name' => 'AWS', 'category' => 'DevOps'],
            ['name' => 'Git', 'category' => 'DevOps'],
            ['name' => 'CI/CD', 'category' => 'DevOps'],
            
            // Other
            ['name' => 'Project Management', 'category' => 'Soft Skills'],
            ['name' => 'Communication', 'category' => 'Soft Skills'],
            ['name' => 'Leadership', 'category' => 'Soft Skills'],
        ];

        foreach ($skills as $skill) {
            \App\Models\Skill::updateOrCreate(
                ['name' => $skill['name']],
                $skill
            );
        }
    }
}
