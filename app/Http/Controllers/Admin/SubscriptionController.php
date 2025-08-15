<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Admin Subscription Management Controller
 * Implements: REQ-ADM-013 to REQ-ADM-016
 * 
 * Handles subscription monitoring and management
 */
class SubscriptionController extends Controller
{
    /**
     * Display subscriptions list
     */
    public function index(Request $request)
    {
        $query = Subscription::with(['company.user', 'plan']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->plan_id);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('company', function ($q) use ($searchTerm) {
                $q->where('company_name', 'like', "%{$searchTerm}%");
            });
        }

        $subscriptions = $query->orderBy('created_at', 'desc')->paginate(50);

        $stats = [
            'total_subscriptions' => Subscription::count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'expired_subscriptions' => Subscription::where('status', 'expired')->count(),
            'cancelled_subscriptions' => Subscription::where('status', 'cancelled')->count(),
            'total_revenue' => Subscription::where('status', 'active')->sum('amount_paid'),
        ];

        $plans = SubscriptionPlan::where('is_active', true)->get();

        return view('admin.subscriptions.index', compact('subscriptions', 'stats', 'plans'));
    }

    /**
     * Show subscription details
     */
    public function show(Subscription $subscription)
    {
        $subscription->load(['company.user', 'plan']);

        return view('admin.subscriptions.show', compact('subscription'));
    }

    /**
     * Update subscription status
     */
    public function updateStatus(Request $request, Subscription $subscription)
    {
        $request->validate([
            'status' => 'required|in:active,expired,cancelled,suspended',
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $subscription->update([
                'status' => $request->status,
                'admin_notes' => $request->reason,
            ]);

            return response()->json([
                'success' => true,
                'message' => __('admin.subscriptions.status_updated')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.subscriptions.status_update_failed')
            ], 500);
        }
    }

    /**
     * Get subscription statistics
     */
    public function getStatistics()
    {
        $stats = [
            'total_subscriptions' => Subscription::count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'monthly_revenue' => Subscription::where('status', 'active')
                                           ->where('created_at', '>=', now()->startOfMonth())
                                           ->sum('amount_paid'),
            'renewal_rate' => $this->calculateRenewalRate(),
        ];

        return response()->json($stats);
    }

    /**
     * Calculate renewal rate
     */
    private function calculateRenewalRate()
    {
        $expiredCount = Subscription::where('status', 'expired')
                                  ->where('end_date', '>=', now()->subDays(30))
                                  ->count();

        $renewedCount = Subscription::where('status', 'active')
                                  ->where('created_at', '>=', now()->subDays(30))
                                  ->count();

        if ($expiredCount === 0) return 0;

        return round(($renewedCount / $expiredCount) * 100);
    }
}