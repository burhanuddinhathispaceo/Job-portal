<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Company;
use App\Models\ProjectType;
use App\Models\Skill;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Admin Project Management Controller
 * Implements: REQ-ADM-006
 * 
 * Handles project posting management, moderation, and analytics
 */
class ProjectController extends Controller
{
    /**
     * Display projects list
     * Implements: REQ-ADM-006
     */
    public function index(Request $request)
    {
        $query = Project::with(['company.user', 'projectType', 'skills']);

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

        if ($request->filled('project_type_id')) {
            $query->where('project_type_id', $request->project_type_id);
        }

        if ($request->filled('budget_min')) {
            $query->where('budget_max', '>=', $request->budget_min);
        }

        if ($request->filled('budget_max')) {
            $query->where('budget_min', '<=', $request->budget_max);
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

        $projects = $query->orderBy('created_at', 'desc')
                         ->paginate(50);

        $stats = [
            'total_projects' => Project::count(),
            'active_projects' => Project::where('status', 'active')->count(),
            'pending_projects' => Project::where('status', 'draft')->count(),
            'featured_projects' => Project::where('visibility', 'featured')->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
            'total_applications' => Application::whereNotNull('project_id')->count(),
        ];

        $companies = Company::select('id', 'company_name')->get();
        $projectTypes = ProjectType::where('is_active', true)->get();

        return view('admin.projects.index', compact('projects', 'stats', 'companies', 'projectTypes'));
    }

    /**
     * Show project details
     */
    public function show(Project $project)
    {
        $project->load([
            'company.user',
            'projectType',
            'skills.skill',
            'applications.candidate.user'
        ]);

        $projectStats = [
            'total_views' => $project->views_count,
            'total_applications' => $project->applications()->count(),
            'pending_applications' => $project->applications()->where('status', 'applied')->count(),
            'shortlisted_applications' => $project->applications()->where('status', 'shortlisted')->count(),
            'selected_applications' => $project->applications()->where('status', 'selected')->count(),
        ];

        return view('admin.projects.show', compact('project', 'projectStats'));
    }

    /**
     * Update project information
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'deliverables' => 'nullable|string',
            'project_type_id' => 'required|exists:project_types,id',
            'budget_min' => 'nullable|numeric|min:0',
            'budget_max' => 'nullable|numeric|min:0|gte:budget_min',
            'budget_currency' => 'nullable|string|size:3',
            'duration_value' => 'nullable|integer|min:1',
            'duration_unit' => 'nullable|in:days,weeks,months',
            'start_date' => 'nullable|date|after:yesterday',
            'application_deadline' => 'nullable|date|after:today',
            'status' => 'required|in:draft,active,inactive,expired,completed',
            'visibility' => 'required|in:normal,highlighted,featured',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
        ]);

        try {
            DB::beginTransaction();

            $updateData = $request->except(['skills']);

            if ($request->status === 'active' && $project->status !== 'active') {
                $updateData['published_at'] = now();
            }

            $project->update($updateData);

            if ($request->has('skills')) {
                $skillsData = [];
                foreach ($request->skills as $skillId) {
                    $skillsData[$skillId] = ['is_required' => true];
                }
                $project->skills()->sync($skillsData);
            }

            DB::commit();

            return redirect()
                ->route('admin.projects.show', $project)
                ->with('success', __('admin.projects.updated_successfully'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => __('admin.projects.update_failed')])
                ->withInput();
        }
    }

    /**
     * Change project status
     */
    public function changeStatus(Request $request, Project $project)
    {
        $request->validate([
            'status' => 'required|in:draft,active,inactive,expired,completed',
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $oldStatus = $project->status;
            $newStatus = $request->status;

            $updateData = ['status' => $newStatus];

            if ($newStatus === 'active' && $oldStatus !== 'active') {
                $updateData['published_at'] = now();
            }

            if ($newStatus === 'completed') {
                $project->applications()
                        ->whereIn('status', ['applied', 'viewed', 'shortlisted'])
                        ->update([
                            'status' => 'rejected',
                            'rejection_reason' => 'Project has been completed'
                        ]);
            }

            $project->update($updateData);

            return response()->json([
                'success' => true,
                'message' => __('admin.projects.status_updated'),
                'status' => $newStatus
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.projects.status_update_failed')
            ], 500);
        }
    }

    /**
     * Get project statistics
     */
    public function getStatistics()
    {
        $stats = [
            'total_projects' => Project::count(),
            'active_projects' => Project::where('status', 'active')->count(),
            'draft_projects' => Project::where('status', 'draft')->count(),
            'featured_projects' => Project::where('visibility', 'featured')->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
            'recent_posts' => Project::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return response()->json($stats);
    }
}