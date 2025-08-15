<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    /**
     * Display a listing of jobs
     */
    public function index(Request $request): JsonResponse
    {
        $query = Job::with(['company', 'jobType', 'skills'])
                    ->active()
                    ->published();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by job type
        if ($request->has('job_type_id')) {
            $query->where('job_type_id', $request->job_type_id);
        }

        // Filter by location
        if ($request->has('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Filter by remote
        if ($request->has('is_remote')) {
            $query->where('is_remote', $request->boolean('is_remote'));
        }

        // Filter by salary range
        if ($request->has('salary_min')) {
            $query->where('salary_max', '>=', $request->salary_min);
        }
        if ($request->has('salary_max')) {
            $query->where('salary_min', '<=', $request->salary_max);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->get('per_page', 50);
        $jobs = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $jobs,
        ]);
    }

    /**
     * Display the specified job
     */
    public function show(Job $job): JsonResponse
    {
        // Increment view count
        $job->incrementViews();

        $job->load(['company.user', 'jobType', 'skills', 'applications.candidate']);

        return response()->json([
            'success' => true,
            'data' => $job,
        ]);
    }

    /**
     * Store a newly created job (Company only)
     */
    public function store(Request $request): JsonResponse
    {
        if (!auth()->user()->isCompany()) {
            return response()->json([
                'success' => false,
                'message' => 'Only companies can create jobs',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'job_type_id' => 'nullable|exists:job_types,id',
            'location' => 'nullable|string|max:255',
            'is_remote' => 'boolean',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'salary_currency' => 'nullable|string|size:3',
            'experience_min' => 'nullable|integer|min:0',
            'experience_max' => 'nullable|integer|min:0|gte:experience_min',
            'education_level' => 'nullable|string|max:100',
            'application_deadline' => 'nullable|date|after:today',
            'visibility' => 'nullable|in:normal,highlighted,featured',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $job = Job::create([
                'company_id' => auth()->user()->company->id,
                'title' => $request->title,
                'description' => $request->description,
                'requirements' => $request->requirements,
                'responsibilities' => $request->responsibilities,
                'job_type_id' => $request->job_type_id,
                'location' => $request->location,
                'is_remote' => $request->boolean('is_remote'),
                'salary_min' => $request->salary_min,
                'salary_max' => $request->salary_max,
                'salary_currency' => $request->salary_currency ?? 'USD',
                'experience_min' => $request->experience_min ?? 0,
                'experience_max' => $request->experience_max,
                'education_level' => $request->education_level,
                'application_deadline' => $request->application_deadline,
                'visibility' => $request->visibility ?? 'normal',
                'status' => 'draft',
            ]);

            // Attach skills if provided
            if ($request->has('skills')) {
                $skillsData = [];
                foreach ($request->skills as $skillId) {
                    $skillsData[$skillId] = ['is_required' => true];
                }
                $job->skills()->attach($skillsData);
            }

            $job->load(['jobType', 'skills']);

            return response()->json([
                'success' => true,
                'message' => 'Job created successfully',
                'data' => $job,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Job creation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
