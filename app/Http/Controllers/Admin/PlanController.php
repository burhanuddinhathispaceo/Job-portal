<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Admin Subscription Plan Management Controller
 * Implements: REQ-ADM-013 to REQ-ADM-016
 * 
 * Handles subscription plan creation and management
 */
class PlanController extends Controller
{
    /**
     * Display subscription plans list
     */
    public function index(Request $request)
    {
        $query = SubscriptionPlan::query();

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $plans = $query->orderBy('price', 'asc')->paginate(50);

        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show create plan form
     */
    public function create()
    {
        return view('admin.plans.create');
    }

    /**
     * Store new subscription plan
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:subscription_plans',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'duration_days' => 'required|integer|min:1',
            'job_post_limit' => 'required|integer|min:0',
            'project_post_limit' => 'required|integer|min:0',
            'featured_posts' => 'required|integer|min:0',
            'highlighted_posts' => 'required|integer|min:0',
            'candidate_search' => 'boolean',
            'candidate_view_limit' => 'required|integer|min:0',
            'analytics_access' => 'boolean',
            'priority_support' => 'boolean',
            'is_active' => 'boolean',
        ]);

        try {
            SubscriptionPlan::create($request->all());

            return redirect()
                ->route('admin.plans.index')
                ->with('success', __('admin.plans.created_successfully'));

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => __('admin.plans.creation_failed')])
                ->withInput();
        }
    }

    /**
     * Show edit plan form
     */
    public function edit(SubscriptionPlan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    /**
     * Update subscription plan
     */
    public function update(Request $request, SubscriptionPlan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:subscription_plans,name,' . $plan->id,
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'duration_days' => 'required|integer|min:1',
            'job_post_limit' => 'required|integer|min:0',
            'project_post_limit' => 'required|integer|min:0',
            'featured_posts' => 'required|integer|min:0',
            'highlighted_posts' => 'required|integer|min:0',
            'candidate_search' => 'boolean',
            'candidate_view_limit' => 'required|integer|min:0',
            'analytics_access' => 'boolean',
            'priority_support' => 'boolean',
            'is_active' => 'boolean',
        ]);

        try {
            $plan->update($request->all());

            return redirect()
                ->route('admin.plans.index')
                ->with('success', __('admin.plans.updated_successfully'));

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => __('admin.plans.update_failed')])
                ->withInput();
        }
    }

    /**
     * Delete subscription plan
     */
    public function destroy(SubscriptionPlan $plan)
    {
        try {
            // Check if plan is in use
            if ($plan->subscriptions()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => __('admin.plans.cannot_delete_in_use')
                ], 400);
            }

            $plan->delete();

            return response()->json([
                'success' => true,
                'message' => __('admin.plans.deleted_successfully')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.plans.deletion_failed')
            ], 500);
        }
    }
}