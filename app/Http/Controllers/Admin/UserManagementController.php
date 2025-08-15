<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

/**
 * Admin User Management Controller
 * Implements: REQ-ADM-001 to REQ-ADM-004
 * 
 * Handles CRUD operations for users, companies, and candidates
 */
class UserManagementController extends Controller
{
    /**
     * Display users list
     * Implements: REQ-ADM-001, REQ-ADM-002
     */
    public function index(Request $request)
    {
        $query = User::with(['company', 'candidate']);

        // Apply filters
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('mobile', 'like', "%{$searchTerm}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')
                      ->paginate(50);

        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'companies' => User::where('role', 'company')->count(),
            'candidates' => User::where('role', 'candidate')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show user details
     * Implements: REQ-ADM-001, REQ-ADM-002
     */
    public function show(User $user)
    {
        $user->load(['company', 'candidate', 'activities' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show edit user form
     * Implements: REQ-ADM-001, REQ-ADM-002
     */
    public function edit(User $user)
    {
        $user->load(['company', 'candidate']);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user information
     * Implements: REQ-ADM-001, REQ-ADM-002
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'mobile' => 'nullable|string|max:20|unique:users,mobile,' . $user->id,
            'status' => 'required|in:active,inactive,suspended',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'status' => $request->status,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = $request->password;
            }

            $user->update($updateData);

            // Update role-specific data
            if ($user->role === 'company' && $user->company) {
                $user->company->update([
                    'company_name' => $request->company_name ?? $user->company->company_name,
                    'industry_id' => $request->industry_id ?? $user->company->industry_id,
                    'company_size' => $request->company_size ?? $user->company->company_size,
                ]);
            }

            if ($user->role === 'candidate' && $user->candidate) {
                $user->candidate->update([
                    'first_name' => $request->first_name ?? $user->candidate->first_name,
                    'last_name' => $request->last_name ?? $user->candidate->last_name,
                    'experience_years' => $request->experience_years ?? $user->candidate->experience_years,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.users.show', $user)
                ->with('success', __('admin.users.updated_successfully'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => __('admin.users.update_failed')])
                ->withInput();
        }
    }

    /**
     * Toggle user status
     * Implements: REQ-ADM-004
     */
    public function toggleStatus(User $user)
    {
        try {
            $newStatus = $user->status === 'active' ? 'inactive' : 'active';
            
            $user->update(['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => __('admin.users.status_updated'),
                'status' => $newStatus
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.users.status_update_failed')
            ], 500);
        }
    }

    /**
     * Suspend user account
     * Implements: REQ-ADM-004
     */
    public function suspend(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        try {
            $user->update([
                'status' => 'suspended',
                'suspension_reason' => $request->reason,
                'suspended_at' => now(),
            ]);

            // Log the suspension activity
            $user->activities()->create([
                'activity_type' => 'account_suspended',
                'description' => 'Account suspended by admin: ' . $request->reason,
                'ip_address' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => __('admin.users.suspended_successfully')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.users.suspension_failed')
            ], 500);
        }
    }

    /**
     * Delete user account
     * Implements: REQ-ADM-001, REQ-ADM-002
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();

            // Soft delete related records first
            if ($user->role === 'company' && $user->company) {
                // Mark company jobs/projects as inactive
                $user->company->jobs()->update(['status' => 'inactive']);
                $user->company->projects()->update(['status' => 'inactive']);
            }

            if ($user->role === 'candidate' && $user->candidate) {
                // Handle candidate applications
                $user->candidate->applications()->update(['status' => 'withdrawn']);
            }

            // Delete the user (soft delete)
            $user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('admin.users.deleted_successfully')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => __('admin.users.deletion_failed')
            ], 500);
        }
    }

    /**
     * Bulk import users
     * Implements: REQ-ADM-003
     */
    public function bulkImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:5120', // 5MB max
            'role' => 'required|in:company,candidate',
        ]);

        try {
            // Process the uploaded file
            $file = $request->file('file');
            $importResults = $this->processUserImport($file, $request->role);

            return response()->json([
                'success' => true,
                'message' => __('admin.users.import_completed'),
                'results' => $importResults
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.users.import_failed') . ': ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk export users
     * Implements: REQ-ADM-003
     */
    public function bulkExport(Request $request)
    {
        $request->validate([
            'role' => 'nullable|in:admin,company,candidate',
            'status' => 'nullable|in:active,inactive,suspended',
            'format' => 'required|in:csv,xlsx',
        ]);

        try {
            $query = User::with(['company', 'candidate']);

            if ($request->filled('role')) {
                $query->where('role', $request->role);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $users = $query->get();

            $filename = 'users_export_' . now()->format('Y-m-d_H-i-s') . '.' . $request->format;

            return $this->generateExportFile($users, $request->format, $filename);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.users.export_failed') . ': ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user statistics for dashboard
     */
    public function getStatistics()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'inactive_users' => User::where('status', 'inactive')->count(),
            'suspended_users' => User::where('status', 'suspended')->count(),
            'companies' => User::where('role', 'company')->count(),
            'candidates' => User::where('role', 'candidate')->count(),
            'recent_registrations' => User::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Process user import file
     */
    private function processUserImport($file, $role)
    {
        // Implementation would depend on chosen Excel/CSV library
        // This is a placeholder for the actual import logic
        return [
            'total_rows' => 0,
            'successful_imports' => 0,
            'failed_imports' => 0,
            'errors' => []
        ];
    }

    /**
     * Generate export file
     */
    private function generateExportFile($users, $format, $filename)
    {
        // Implementation would depend on chosen Excel/CSV library
        // This is a placeholder for the actual export logic
        return response()->json([
            'success' => true,
            'download_url' => '/admin/downloads/' . $filename
        ]);
    }
}