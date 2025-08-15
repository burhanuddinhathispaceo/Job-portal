<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Company;
use App\Models\JobType;
use App\Models\Industry;
use App\Models\Skill;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Admin Job Management Controller
 * Implements: REQ-ADM-005, REQ-CMP-005 to REQ-CMP-012
 * 
 * Handles job posting management, moderation, and analytics
 */
class JobController extends Controller
{
    /**
     * Display jobs list
     * Implements: REQ-ADM-005
     */
    public function index(Request $request)
    {
        $query = Job::with(['company.user', 'jobType', 'skills']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('visibility')) {
            $query->where('visibility', $request->visibility);
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('job_type_id')) {
            $query->where('job_type_id', $request->job_type_id);
        }

        if ($request->filled('is_remote')) {
            $query->where('is_remote', $request->boolean('is_remote'));
        }

        if ($request->filled('salary_min')) {
            $query->where('salary_max', '>=', $request->salary_min);
        }

        if ($request->filled('salary_max')) {
            $query->where('salary_min', '<=', $request->salary_max);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhereHas('company', function ($companyQuery) use ($searchTerm) {
                      $companyQuery->where('company_name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $jobs = $query->orderBy('created_at', 'desc')
                     ->paginate(50);

        $stats = [
            'total_jobs' => Job::count(),
            'active_jobs' => Job::where('status', 'active')->count(),
            'pending_jobs' => Job::where('status', 'draft')->count(),
            'featured_jobs' => Job::where('visibility', 'featured')->count(),
            'remote_jobs' => Job::where('is_remote', true)->count(),
            'total_applications' => Application::whereNotNull('job_id')->count(),
        ];

        $companies = Company::select('id', 'company_name')->get();
        $jobTypes = JobType::where('is_active', true)->get();

        return view('admin.jobs.index', compact('jobs', 'stats', 'companies', 'jobTypes'));
    }

    /**
     * Show create job form
     * Implements: REQ-ADM-005
     */
    public function create()
    {
        $companies = Company::select('id', 'company_name')->get();
        $jobTypes = JobType::where('is_active', true)->get();
        $industries = Industry::where('is_active', true)->get();
        
        return view('admin.jobs.create', compact('companies', 'jobTypes', 'industries'));
    }

    /**
     * Store new job
     * Implements: REQ-ADM-005
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'job_type_id' => 'required|exists:job_types,id',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'salary_type' => 'required|in:yearly,monthly,hourly',
            'employment_type' => 'required|in:full_time,part_time,contract,freelance,internship',
            'experience_level' => 'nullable|in:entry,mid,senior,executive',
            'skills' => 'nullable|string',
            'application_deadline' => 'nullable|date|after:today',
            'available_positions' => 'required|integer|min:1|max:100',
            'status' => 'required|in:active,inactive,closed',
            'visibility' => 'required|in:public,featured,highlighted,private',
            'is_remote' => 'boolean',
            'is_urgent' => 'boolean',
            'industry_id' => 'nullable|exists:industries,id',
        ]);

        try {
            $jobData = $request->all();
            $jobData['is_remote'] = $request->boolean('is_remote');
            $jobData['is_urgent'] = $request->boolean('is_urgent');
            
            $job = Job::create($jobData);

            // Handle skills if provided
            if ($request->filled('skills')) {
                $skillNames = array_map('trim', explode(',', $request->skills));
                $skillIds = [];
                
                foreach ($skillNames as $skillName) {
                    if (!empty($skillName)) {
                        $skill = Skill::firstOrCreate(['name' => $skillName]);
                        $skillIds[] = $skill->id;
                    }
                }
                
                if (!empty($skillIds)) {
                    $job->skills()->sync($skillIds);
                }
            }

            return redirect()
                ->route('admin.jobs.show', $job)
                ->with('success', __('admin.jobs.created_successfully'));

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => __('admin.jobs.creation_failed')])
                ->withInput();
        }
    }

    /**
     * Show job details
     * Implements: REQ-ADM-005
     */
    public function show(Job $job)
    {
        $job->load([
            'company.user',
            'jobType',
            'skills.skill',
            'applications.candidate.user'
        ]);

        // Get job statistics
        $jobStats = [
            'total_views' => $job->views_count,
            'total_applications' => $job->applications()->count(),
            'pending_applications' => $job->applications()->where('status', 'applied')->count(),
            'shortlisted_applications' => $job->applications()->where('status', 'shortlisted')->count(),
            'interview_applications' => $job->applications()->where('status', 'interview')->count(),
            'selected_applications' => $job->applications()->where('status', 'selected')->count(),
            'rejected_applications' => $job->applications()->where('status', 'rejected')->count(),
        ];

        // Application trends
        $applicationTrends = $this->getJobApplicationTrends($job);

        // Recent applications
        $recentApplications = $job->applications()
                                 ->with(['candidate.user'])
                                 ->latest()
                                 ->take(10)
                                 ->get();

        return view('admin.jobs.show', compact('job', 'jobStats', 'applicationTrends', 'recentApplications'));
    }

    /**
     * Show edit job form
     * Implements: REQ-ADM-005
     */
    public function edit(Job $job)
    {
        $job->load(['company', 'jobType', 'skills']);
        $companies = Company::select('id', 'company_name')->get();
        $jobTypes = JobType::where('is_active', true)->get();
        $skills = Skill::where('is_active', true)->get();
        
        return view('admin.jobs.edit', compact('job', 'companies', 'jobTypes', 'skills'));
    }

    /**
     * Update job information
     * Implements: REQ-ADM-005
     */
    public function update(Request $request, Job $job)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'job_type_id' => 'required|exists:job_types,id',
            'location' => 'nullable|string|max:255',
            'is_remote' => 'boolean',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'salary_currency' => 'nullable|string|size:3',
            'experience_min' => 'nullable|integer|min:0',
            'experience_max' => 'nullable|integer|min:0|gte:experience_min',
            'education_level' => 'nullable|string|max:100',
            'application_deadline' => 'nullable|date|after:today',
            'status' => 'required|in:draft,active,inactive,expired,filled',
            'visibility' => 'required|in:normal,highlighted,featured',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
        ]);

        try {
            DB::beginTransaction();

            $updateData = $request->except(['skills']);

            // Handle published_at timestamp
            if ($request->status === 'active' && $job->status !== 'active') {
                $updateData['published_at'] = now();
            }

            $job->update($updateData);

            // Update skills
            if ($request->has('skills')) {
                $skillsData = [];
                foreach ($request->skills as $skillId) {
                    $skillsData[$skillId] = ['is_required' => true]; // Default to required
                }
                $job->skills()->sync($skillsData);
            }

            DB::commit();

            return redirect()
                ->route('admin.jobs.show', $job)
                ->with('success', __('admin.jobs.updated_successfully'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => __('admin.jobs.update_failed')])
                ->withInput();
        }
    }

    /**
     * Change job status
     * Implements: REQ-ADM-005
     */
    public function changeStatus(Request $request, Job $job)
    {
        $request->validate([
            'status' => 'required|in:draft,active,inactive,expired,filled',
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $oldStatus = $job->status;
            $newStatus = $request->status;

            $updateData = ['status' => $newStatus];

            // Handle status-specific logic
            if ($newStatus === 'active' && $oldStatus !== 'active') {
                $updateData['published_at'] = now();
            }

            if ($newStatus === 'filled') {
                // Reject all pending applications
                $job->applications()
                    ->whereIn('status', ['applied', 'viewed', 'shortlisted'])
                    ->update([
                        'status' => 'rejected',
                        'rejection_reason' => 'Position has been filled'
                    ]);
            }

            $job->update($updateData);

            // Log status change
            $job->company->user->activities()->create([
                'activity_type' => 'job_status_changed',
                'description' => "Job status changed from {$oldStatus} to {$newStatus}" . 
                               ($request->reason ? " - Reason: {$request->reason}" : ''),
                'ip_address' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => __('admin.jobs.status_updated'),
                'status' => $newStatus
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.jobs.status_update_failed')
            ], 500);
        }
    }

    /**
     * Change job visibility
     * Implements: REQ-ADM-005
     */
    public function changeVisibility(Request $request, Job $job)
    {
        $request->validate([
            'visibility' => 'required|in:normal,highlighted,featured',
        ]);

        try {
            $job->update(['visibility' => $request->visibility]);

            return response()->json([
                'success' => true,
                'message' => __('admin.jobs.visibility_updated'),
                'visibility' => $request->visibility
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.jobs.visibility_update_failed')
            ], 500);
        }
    }

    /**
     * Delete job
     * Implements: REQ-ADM-005
     */
    public function destroy(Job $job)
    {
        try {
            DB::beginTransaction();

            // Handle applications - mark as withdrawn
            $job->applications()->update([
                'status' => 'withdrawn',
                'company_notes' => 'Job posting was deleted by admin'
            ]);

            // Soft delete the job
            $job->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('admin.jobs.deleted_successfully')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => __('admin.jobs.deletion_failed')
            ], 500);
        }
    }

