<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'job_id',
        'project_id',
        'cover_letter',
        'resume_path',
        'status',
        'company_notes',
        'rejection_reason',
        'applied_at',
        'viewed_at',
        'responded_at',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'viewed_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    /**
     * Get the candidate that owns the application
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    /**
     * Get the job (if this is a job application)
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Get the project (if this is a project application)
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the applicable item (job or project)
     */
    public function applicable()
    {
        return $this->job ?? $this->project;
    }

    /**
     * Scope for job applications
     */
    public function scopeForJobs($query)
    {
        return $query->whereNotNull('job_id');
    }

    /**
     * Scope for project applications
     */
    public function scopeForProjects($query)
    {
        return $query->whereNotNull('project_id');
    }

    /**
     * Scope by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Mark as viewed
     */
    public function markAsViewed()
    {
        $this->update(['viewed_at' => now()]);
    }

    /**
     * Mark as responded
     */
    public function markAsResponded()
    {
        $this->update(['responded_at' => now()]);
    }
}
