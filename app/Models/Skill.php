<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get candidates with this skill
     */
    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'candidate_skills')
                    ->withPivot('proficiency', 'years_experience');
    }

    /**
     * Get jobs requiring this skill
     */
    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_skills')
                    ->withPivot('is_required');
    }

    /**
     * Get projects requiring this skill
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_skills')
                    ->withPivot('is_required');
    }

    /**
     * Scope active skills
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