    /**
     * Get job analytics
     * Implements: REQ-ANL-004
     */
    public function analytics(Job $job)
    {
        // Performance metrics
        $performance = [
            'views_count' => $job->views_count,
            'applications_count' => $job->applications()->count(),
            'conversion_rate' => $job->views_count > 0 ? 
                round(($job->applications()->count() / $job->views_count) * 100, 2) : 0,
            'avg_response_time' => $this->calculateAverageResponseTime($job),
        ];

        // Application status breakdown
        $applicationStats = $job->applications()
                               ->select('status', DB::raw('COUNT(*) as count'))
                               ->groupBy('status')
                               ->pluck('count', 'status')
                               ->toArray();

        // Daily application trends
        $dailyTrends = $this->getJobApplicationTrends($job, 30);

        // Candidate insights
        $candidateInsights = [
            'avg_experience' => $job->applications()
                                   ->join('candidates', 'applications.candidate_id', '=', 'candidates.id')
                                   ->avg('candidates.experience_years') ?? 0,
            'top_skills' => $this->getTopSkillsFromApplications($job),
            'location_distribution' => $this->getLocationDistribution($job),
        ];

        return response()->json([
            'performance' => $performance,
            'application_stats' => $applicationStats,
            'daily_trends' => $dailyTrends,
            'candidate_insights' => $candidateInsights,
        ]);
    }

