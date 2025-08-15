<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show admin login form
     */
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.login');
    }

    /**
     * Handle admin login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        // Check if admin user exists and is active
        $admin = User::where('email', $request->email)->where('role', 'admin')->first();
        
        if (!$admin || !$admin->isActive()) {
            return back()->withErrors([
                'email' => 'Invalid credentials or account is inactive.',
            ])->onlyInput('email');
        }

        // Add role check to credentials
        $credentials['role'] = 'admin';

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Update last login timestamp
            $admin->update(['last_login_at' => now()]);

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle admin logout request
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Show admin registration form (for development only)
     */
    public function showRegister()
    {
        // Only allow in development environment
        if (!app()->environment('local')) {
            abort(404);
        }
        
        return view('admin.auth.register');
    }

    /**
     * Handle admin registration request (for development only)
     */
    public function register(Request $request)
    {
        // Only allow in development environment
        if (!app()->environment('local')) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'mobile' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $admin = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->mobile,
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            Auth::guard('admin')->login($admin);

            return redirect()->route('admin.dashboard');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
        }
    }
}
