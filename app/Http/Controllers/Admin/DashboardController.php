<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\Project;
use App\Models\Application;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        // Gather dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'total_companies' => Company::count(),
            'total_candidates' => Candidate::count(),
            'active_jobs' => Job::where('status', 'active')->count(),
            'total_applications' => Application::count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
        ];

        // Recent activities
        $recentUsers = User::latest()->take(5)->get();
        $recentJobs = Job::with(['company.user'])->latest()->take(5)->get();
        $recentApplications = Application::with(['candidate.user', 'job'])
                                        ->latest()
                                        ->take(5)
                                        ->get();

        // Monthly growth data for charts
        $monthlyStats = $this->getMonthlyStats();

        // Popular skills and industries
        $popularSkills = DB::table('skills')
                          ->join('job_skills', 'skills.id', '=', 'job_skills.skill_id')
                          ->select('skills.name', DB::raw('COUNT(*) as count'))
                          ->groupBy('skills.id', 'skills.name')
                          ->orderByDesc('count')
                          ->take(10)
                          ->get();

        $industryStats = DB::table('industries')
                          ->join('companies', 'industries.id', '=', 'companies.industry_id')
                          ->select('industries.name', DB::raw('COUNT(*) as count'))
                          ->groupBy('industries.id', 'industries.name')
                          ->orderByDesc('count')
                          ->take(8)
                          ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'recentUsers', 
            'recentJobs', 
            'recentApplications',
            'monthlyStats',
            'popularSkills',
            'industryStats'
        ));
    }

    /**
     * Get monthly statistics for charts
     */
    private function getMonthlyStats()
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months->push([
                'month' => $date->format('M Y'),
                'users' => User::whereYear('created_at', $date->year)
                             ->whereMonth('created_at', $date->month)
                             ->count(),
                'jobs' => Job::whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)
                            ->count(),
                'applications' => Application::whereYear('created_at', $date->year)
                                            ->whereMonth('created_at', $date->month)
                                            ->count(),
            ]);
        }
        
        return $months;
    }

    /**
     * Get system overview data
     */
    public function systemOverview()
    {
        $overview = [
            'database_size' => $this->getDatabaseSize(),
            'storage_usage' => $this->getStorageUsage(),
            'cache_status' => $this->getCacheStatus(),
            'queue_status' => $this->getQueueStatus(),
        ];

        return response()->json($overview);
    }

    /**
     * Get database size (simplified)
     */
    private function getDatabaseSize()
    {
        try {
            $size = DB::select("SELECT 
                ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS size_mb
                FROM information_schema.tables 
                WHERE table_schema = DATABASE()")[0]->size_mb ?? 0;
            
            return $size . ' MB';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    /**
     * Get storage usage (simplified)
     */
    private function getStorageUsage()
    {
        try {
            $bytes = disk_total_space(storage_path()) - disk_free_space(storage_path());
            return round($bytes / 1024 / 1024, 1) . ' MB';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    /**
     * Get cache status
     */
    private function getCacheStatus()
    {
        try {
            cache()->put('test_key', 'test_value', 60);
            return cache()->get('test_key') === 'test_value' ? 'Working' : 'Failed';
        } catch (\Exception $e) {
            return 'Failed';
        }
    }

    /**
     * Get queue status (simplified)
     */
    private function getQueueStatus()
    {
        try {
            return 'Active'; // Simplified for now
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }
}
