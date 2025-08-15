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
        $jobs = Job::with(['company.user', 'location', 'industry'])
                   ->where('status', 'published')
                   ->when($request->search, function($query, $search) {
                       $query->where('title', 'like', "%{$search}%")
                             ->orWhere('description', 'like', "%{$search}%");
                   })
                   ->when($request->location, function($query, $location) {
                       $query->whereHas('location', function($q) use ($location) {
                           $q->where('city', 'like', "%{$location}%")
                             ->orWhere('state', 'like', "%{$location}%");
                       });
                   })
                   ->latest()
                   ->paginate(20);

        return view('jobs.index', compact('jobs'));
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
