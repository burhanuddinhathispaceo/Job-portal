<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use App\Models\JobType;
use App\Models\ProjectType;
use App\Models\Industry;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Admin Settings Controller
 * Implements: REQ-ADM-008
 * 
 * Handles system constants and configuration management
 */
class SettingsController extends Controller
{
    /**
     * Display settings dashboard
     */
    public function index()
    {
        $stats = [
            'job_types' => JobType::count(),
            'project_types' => ProjectType::count(),
            'industries' => Industry::count(),
            'skills' => Skill::count(),
            'website_settings' => WebsiteSetting::count(),
        ];

        return view('admin.settings.index', compact('stats'));
    }

    /**
     * Manage job types
     */
    public function jobTypes(Request $request)
    {
        $query = JobType::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $jobTypes = $query->orderBy('name')->paginate(50);

        return view('admin.settings.job-types', compact('jobTypes'));
    }

    /**
     * Store new job type
     */
    public function storeJobType(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:job_types',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            JobType::create([
                'name' => $request->name,
                'slug' => \Str::slug($request->name),
                'description' => $request->description,
                'is_active' => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => __('admin.settings.job_type_created')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.settings.job_type_creation_failed')
            ], 500);
        }
    }

    /**
     * Manage industries
     */
    public function industries(Request $request)
    {
        $query = Industry::with('parent');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $industries = $query->orderBy('name')->paginate(50);

        return view('admin.settings.industries', compact('industries'));
    }

    /**
     * Manage skills
     */
    public function skills(Request $request)
    {
        $query = Skill::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $skills = $query->orderBy('name')->paginate(50);
        $categories = Skill::distinct()->pluck('category')->filter();

        return view('admin.settings.skills', compact('skills', 'categories'));
    }

    /**
     * Website settings
     */
    public function websiteSettings()
    {
        $settings = WebsiteSetting::orderBy('group', 'asc')->orderBy('key', 'asc')->get();
        $groupedSettings = $settings->groupBy('group');

        return view('admin.settings.website', compact('groupedSettings'));
    }

    /**
     * Update website settings
     */
    public function updateWebsiteSettings(Request $request)
    {
        try {
            DB::beginTransaction();

            foreach ($request->all() as $key => $value) {
                if ($key !== '_token') {
                    WebsiteSetting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value]
                    );
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.settings.website')
                ->with('success', __('admin.settings.website_settings_updated'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => __('admin.settings.update_failed')])
                ->withInput();
        }
    }
}