<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'requirements',
        'deliverables',
        'project_type_id',
        'budget_min',
        'budget_max',
        'budget_currency',
        'duration_value',
        'duration_unit',
        'start_date',
        'application_deadline',
        'status',
        'visibility',
        'views_count',
        'applications_count',
        'published_at',
    ];

    protected $casts = [
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'duration_value' => 'integer',
        'views_count' => 'integer',
        'applications_count' => 'integer',
        'start_date' => 'date',
        'application_deadline' => 'date',
        'published_at' => 'datetime',
    ];

    /**
     * Get the company that owns the project
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the project type
     */
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }

    /**
     * Get the applications for the project
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get the skills for the project
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'project_skills')
                    ->withPivot('is_required');
    }

    /**
     * Scope active projects
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }
}
