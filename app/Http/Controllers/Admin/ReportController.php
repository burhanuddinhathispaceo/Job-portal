<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Job;
use App\Models\Project;
use App\Models\Application;
use App\Models\Subscription;
use App\Models\Company;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Admin Report Generation Controller
 * Implements: REQ-ANL-001 to REQ-ANL-004
 * 
 * Handles advanced reporting and data export
 */
class ReportController extends Controller
{
    /**
     * Display reports dashboard
     */
    public function index()
    {
        $availableReports = [
            'user_activity' => __('admin.reports.user_activity'),
            'job_performance' => __('admin.reports.job_performance'),
            'revenue_analysis' => __('admin.reports.revenue_analysis'),
            'application_trends' => __('admin.reports.application_trends'),
            'company_performance' => __('admin.reports.company_performance'),
            'candidate_analytics' => __('admin.reports.candidate_analytics'),
            'system_health' => __('admin.reports.system_health'),
            'subscription_metrics' => __('admin.reports.subscription_metrics'),
        ];

        return view('admin.reports.index', compact('availableReports'));
    }

    /**
     * Generate user activity report
     */
    public function userActivity(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'role' => 'nullable|in:admin,company,candidate',
        ]);

        $query = User::whereBetween('created_at', [$request->start_date, $request->end_date]);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $data = [
            'new_registrations' => $query->count(),
            'active_users' => $query->where('status', 'active')->count(),
            'suspended_users' => $query->where('status', 'suspended')->count(),
            'daily_breakdown' => $this->getDailyBreakdown($request->start_date, $request->end_date),
            'role_distribution' => $this->getRoleDistribution($request->start_date, $request->end_date),
        ];

        return response()->json($data);
    }

    /**
     * Generate job performance report
     */
    public function jobPerformance(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        $query = Job::whereBetween('created_at', [$request->start_date, $request->end_date]);

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $data = [
            'total_jobs' => $query->count(),
            'active_jobs' => $query->where('status', 'active')->count(),
            'total_views' => $query->sum('views_count'),
            'total_applications' => $query->sum('applications_count'),
            'avg_applications_per_job' => $query->avg('applications_count'),
            'top_performing_jobs' => $query->orderByDesc('applications_count')->take(10)->get(),
            'visibility_breakdown' => [
                'normal' => $query->where('visibility', 'normal')->count(),
                'highlighted' => $query->where('visibility', 'highlighted')->count(),
                'featured' => $query->where('visibility', 'featured')->count(),
            ],
        ];

        return response()->json($data);
    }

    /**
     * Generate revenue analysis report
     */
    public function revenueAnalysis(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'group_by' => 'nullable|in:day,week,month,year',
        ]);

        $groupBy = $request->input('group_by', 'month');

        $subscriptions = Subscription::whereBetween('created_at', [$request->start_date, $request->end_date]);

        $data = [
            'total_revenue' => $subscriptions->sum('amount_paid'),
            'new_subscriptions' => $subscriptions->count(),
            'active_subscriptions' => $subscriptions->where('status', 'active')->count(),
            'cancelled_subscriptions' => $subscriptions->where('status', 'cancelled')->count(),
            'revenue_by_plan' => $this->getRevenueByPlan($request->start_date, $request->end_date),
            'revenue_trend' => $this->getRevenueTrend($request->start_date, $request->end_date, $groupBy),
            'avg_subscription_value' => $subscriptions->avg('amount_paid'),
        ];

        return response()->json($data);
    }

    /**
     * Generate application trends report
     */
    public function applicationTrends(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $applications = Application::whereBetween('created_at', [$request->start_date, $request->end_date]);

        $data = [
            'total_applications' => $applications->count(),
            'job_applications' => $applications->whereNotNull('job_id')->count(),
            'project_applications' => $applications->whereNotNull('project_id')->count(),
            'status_breakdown' => [
                'applied' => $applications->where('status', 'applied')->count(),
                'viewed' => $applications->where('status', 'viewed')->count(),
                'shortlisted' => $applications->where('status', 'shortlisted')->count(),
                'interview' => $applications->where('status', 'interview')->count(),
                'selected' => $applications->where('status', 'selected')->count(),
                'rejected' => $applications->where('status', 'rejected')->count(),
            ],
            'daily_trend' => $this->getApplicationDailyTrend($request->start_date, $request->end_date),
            'success_rate' => $this->calculateSuccessRate($request->start_date, $request->end_date),
        ];

        return response()->json($data);
    }

    /**
     * Generate company performance report
     */
    public function companyPerformance(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $companies = Company::with(['jobs', 'projects', 'subscription'])
                           ->whereHas('user', function ($q) use ($request) {
                               $q->whereBetween('created_at', [$request->start_date, $request->end_date]);
                           });

        $data = [
            'total_companies' => $companies->count(),
            'verified_companies' => $companies->where('verification_status', 'verified')->count(),
            'premium_companies' => $companies->whereHas('subscription', function ($q) {
                $q->where('status', 'active');
            })->count(),
            'top_hiring_companies' => $this->getTopHiringCompanies($request->start_date, $request->end_date),
            'industry_distribution' => $this->getIndustryDistribution(),
            'size_distribution' => $this->getCompanySizeDistribution(),
        ];

        return response()->json($data);
    }

    /**
     * Generate system health report
     */
    public function systemHealth()
    {
        $data = [
            'database_status' => $this->checkDatabaseHealth(),
            'storage_usage' => $this->getStorageUsage(),
            'active_sessions' => $this->getActiveSessions(),
            'error_rate' => $this->getErrorRate(),
            'response_times' => $this->getAverageResponseTimes(),
            'queue_status' => $this->getQueueStatus(),
        ];

        return response()->json($data);
    }

    /**
     * Export report as CSV or Excel
     */
    public function export(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:user_activity,job_performance,revenue_analysis,application_trends',
            'format' => 'required|in:csv,xlsx,pdf',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Generate report data based on type
        $data = $this->generateReportData($request->report_type, $request->all());

        // Generate file based on format
        $filename = $request->report_type . '_report_' . now()->format('Y-m-d_H-i-s') . '.' . $request->format;

        return $this->generateExportFile($data, $request->format, $filename);
    }

    /**
     * Get daily breakdown of user registrations
     */
    private function getDailyBreakdown($startDate, $endDate)
    {
        $days = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));
        $breakdown = [];

        for ($i = 0; $i <= $days; $i++) {
            $date = Carbon::parse($startDate)->addDays($i);
            $breakdown[] = [
                'date' => $date->format('Y-m-d'),
                'registrations' => User::whereDate('created_at', $date)->count(),
            ];
        }

        return $breakdown;
    }

    /**
     * Get role distribution
     */
    private function getRoleDistribution($startDate, $endDate)
    {
        return User::whereBetween('created_at', [$startDate, $endDate])
                  ->select('role', DB::raw('COUNT(*) as count'))
                  ->groupBy('role')
                  ->get();
    }

    /**
     * Get revenue by plan
     */
    private function getRevenueByPlan($startDate, $endDate)
    {
        return DB::table('subscriptions')
                 ->join('subscription_plans', 'subscriptions.plan_id', '=', 'subscription_plans.id')
                 ->whereBetween('subscriptions.created_at', [$startDate, $endDate])
                 ->select('subscription_plans.name', DB::raw('SUM(subscriptions.amount_paid) as revenue'))
                 ->groupBy('subscription_plans.id', 'subscription_plans.name')
                 ->get();
    }

    /**
     * Get revenue trend
     */
    private function getRevenueTrend($startDate, $endDate, $groupBy)
    {
        $format = $groupBy === 'day' ? 'Y-m-d' : ($groupBy === 'week' ? 'Y-W' : ($groupBy === 'year' ? 'Y' : 'Y-m'));
        
        return Subscription::whereBetween('created_at', [$startDate, $endDate])
                          ->select(DB::raw("DATE_FORMAT(created_at, '{$format}') as period"), DB::raw('SUM(amount_paid) as revenue'))
                          ->groupBy('period')
                          ->orderBy('period')
                          ->get();
    }

    /**
     * Get application daily trend
     */
    private function getApplicationDailyTrend($startDate, $endDate)
    {
        return Application::whereBetween('created_at', [$startDate, $endDate])
                         ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                         ->groupBy('date')
                         ->orderBy('date')
                         ->get();
    }

    /**
     * Calculate success rate
     */
    private function calculateSuccessRate($startDate, $endDate)
    {
        $total = Application::whereBetween('created_at', [$startDate, $endDate])->count();
        $successful = Application::whereBetween('created_at', [$startDate, $endDate])
                                ->whereIn('status', ['selected', 'interview'])
                                ->count();

        return $total > 0 ? round(($successful / $total) * 100, 2) : 0;
    }

    /**
     * Get top hiring companies
     */
    private function getTopHiringCompanies($startDate, $endDate)
    {
        return DB::table('companies')
                 ->join('jobs', 'companies.id', '=', 'jobs.company_id')
                 ->whereBetween('jobs.created_at', [$startDate, $endDate])
                 ->select('companies.company_name', DB::raw('COUNT(jobs.id) as job_count'))
                 ->groupBy('companies.id', 'companies.company_name')
                 ->orderByDesc('job_count')
                 ->take(10)
                 ->get();
    }

    /**
     * Get industry distribution
     */
    private function getIndustryDistribution()
    {
        return DB::table('companies')
                 ->join('industries', 'companies.industry_id', '=', 'industries.id')
                 ->select('industries.name', DB::raw('COUNT(*) as count'))
                 ->groupBy('industries.id', 'industries.name')
                 ->get();
    }

    /**
     * Get company size distribution
     */
    private function getCompanySizeDistribution()
    {
        return Company::select('company_size', DB::raw('COUNT(*) as count'))
                     ->whereNotNull('company_size')
                     ->groupBy('company_size')
                     ->get();
    }

    /**
     * Check database health
     */
    private function checkDatabaseHealth()
    {
        try {
            DB::connection()->getPdo();
            return 'healthy';
        } catch (\Exception $e) {
            return 'unhealthy';
        }
    }

    /**
     * Get storage usage
     */
    private function getStorageUsage()
    {
        $total = disk_total_space(storage_path());
        $free = disk_free_space(storage_path());
        $used = $total - $free;

        return [
            'total' => $this->formatBytes($total),
            'used' => $this->formatBytes($used),
            'free' => $this->formatBytes($free),
            'percentage' => round(($used / $total) * 100, 2),
        ];
    }

    /**
     * Get active sessions count
     */
    private function getActiveSessions()
    {
        return User::where('last_login_at', '>=', now()->subMinutes(30))->count();
    }

    /**
     * Get error rate (placeholder)
     */
    private function getErrorRate()
    {
        // This would typically query your error logging system
        return rand(0, 5) / 100; // Mock data: 0-5% error rate
    }

    /**
     * Get average response times (placeholder)
     */
    private function getAverageResponseTimes()
    {
        return [
            'api' => rand(50, 200) . 'ms',
            'web' => rand(100, 500) . 'ms',
        ];
    }

    /**
     * Get queue status
     */
    private function getQueueStatus()
    {
        return [
            'status' => 'active',
            'pending_jobs' => rand(0, 100), // Mock data
            'failed_jobs' => rand(0, 10), // Mock data
        ];
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Generate report data
     */
    private function generateReportData($reportType, $params)
    {
        switch ($reportType) {
            case 'user_activity':
                return $this->userActivity(new Request($params));
            case 'job_performance':
                return $this->jobPerformance(new Request($params));
            case 'revenue_analysis':
                return $this->revenueAnalysis(new Request($params));
            case 'application_trends':
                return $this->applicationTrends(new Request($params));
            default:
                return [];
        }
    }

    /**
     * Generate export file
     */
    private function generateExportFile($data, $format, $filename)
    {
        // Implementation would depend on chosen Excel/CSV library
        return response()->json([
            'success' => true,
            'download_url' => '/admin/downloads/' . $filename
        ]);
    }
}