<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Job;
use App\Models\Project;
use App\Models\Application;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Admin Analytics Controller
 * Implements: REQ-ANL-001 to REQ-ANL-004
 * 
 * Handles system-wide analytics and reporting
 */
class AnalyticsController extends Controller
{
    /**
     * Display analytics dashboard
     */
    public function index()
    {
        $overview = [
            'total_users' => User::count(),
            'total_jobs' => Job::count(),
            'total_applications' => Application::count(),
            'total_revenue' => Subscription::where('status', 'active')->sum('amount_paid'),
        ];

        return view('admin.analytics.index', compact('overview'));
    }

    /**
     * Get system-wide usage statistics
     */
    public function systemStats()
    {
        $stats = [
            'users' => [
                'total' => User::count(),
                'companies' => User::where('role', 'company')->count(),
                'candidates' => User::where('role', 'candidate')->count(),
                'active_today' => User::where('last_login_at', '>=', now()->startOfDay())->count(),
            ],
            'content' => [
                'total_jobs' => Job::count(),
                'active_jobs' => Job::where('status', 'active')->count(),
                'total_projects' => Project::count(),
                'active_projects' => Project::where('status', 'active')->count(),
            ],
            'applications' => [
                'total' => Application::count(),
                'today' => Application::whereDate('created_at', today())->count(),
                'this_week' => Application::where('created_at', '>=', now()->startOfWeek())->count(),
                'success_rate' => $this->calculateOverallSuccessRate(),
            ],
            'revenue' => [
                'total' => Subscription::sum('amount_paid'),
                'monthly' => Subscription::where('created_at', '>=', now()->startOfMonth())->sum('amount_paid'),
                'active_subscriptions' => Subscription::where('status', 'active')->count(),
            ],
        ];

        return response()->json($stats);
    }

    /**
     * Get user growth metrics
     */
    public function userGrowth(Request $request)
    {
        $period = $request->input('period', 'monthly'); // daily, weekly, monthly, yearly

        $growth = collect();
        $range = $this->getDateRange($period);

        for ($i = $range['count'] - 1; $i >= 0; $i--) {
            $date = $range['start']->copy()->add($range['interval'], $i);
            $nextDate = $date->copy()->add($range['interval'], 1);

            $growth->push([
                'period' => $date->format($range['format']),
                'new_users' => User::whereBetween('created_at', [$date, $nextDate])->count(),
                'new_companies' => User::where('role', 'company')
                                      ->whereBetween('created_at', [$date, $nextDate])
                                      ->count(),
                'new_candidates' => User::where('role', 'candidate')
                                       ->whereBetween('created_at', [$date, $nextDate])
                                       ->count(),
            ]);
        }

        return response()->json($growth);
    }

    /**
     * Get revenue and subscription reports
     */
    public function revenueReports(Request $request)
    {
        $period = $request->input('period', 'monthly');
        $range = $this->getDateRange($period);

        $revenue = collect();
        for ($i = $range['count'] - 1; $i >= 0; $i--) {
            $date = $range['start']->copy()->add($range['interval'], $i);
            $nextDate = $date->copy()->add($range['interval'], 1);

            $revenue->push([
                'period' => $date->format($range['format']),
                'revenue' => Subscription::whereBetween('created_at', [$date, $nextDate])
                                        ->sum('amount_paid'),
                'new_subscriptions' => Subscription::whereBetween('created_at', [$date, $nextDate])
                                                  ->count(),
                'renewals' => Subscription::where('auto_renew', true)
                                         ->whereBetween('updated_at', [$date, $nextDate])
                                         ->count(),
            ]);
        }

        return response()->json($revenue);
    }

    /**
     * Get job posting trends
     */
    public function jobTrends(Request $request)
    {
        $period = $request->input('period', 'monthly');
        $range = $this->getDateRange($period);

        $trends = collect();
        for ($i = $range['count'] - 1; $i >= 0; $i--) {
            $date = $range['start']->copy()->add($range['interval'], $i);
            $nextDate = $date->copy()->add($range['interval'], 1);

            $trends->push([
                'period' => $date->format($range['format']),
                'jobs_posted' => Job::whereBetween('created_at', [$date, $nextDate])->count(),
                'projects_posted' => Project::whereBetween('created_at', [$date, $nextDate])->count(),
                'applications_received' => Application::whereBetween('created_at', [$date, $nextDate])->count(),
            ]);
        }

        return response()->json($trends);
    }

    /**
     * Get top performing content
     */
    public function topPerforming()
    {
        $data = [
            'top_jobs' => Job::select(['id', 'title', 'views_count', 'applications_count'])
                            ->orderByDesc('applications_count')
                            ->take(10)
                            ->get(),
            'top_companies' => DB::table('companies')
                                ->join('jobs', 'companies.id', '=', 'jobs.company_id')
                                ->select('companies.company_name', DB::raw('COUNT(jobs.id) as job_count'), DB::raw('SUM(jobs.applications_count) as total_applications'))
                                ->groupBy('companies.id', 'companies.company_name')
                                ->orderByDesc('total_applications')
                                ->take(10)
                                ->get(),
            'popular_skills' => DB::table('skills')
                                 ->join('job_skills', 'skills.id', '=', 'job_skills.skill_id')
                                 ->select('skills.name', DB::raw('COUNT(*) as usage_count'))
                                 ->groupBy('skills.id', 'skills.name')
                                 ->orderByDesc('usage_count')
                                 ->take(15)
                                 ->get(),
        ];

        return response()->json($data);
    }

    /**
     * Calculate overall success rate
     */
    private function calculateOverallSuccessRate()
    {
        $totalApplications = Application::count();
        if ($totalApplications === 0) return 0;

        $successfulApplications = Application::whereIn('status', ['selected', 'interview'])->count();
        return round(($successfulApplications / $totalApplications) * 100);
    }

    /**
     * Get date range based on period
     */
    private function getDateRange($period)
    {
        switch ($period) {
            case 'daily':
                return [
                    'start' => now()->subDays(30),
                    'interval' => 'day',
                    'count' => 30,
                    'format' => 'M d'
                ];
            case 'weekly':
                return [
                    'start' => now()->subWeeks(12),
                    'interval' => 'week',
                    'count' => 12,
                    'format' => 'M d'
                ];
            case 'yearly':
                return [
                    'start' => now()->subYears(5),
                    'interval' => 'year',
                    'count' => 5,
                    'format' => 'Y'
                ];
            default: // monthly
                return [
                    'start' => now()->subMonths(12),
                    'interval' => 'month',
                    'count' => 12,
                    'format' => 'M Y'
                ];
        }
    }
}