<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\User;
use App\Models\Application;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Admin Candidate Management Controller
 * Implements: REQ-ADM-001, REQ-CND-001 to REQ-CND-030
 * 
 * Handles candidate profile management, verification, and monitoring
 */
class CandidateController extends Controller
{
    /**
     * Display candidates list
     * Implements: REQ-ADM-001
     */
    public function index(Request $request)
    {
        $query = Candidate::with(['user', 'skills']);

        // Apply filters
        if ($request->filled('experience_min')) {
            $query->where('experience_years', '>=', $request->experience_min);
        }

        if ($request->filled('experience_max')) {
            $query->where('experience_years', '<=', $request->experience_max);
        }

        if ($request->filled('status')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        if ($request->filled('skills')) {
            $skillIds = is_array($request->skills) ? $request->skills : [$request->skills];
            $query->whereHas('skills', function ($q) use ($skillIds) {
                $q->whereIn('skills.id', $skillIds);
            });
        }

        if ($request->filled('location')) {
            $location = $request->location;
            $query->where(function ($q) use ($location) {
                $q->where('city', 'like', "%{$location}%")
                  ->orWhere('state', 'like', "%{$location}%")
                  ->orWhere('country', 'like', "%{$location}%");
            });
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', "%{$searchTerm}%")
                  ->orWhere('last_name', 'like', "%{$searchTerm}%")
                  ->orWhere('professional_summary', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('email', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $candidates = $query->orderBy('created_at', 'desc')
                           ->paginate(50);

        $stats = [
            'total_candidates' => Candidate::count(),
            'active_candidates' => Candidate::whereHas('user', function ($q) {
                $q->where('status', 'active');
            })->count(),
            'verified_candidates' => Candidate::where('profile_completion', '>=', 80)->count(),
            'recent_applications' => Application::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        $skills = Skill::where('is_active', true)->get();

        return view('admin.candidates.index', compact('candidates', 'stats', 'skills'));
    }

    /**
     * Show candidate details
     * Implements: REQ-ADM-001
     */
    public function show(Candidate $candidate)
    {
        $candidate->load([
            'user',
            'skills.skill',
            'applications.job.company',
            'applications.project.company',
            'bookmarks',
            'educations',
            'workExperiences'
        ]);

        // Calculate profile completion
        $profileCompletion = $this->calculateProfileCompletion($candidate);

        // Get application statistics
        $applicationStats = [
            'total_applications' => $candidate->applications()->count(),
            'pending_applications' => $candidate->applications()->where('status', 'applied')->count(),
            'interview_applications' => $candidate->applications()->where('status', 'interview')->count(),
            'selected_applications' => $candidate->applications()->where('status', 'selected')->count(),
            'rejected_applications' => $candidate->applications()->where('status', 'rejected')->count(),
        ];

        // Recent activities
        $recentActivities = $candidate->user->activities()
                                          ->latest()
                                          ->take(15)
                                          ->get();

        return view('admin.candidates.show', compact('candidate', 'profileCompletion', 'applicationStats', 'recentActivities'));
    }

    /**
     * Show edit candidate form
     * Implements: REQ-ADM-001
     */
    public function edit(Candidate $candidate)
    {
        $candidate->load(['user', 'skills']);
        $allSkills = Skill::where('is_active', true)->get();
        
        return view('admin.candidates.edit', compact('candidate', 'allSkills'));
    }

    /**
     * Update candidate information
     * Implements: REQ-ADM-001
     */
    public function update(Request $request, Candidate $candidate)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'professional_summary' => 'nullable|string|max:2000',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'current_salary' => 'nullable|numeric|min:0',
            'expected_salary' => 'nullable|numeric|min:0',
            'notice_period' => 'nullable|integer|min:0|max:365',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'profile_picture' => 'nullable|image|max:2048',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
        ]);

        try {
            DB::beginTransaction();

            $updateData = $request->except(['profile_picture', 'resume', 'skills']);

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                if ($candidate->profile_picture && Storage::exists($candidate->profile_picture)) {
                    Storage::delete($candidate->profile_picture);
                }
                $picturePath = $request->file('profile_picture')->store('candidate-pictures', 'public');
                $updateData['profile_picture'] = $picturePath;
            }

            // Handle resume upload
            if ($request->hasFile('resume')) {
                if ($candidate->resume_path && Storage::exists($candidate->resume_path)) {
                    Storage::delete($candidate->resume_path);
                }
                $resumePath = $request->file('resume')->store('candidate-resumes', 'private');
                $updateData['resume_path'] = $resumePath;
            }

            $candidate->update($updateData);

            // Update skills
            if ($request->has('skills')) {
                $candidate->skills()->sync($request->skills);
            }

            // Update profile completion
            $candidate->update([
                'profile_completion' => $this->calculateProfileCompletion($candidate)
            ]);

            DB::commit();

            return redirect()
                ->route('admin.candidates.show', $candidate)
                ->with('success', __('admin.candidates.updated_successfully'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => __('admin.candidates.update_failed')])
                ->withInput();
        }
    }

    /**
     * Suspend candidate account
     * Implements: REQ-ADM-004
     */
    public function suspend(Request $request, Candidate $candidate)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Suspend user account
            $candidate->user->update([
                'status' => 'suspended',
                'suspension_reason' => $request->reason,
                'suspended_at' => now(),
            ]);

            // Withdraw all pending applications
            $candidate->applications()
                     ->whereIn('status', ['applied', 'viewed', 'shortlisted'])
                     ->update(['status' => 'withdrawn']);

            // Log suspension
            $candidate->user->activities()->create([
                'activity_type' => 'candidate_suspended',
                'description' => 'Candidate suspended by admin: ' . $request->reason,
                'ip_address' => $request->ip(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('admin.candidates.suspended_successfully')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => __('admin.candidates.suspension_failed')
            ], 500);
        }
    }

