<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission = null): Response
    {
        if (!auth()->guard('admin')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect()->route('admin.login');
        }

        $admin = auth()->guard('admin')->user();

        if (!$admin->isActive()) {
            auth()->guard('admin')->logout();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Your account has been deactivated.'
            ]);
        }

        // Admin role has all permissions - bypass permission check
        if ($admin->isAdmin()) {
            return $next($request);
        }

        // Check specific permission if provided for non-admin users
        if ($permission && !$admin->hasPermission($permission)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
