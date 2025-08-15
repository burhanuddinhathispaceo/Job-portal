<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Models\Industry;
use App\Models\Job;
use App\Models\Project;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Admin Company Management Controller
 * Implements: REQ-ADM-002, REQ-CMP-001 to REQ-CMP-004
 * 
 * Handles company profile management, verification, and monitoring
 */
class CompanyController extends Controller
{
    /**
     * Display companies list
     * Implements: REQ-ADM-002
     */
    public function index(Request $request)
    {
        $query = Company::with(['user', 'industry', 'subscription']);

        // Apply filters
        if ($request->filled('industry_id')) {
            $query->where('industry_id', $request->industry_id);
        }

        if ($request->filled('company_size')) {
            $query->where('company_size', $request->company_size);
        }

        if ($request->filled('status')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        if ($request->filled('subscription_status')) {
            $query->whereHas('subscription', function ($q) use ($request) {
                $q->where('status', $request->subscription_status);
            });
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('company_name', 'like', "%{$searchTerm}%")
                  ->orWhere('website', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('email', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $companies = $query->orderBy('created_at', 'desc')
                          ->paginate(50);

        $stats = [
            'total_companies' => Company::count(),
            'active_companies' => Company::whereHas('user', function ($q) {
                $q->where('status', 'active');
            })->count(),
            'verified_companies' => Company::where('verification_status', 'verified')->count(),
            'premium_companies' => Company::whereHas('subscription', function ($q) {
                $q->where('status', 'active');
            })->count(),
        ];

        $industries = Industry::where('is_active', true)->get();

        return view('admin.companies.index', compact('companies', 'stats', 'industries'));
    }

    /**
     * Show company details
     * Implements: REQ-ADM-002
     */
    public function show(Company $company)
    {
        $company->load([
            'user',
            'industry',
            'subscription.plan',
            'jobs' => function ($query) {
                $query->latest()->take(10);
            },
            'projects' => function ($query) {
                $query->latest()->take(10);
            }
        ]);

        // Get company statistics
        $stats = [
            'total_jobs' => $company->jobs()->count(),
            'active_jobs' => $company->jobs()->where('status', 'active')->count(),
            'total_projects' => $company->projects()->count(),
            'active_projects' => $company->projects()->where('status', 'active')->count(),
            'total_applications' => DB::table('applications')
                ->join('jobs', 'applications.job_id', '=', 'jobs.id')
                ->where('jobs.company_id', $company->id)
                ->count() +
                DB::table('applications')
                ->join('projects', 'applications.project_id', '=', 'projects.id')
                ->where('projects.company_id', $company->id)
                ->count(),
        ];

        // Recent activities
        $recentActivities = $company->user->activities()
                                         ->latest()
                                         ->take(15)
                                         ->get();

        return view('admin.companies.show', compact('company', 'stats', 'recentActivities'));
    }

    /**
     * Show edit company form
     * Implements: REQ-ADM-002
     */
    public function edit(Company $company)
    {
        $company->load(['user', 'industry']);
        $industries = Industry::where('is_active', true)->get();
        
        return view('admin.companies.edit', compact('company', 'industries'));
    }

    /**
     * Update company information
     * Implements: REQ-ADM-002
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'industry_id' => 'required|exists:industries,id',
            'company_size' => 'nullable|in:1-10,11-50,51-200,201-500,500+',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'linkedin_url' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:2048', // 2MB max
        ]);

        try {
            DB::beginTransaction();

            $updateData = $request->except(['logo']);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($company->logo && Storage::exists($company->logo)) {
                    Storage::delete($company->logo);
                }

                $logoPath = $request->file('logo')->store('company-logos', 'public');
                $updateData['logo'] = $logoPath;
            }

            $company->update($updateData);

            DB::commit();

            return redirect()
                ->route('admin.companies.show', $company)
                ->with('success', __('admin.companies.updated_successfully'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => __('admin.companies.update_failed')])
                ->withInput();
        }
    }

    /**
     * Verify company account
     * Implements: REQ-ADM-002
     */
    public function verify(Request $request, Company $company)
    {
        $request->validate([
            'verification_notes' => 'nullable|string|max:1000',
        ]);

        try {
            $company->update([
                'verification_status' => 'verified',
                'verified_at' => now(),
                'verification_notes' => $request->verification_notes,
            ]);

            // Log verification activity
            $company->user->activities()->create([
                'activity_type' => 'company_verified',
                'description' => 'Company verified by admin',
                'ip_address' => $request->ip(),
            ]);

            // Send verification notification (implement as needed)
            // $this->sendVerificationNotification($company);

            return response()->json([
                'success' => true,
                'message' => __('admin.companies.verified_successfully')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.companies.verification_failed')
            ], 500);
        }
    }

    /**
     * Reject company verification
     * Implements: REQ-ADM-002
     */
    public function rejectVerification(Request $request, Company $company)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        try {
            $company->update([
                'verification_status' => 'rejected',
                'verification_notes' => $request->rejection_reason,
            ]);

            // Log rejection activity
            $company->user->activities()->create([
                'activity_type' => 'company_verification_rejected',
                'description' => 'Company verification rejected: ' . $request->rejection_reason,
                'ip_address' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => __('admin.companies.verification_rejected')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.companies.rejection_failed')
            ], 500);
        }
    }

    /**
     * Suspend company account
     * Implements: REQ-ADM-004
     */
    public function suspend(Request $request, Company $company)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Suspend user account
            $company->user->update([
                'status' => 'suspended',
                'suspension_reason' => $request->reason,
                'suspended_at' => now(),
            ]);

            // Deactivate all company jobs and projects
            $company->jobs()->update(['status' => 'inactive']);
            $company->projects()->update(['status' => 'inactive']);

            // Log suspension
            $company->user->activities()->create([
                'activity_type' => 'company_suspended',
                'description' => 'Company suspended by admin: ' . $request->reason,
                'ip_address' => $request->ip(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('admin.companies.suspended_successfully')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => __('admin.companies.suspension_failed')
            ], 500);
        }
    }

    /**
     * Get company analytics
     * Implements: REQ-ANL-005 to REQ-ANL-008
     */
    public function analytics(Company $company)
    {
        // Job posting performance
        $jobStats = [
            'total_jobs' => $company->jobs()->count(),
            'active_jobs' => $company->jobs()->where('status', 'active')->count(),
            'total_views' => $company->jobs()->sum('views_count'),
            'total_applications' => $company->jobs()->sum('applications_count'),
        ];

        // Project posting performance
        $projectStats = [
            'total_projects' => $company->projects()->count(),
            'active_projects' => $company->projects()->where('status', 'active')->count(),
            'total_views' => $company->projects()->sum('views_count'),
            'total_applications' => $company->projects()->sum('applications_count'),
        ];

        // Monthly performance data
        $monthlyData = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyData->push([
                'month' => $date->format('M Y'),
                'jobs_posted' => $company->jobs()
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'applications_received' => DB::table('applications')
                    ->join('jobs', 'applications.job_id', '=', 'jobs.id')
                    ->where('jobs.company_id', $company->id)
                    ->whereYear('applications.created_at', $date->year)
                    ->whereMonth('applications.created_at', $date->month)
                    ->count(),
            ]);
        }

        // Top performing jobs
        $topJobs = $company->jobs()
                          ->select(['id', 'title', 'views_count', 'applications_count'])
                          ->orderByDesc('applications_count')
                          ->take(10)
                          ->get();

        return response()->json([
            'job_stats' => $jobStats,
            'project_stats' => $projectStats,
            'monthly_data' => $monthlyData,
            'top_jobs' => $topJobs,
        ]);
    }

    /**
     * Get company statistics for dashboard
     */
    public function getStatistics()
    {
        $stats = [
            'total_companies' => Company::count(),
            'active_companies' => Company::whereHas('user', function ($q) {
                $q->where('status', 'active');
            })->count(),
            'pending_verification' => Company::where('verification_status', 'pending')->count(),
            'verified_companies' => Company::where('verification_status', 'verified')->count(),
            'rejected_companies' => Company::where('verification_status', 'rejected')->count(),
            'premium_companies' => Company::whereHas('subscription', function ($q) {
                $q->where('status', 'active');
            })->count(),
            'recent_registrations' => Company::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        // Industry distribution
        $industryStats = Company::select('industries.name', DB::raw('COUNT(*) as count'))
                               ->join('industries', 'companies.industry_id', '=', 'industries.id')
                               ->groupBy('industries.id', 'industries.name')
                               ->orderByDesc('count')
                               ->take(10)
                               ->get();

        // Company size distribution
        $sizeStats = Company::select('company_size', DB::raw('COUNT(*) as count'))
                           ->whereNotNull('company_size')
                           ->groupBy('company_size')
                           ->get();

        return response()->json([
            'overview' => $stats,
            'industry_distribution' => $industryStats,
            'size_distribution' => $sizeStats,
        ]);
    }

    /**
     * Export companies data
     */
    public function export(Request $request)
    {
        $request->validate([
            'format' => 'required|in:csv,xlsx',
            'filters' => 'nullable|array',
        ]);

        try {
            $query = Company::with(['user', 'industry', 'subscription']);

            // Apply filters if provided
            if ($request->has('filters')) {
                $filters = $request->filters;
                
                if (!empty($filters['industry_id'])) {
                    $query->where('industry_id', $filters['industry_id']);
                }
                
                if (!empty($filters['company_size'])) {
                    $query->where('company_size', $filters['company_size']);
                }
                
                if (!empty($filters['status'])) {
                    $query->whereHas('user', function ($q) use ($filters) {
                        $q->where('status', $filters['status']);
                    });
                }
            }

            $companies = $query->get();

            $filename = 'companies_export_' . now()->format('Y-m-d_H-i-s') . '.' . $request->format;

            return $this->generateExportFile($companies, $request->format, $filename);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.companies.export_failed') . ': ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate export file
     */
    private function generateExportFile($companies, $format, $filename)
    {
        // Implementation would depend on chosen Excel/CSV library
        // This is a placeholder for the actual export logic
        return response()->json([
            'success' => true,
            'download_url' => '/admin/downloads/' . $filename
        ]);
    }
}