    /**
     * Get candidate analytics
     * Implements: REQ-ANL-009 to REQ-ANL-012
     */
    public function analytics(Candidate $candidate)
    {
        // Profile analytics
        $profileStats = [
            'profile_completion' => $this->calculateProfileCompletion($candidate),
            'profile_views' => $candidate->profile_views ?? 0,
            'resume_downloads' => $candidate->resume_downloads ?? 0,
            'skills_count' => $candidate->skills()->count(),
        ];

        // Application analytics
        $applicationStats = [
            'total_applications' => $candidate->applications()->count(),
            'success_rate' => $this->calculateSuccessRate($candidate),
            'avg_response_time' => $this->calculateAverageResponseTime($candidate),
            'interview_rate' => $this->calculateInterviewRate($candidate),
        ];

        // Monthly application data
        $monthlyData = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyData->push([
                'month' => $date->format('M Y'),
                'applications_sent' => $candidate->applications()
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'interviews_received' => $candidate->applications()
                    ->where('status', 'interview')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ]);
        }

        // Top skills
        $topSkills = $candidate->skills()
                              ->select(['skills.name', 'candidate_skills.proficiency', 'candidate_skills.years_experience'])
                              ->orderByDesc('candidate_skills.years_experience')
                              ->take(10)
                              ->get();