    /**
     * Get job statistics for dashboard
     */
    public function getStatistics()
    {
        $stats = [
            'total_jobs' => Job::count(),
            'active_jobs' => Job::where('status', 'active')->count(),
            'draft_jobs' => Job::where('status', 'draft')->count(),
            'featured_jobs' => Job::where('visibility', 'featured')->count(),
            'remote_jobs' => Job::where('is_remote', true)->count(),
            'jobs_with_applications' => Job::has('applications')->count(),
            'recent_posts' => Job::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        // Job type distribution
        $jobTypeStats = Job::join('job_types', 'jobs.job_type_id', '=', 'job_types.id')
                          ->select('job_types.name', DB::raw('COUNT(*) as count'))
                          ->groupBy('job_types.id', 'job_types.name')
                          ->orderByDesc('count')
                          ->take(10)
                          ->get();

        // Salary range distribution
        $salaryRanges = Job::selectRaw('
            CASE 
                WHEN salary_max IS NULL THEN "Not specified"
                WHEN salary_max < 50000 THEN "Under $50K"
                WHEN salary_max BETWEEN 50000 AND 100000 THEN "$50K - $100K"
                WHEN salary_max BETWEEN 100000 AND 150000 THEN "$100K - $150K"
                WHEN salary_max > 150000 THEN "Over $150K"
            END as salary_range,
            COUNT(*) as count
        ')
        ->groupBy('salary_range')
        ->get();

        // Monthly posting trends
        $monthlyTrends = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyTrends->push([
                'month' => $date->format('M Y'),
                'jobs_posted' => Job::whereYear('created_at', $date->year)
                                   ->whereMonth('created_at', $date->month)
                                   ->count(),
                'applications_received' => Application::join('jobs', 'applications.job_id', '=', 'jobs.id')
                                                     ->whereYear('applications.created_at', $date->year)
                                                     ->whereMonth('applications.created_at', $date->month)
                                                     ->count(),
            ]);
        }

        return response()->json([
            'overview' => $stats,
            'job_type_distribution' => $jobTypeStats,
            'salary_distribution' => $salaryRanges,
            'monthly_trends' => $monthlyTrends,
        ]);
    }

    /**
     * Export jobs data
     */
    public function export(Request $request)
    {
        $request->validate([
            'format' => 'required|in:csv,xlsx',
            'filters' => 'nullable|array',
        ]);

        try {
            $query = Job::with(['company', 'jobType', 'skills']);

            // Apply filters if provided
            if ($request->has('filters')) {
                $filters = $request->filters;
                
                if (!empty($filters['status'])) {
                    $query->where('status', $filters['status']);
                }
                
                if (!empty($filters['visibility'])) {
                    $query->where('visibility', $filters['visibility']);
                }
                
                if (!empty($filters['company_id'])) {
                    $query->where('company_id', $filters['company_id']);
                }
                
                if (!empty($filters['date_from'])) {
                    $query->whereDate('created_at', '>=', $filters['date_from']);
                }
                
                if (!empty($filters['date_to'])) {
                    $query->whereDate('created_at', '<=', $filters['date_to']);
                }
            }

            $jobs = $query->get();

            $filename = 'jobs_export_' . now()->format('Y-m-d_H-i-s') . '.' . $request->format;

            return $this->generateExportFile($jobs, $request->format, $filename);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.jobs.export_failed') . ': ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get job application trends
     */
    private function getJobApplicationTrends(Job $job, $days = 7)
    {
        $trends = collect();
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $trends->push([
                'date' => $date->format('Y-m-d'),
                'applications' => $job->applications()
                                     ->whereDate('created_at', $date)
                                     ->count(),
            ]);
        }
        return $trends;
    }

    /**
     * Calculate average response time for job applications
     */
    private function calculateAverageResponseTime(Job $job)
    {
        $applications = $job->applications()
                           ->whereNotNull('responded_at')
                           ->get();

        if ($applications->isEmpty()) return 0;

        $totalHours = 0;
        foreach ($applications as $application) {
            $hours = $application->applied_at->diffInHours($application->responded_at);
            $totalHours += $hours;
        }

        return round($totalHours / $applications->count());
    }

    /**
     * Get top skills from job applications
     */
    private function getTopSkillsFromApplications(Job $job)
    {
        return DB::table('candidate_skills')
                 ->join('skills', 'candidate_skills.skill_id', '=', 'skills.id')
                 ->join('applications', 'candidate_skills.candidate_id', '=', 'applications.candidate_id')
                 ->where('applications.job_id', $job->id)
                 ->select('skills.name', DB::raw('COUNT(*) as count'))
                 ->groupBy('skills.id', 'skills.name')
                 ->orderByDesc('count')
                 ->take(10)
                 ->get();
    }

    /**
     * Get location distribution of applicants
     */
    private function getLocationDistribution(Job $job)
    {
        return $job->applications()
                  ->join('candidates', 'applications.candidate_id', '=', 'candidates.id')
                  ->select('candidates.city', DB::raw('COUNT(*) as count'))
                  ->whereNotNull('candidates.city')
                  ->groupBy('candidates.city')
                  ->orderByDesc('count')
                  ->take(10)
                  ->get();
    }

    /**
     * Generate export file
     */
    private function generateExportFile($jobs, $format, $filename)
    {
        // Implementation would depend on chosen Excel/CSV library
        return response()->json([
            'success' => true,
            'download_url' => '/admin/downloads/' . $filename
        ]);
    }
}