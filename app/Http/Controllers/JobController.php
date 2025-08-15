<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of jobs
     */
    public function index(Request $request)
    {
        $query = Job::with(['company', 'jobType', 'skills'])
            ->where('status', 'active')
            ->where('visibility', '!=', 'private'); // Exclude private jobs from public listing

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('company', function($companyQuery) use ($search) {
                      $companyQuery->where('company_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('skills', function($skillQuery) use ($search) {
                      $skillQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Remote work filter
        if ($request->filled('employment_type') && in_array('remote', $request->employment_type)) {
            $query->where('is_remote', true);
        }

        // Experience range filter (using experience_min and experience_max)
        if ($request->filled('experience_level')) {
            switch ($request->experience_level) {
                case 'entry':
                    $query->where('experience_min', '<=', 2);
                    break;
                case 'mid':
                    $query->whereBetween('experience_min', [2, 5]);
                    break;
                case 'senior':
                    $query->where('experience_min', '>=', 5);
                    break;
            }
        }

        // Salary range filter
        if ($request->filled('salary_min')) {
            $query->where('salary_max', '>=', $request->salary_min);
        }
        if ($request->filled('salary_max')) {
            $query->where('salary_min', '<=', $request->salary_max);
        }

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'salary_high':
                $query->orderByDesc('salary_max');
                break;
            case 'salary_low':
                $query->orderBy('salary_min');
                break;
            case 'company':
                $query->join('companies', 'jobs.company_id', '=', 'companies.id')
                      ->orderBy('companies.company_name');
                break;
            default:
                $query->latest();
        }

        $jobs = $query->paginate(20);
        
        // Get total jobs count for the hero section
        $totalJobs = Job::where('status', 'active')->count();

        return view('jobs.index', compact('jobs', 'totalJobs'));
    }

    /**
     * Display the specified job
     */
    public function show(Job $job)
    {
        $job->load(['company.user', 'location', 'industry', 'skills']);
        
        return view('jobs.show', compact('job'));
    }
}