        return response()->json([
            'profile_stats' => $profileStats,
            'application_stats' => $applicationStats,
            'monthly_data' => $monthlyData,
            'top_skills' => $topSkills,
        ]);
    }

    /**
     * Get candidate statistics for dashboard
     */
    public function getStatistics()
    {
        $stats = [
            'total_candidates' => Candidate::count(),
            'active_candidates' => Candidate::whereHas('user', function ($q) {
                $q->where('status', 'active');
            })->count(),
            'verified_profiles' => Candidate::where('profile_completion', '>=', 80)->count(),
            'recent_registrations' => Candidate::where('created_at', '>=', now()->subDays(7))->count(),
            'total_applications' => Application::count(),
            'recent_applications' => Application::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        // Experience distribution
        $experienceStats = Candidate::selectRaw('
            CASE 
                WHEN experience_years = 0 THEN "0 years"
                WHEN experience_years BETWEEN 1 AND 2 THEN "1-2 years"
                WHEN experience_years BETWEEN 3 AND 5 THEN "3-5 years"
                WHEN experience_years BETWEEN 6 AND 10 THEN "6-10 years"
                WHEN experience_years > 10 THEN "10+ years"
                ELSE "Not specified"
            END as experience_range,
            COUNT(*) as count
        ')
        ->groupBy('experience_range')
        ->get();

        // Top skills
        $topSkills = DB::table('candidate_skills')
                      ->join('skills', 'candidate_skills.skill_id', '=', 'skills.id')
                      ->select('skills.name', DB::raw('COUNT(*) as count'))
                      ->groupBy('skills.id', 'skills.name')
                      ->orderByDesc('count')
                      ->take(15)
                      ->get();

        return response()->json([
            'overview' => $stats,
            'experience_distribution' => $experienceStats,
            'top_skills' => $topSkills,
        ]);
    }

    /**
     * Export candidates data
     */
    public function export(Request $request)
    {
        $request->validate([
            'format' => 'required|in:csv,xlsx',
            'filters' => 'nullable|array',
        ]);

        try {
            $query = Candidate::with(['user', 'skills']);

            // Apply filters if provided
            if ($request->has('filters')) {
                $filters = $request->filters;
                
                if (!empty($filters['experience_min'])) {
                    $query->where('experience_years', '>=', $filters['experience_min']);
                }
                
                if (!empty($filters['skills'])) {
                    $query->whereHas('skills', function ($q) use ($filters) {
                        $q->whereIn('skills.id', $filters['skills']);
                    });
                }
                
                if (!empty($filters['status'])) {
                    $query->whereHas('user', function ($q) use ($filters) {
                        $q->where('status', $filters['status']);
                    });
                }
            }

            $candidates = $query->get();

            $filename = 'candidates_export_' . now()->format('Y-m-d_H-i-s') . '.' . $request->format;

            return $this->generateExportFile($candidates, $request->format, $filename);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.candidates.export_failed') . ': ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate profile completion percentage
     */
    private function calculateProfileCompletion(Candidate $candidate)
    {
        $fields = [
            'first_name', 'last_name', 'professional_summary', 'experience_years',
            'city', 'state', 'country', 'linkedin_url', 'expected_salary'
        ];

        $completed = 0;
        foreach ($fields as $field) {
            if (!empty($candidate->$field)) {
                $completed++;
            }
        }

        // Additional checks
        if ($candidate->profile_picture) $completed++;
        if ($candidate->resume_path) $completed++;
        if ($candidate->skills()->count() > 0) $completed++;

        $total = count($fields) + 3; // Base fields + picture + resume + skills
        return round(($completed / $total) * 100);
    }

    /**
     * Calculate application success rate
     */
    private function calculateSuccessRate(Candidate $candidate)
    {
        $totalApplications = $candidate->applications()->count();
        if ($totalApplications === 0) return 0;

        $successfulApplications = $candidate->applications()
                                           ->whereIn('status', ['selected', 'interview'])
                                           ->count();

        return round(($successfulApplications / $totalApplications) * 100);
    }

    /**
     * Calculate average response time
     */
    private function calculateAverageResponseTime(Candidate $candidate)
    {
        $applications = $candidate->applications()
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
     * Calculate interview rate
     */
    private function calculateInterviewRate(Candidate $candidate)
    {
        $totalApplications = $candidate->applications()->count();
        if ($totalApplications === 0) return 0;

        $interviews = $candidate->applications()
                               ->where('status', 'interview')
                               ->count();

        return round(($interviews / $totalApplications) * 100);
    }

    /**
     * Generate export file
     */
    private function generateExportFile($candidates, $format, $filename)
    {
        // Implementation would depend on chosen Excel/CSV library
        return response()->json([
            'success' => true,
            'download_url' => '/admin/downloads/' . $filename
        ]);
    }
}