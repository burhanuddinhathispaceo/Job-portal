<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use App\Models\Application;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Show company dashboard
     */
    public function dashboard()
    {
        $company = auth()->user()->company;
        $jobsCount = Job::where('company_id', $company->id)->count();
        $applicationsCount = Application::whereHas('job', function($query) use ($company) {
            $query->where('company_id', $company->id);
        })->count();
        
        $recentJobs = Job::where('company_id', $company->id)
                         ->latest()
                         ->take(5)
                         ->get();
        
        return view('company.dashboard', compact('company', 'jobsCount', 'applicationsCount', 'recentJobs'));
    }

    /**
     * Show company profile
     */
    public function profile()
    {
        $company = auth()->user()->company;
        return view('company.profile', compact('company'));
    }

    /**
     * Update company profile
     */
    public function updateProfile(Request $request)
    {
        // Implementation for updating company profile
        return redirect()->route('company.profile')->with('success', 'Profile updated successfully');
    }

    /**
     * Show company jobs
     */
    public function jobs()
    {
        $company = auth()->user()->company;
        $jobs = Job::where('company_id', $company->id)
                   ->with(['location', 'industry'])
                   ->latest()
                   ->paginate(20);
        
        return view('company.jobs.index', compact('jobs'));
    }

    /**
     * Show job creation form
     */
    public function createJob()
    {
        return view('company.jobs.create');
    }

    /**
     * Store new job
     */
    public function storeJob(Request $request)
    {
        // Implementation for storing new job
        return redirect()->route('company.jobs.index')->with('success', 'Job posted successfully');
    }

    /**
     * Show specific job
     */
    public function showJob(Job $job)
    {
        return view('company.jobs.show', compact('job'));
    }

    /**
     * Show applications
     */
    public function applications()
    {
        $company = auth()->user()->company;
        $applications = Application::whereHas('job', function($query) use ($company) {
            $query->where('company_id', $company->id);
        })->with(['candidate.user', 'job'])->latest()->paginate(20);
        
        return view('company.applications.index', compact('applications'));
    }
}
