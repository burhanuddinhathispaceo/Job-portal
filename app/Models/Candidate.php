<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'profile_picture',
        'resume_path',
        'professional_summary',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'experience_years',
        'current_salary',
        'expected_salary',
        'notice_period',
        'linkedin_url',
        'github_url',
        'portfolio_url',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'experience_years' => 'integer',
        'current_salary' => 'decimal:2',
        'expected_salary' => 'decimal:2',
        'notice_period' => 'integer',
    ];

    /**
     * Get the user that owns the candidate profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the applications for the candidate
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get the skills for the candidate
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'candidate_skills')
                    ->withPivot('proficiency', 'years_experience');
    }

    /**
     * Get candidate's full name
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get applications for jobs
     */
    public function jobApplications()
    {
        return $this->applications()->whereNotNull('job_id');
    }

    /**
     * Get applications for projects
     */
    public function projectApplications()
    {
        return $this->applications()->whereNotNull('project_id');
    }
}
