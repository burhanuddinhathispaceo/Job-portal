<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Candidate;
use App\Models\Application;
use App\Models\Bookmark;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Show candidate dashboard
     */
    public function dashboard()
    {
        $candidate = auth()->user()->candidate;
        $applicationsCount = Application::where('candidate_id', $candidate->id)->count();
        $bookmarksCount = Bookmark::where('user_id', auth()->id())->count();
        
        $recentApplications = Application::where('candidate_id', $candidate->id)
                                        ->with(['job.company.user'])
                                        ->latest()
                                        ->take(5)
                                        ->get();
        
        return view('candidate.dashboard', compact('candidate', 'applicationsCount', 'bookmarksCount', 'recentApplications'));
    }

    /**
     * Show candidate profile
     */
    public function profile()
    {
        $candidate = auth()->user()->candidate;
        return view('candidate.profile', compact('candidate'));
    }

    /**
     * Update candidate profile
     */
    public function updateProfile(Request $request)
    {
        // Implementation for updating candidate profile
        return redirect()->route('candidate.profile')->with('success', 'Profile updated successfully');
    }

    /**
     * Show candidate applications
     */
    public function applications()
    {
        $candidate = auth()->user()->candidate;
        $applications = Application::where('candidate_id', $candidate->id)
                                  ->with(['job.company.user'])
                                  ->latest()
                                  ->paginate(20);
        
        return view('candidate.applications', compact('applications'));
    }

    /**
     * Apply to a job
     */
    public function applyToJob(Request $request, Job $job)
    {
        $candidate = auth()->user()->candidate;
        
        // Check if already applied
        $existingApplication = Application::where('candidate_id', $candidate->id)
                                         ->where('job_id', $job->id)
                                         ->first();
        
        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already applied for this job.');
        }
        
        // Implementation for job application
        Application::create([
            'candidate_id' => $candidate->id,
            'job_id' => $job->id,
            'status' => 'pending',
            'cover_letter' => $request->cover_letter,
            'applied_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Application submitted successfully.');
    }

    /**
     * Show bookmarks
     */
    public function bookmarks()
    {
        $bookmarks = Bookmark::where('user_id', auth()->id())
                            ->with(['job.company.user'])
                            ->latest()
                            ->paginate(20);
        
        return view('candidate.bookmarks', compact('bookmarks'));
    }

    /**
     * Store bookmark
     */
    public function storeBookmark(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
        ]);
        
        // Check if already bookmarked
        $existing = Bookmark::where('user_id', auth()->id())
                           ->where('job_id', $request->job_id)
                           ->first();
        
        if ($existing) {
            return response()->json(['error' => 'Job already bookmarked'], 400);
        }
        
        Bookmark::create([
            'user_id' => auth()->id(),
            'job_id' => $request->job_id,
        ]);
        
        return response()->json(['success' => 'Job bookmarked successfully']);
    }

    /**
     * Remove bookmark
     */
    public function destroyBookmark(Bookmark $bookmark)
    {
        if ($bookmark->user_id !== auth()->id()) {
            abort(403);
        }
        
        $bookmark->delete();
        
        return redirect()->back()->with('success', 'Bookmark removed successfully');
    }
}
