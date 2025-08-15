<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'requirements',
        'responsibilities',
        'job_type_id',
        'location',
        'is_remote',
        'salary_min',
        'salary_max',
        'salary_currency',
        'experience_min',
        'experience_max',
        'education_level',
        'application_deadline',
        'status',
        'visibility',
        'views_count',
        'applications_count',
        'published_at',
    ];

    protected $casts = [
        'is_remote' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'experience_min' => 'integer',
        'experience_max' => 'integer',
        'views_count' => 'integer',
        'applications_count' => 'integer',
        'application_deadline' => 'date',
        'published_at' => 'datetime',
    ];

    /**
     * Get the company that owns the job
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the job type
     */
    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }

    /**
     * Get the applications for the job
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get the skills for the job
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skills')
                    ->withPivot('is_required');
    }

    /**
     * Get required skills for the job
     */
    public function requiredSkills()
    {
        return $this->skills()->wherePivot('is_required', true);
    }

    /**
     * Get preferred skills for the job
     */
    public function preferredSkills()
    {
        return $this->skills()->wherePivot('is_required', false);
    }

    /**
     * Scope active jobs
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope published jobs
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }
}
