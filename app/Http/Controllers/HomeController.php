<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use App\Models\Candidate;
use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the homepage
     */
    public function index()
    {
        $stats = [
            'total_jobs' => Job::where('status', 'active')->count(),
            'total_companies' => Company::where('verification_status', 'verified')->count(),
            'total_candidates' => Candidate::count(),
            'total_applications' => Application::count(),
        ];
        
        $recentJobs = Job::with('company')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
            
        $featuredCompanies = Company::with('user')
            ->where('verification_status', 'verified')
            ->whereHas('jobs', function($query) {
                $query->where('status', 'active');
            })
            ->withCount('jobs')
            ->orderBy('jobs_count', 'desc')
            ->take(8)
            ->get();
            
        $jobCategories = [
            ['name' => 'Technology', 'count' => Job::where('status', 'active')->whereHas('jobType', function($q) { $q->where('name', 'like', '%Tech%'); })->count(), 'icon' => 'laptop'],
            ['name' => 'Marketing', 'count' => Job::where('status', 'active')->whereHas('jobType', function($q) { $q->where('name', 'like', '%Market%'); })->count(), 'icon' => 'bullhorn'],
            ['name' => 'Design', 'count' => Job::where('status', 'active')->whereHas('jobType', function($q) { $q->where('name', 'like', '%Design%'); })->count(), 'icon' => 'palette'],
            ['name' => 'Sales', 'count' => Job::where('status', 'active')->whereHas('jobType', function($q) { $q->where('name', 'like', '%Sales%'); })->count(), 'icon' => 'chart-line'],
            ['name' => 'Finance', 'count' => Job::where('status', 'active')->whereHas('jobType', function($q) { $q->where('name', 'like', '%Finance%'); })->count(), 'icon' => 'dollar-sign'],
            ['name' => 'Healthcare', 'count' => Job::where('status', 'active')->whereHas('jobType', function($q) { $q->where('name', 'like', '%Health%'); })->count(), 'icon' => 'heartbeat'],
        ];
        
        return view('welcome', compact('stats', 'recentJobs', 'featuredCompanies', 'jobCategories'));
    }
}
