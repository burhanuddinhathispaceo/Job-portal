<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here are the admin-specific routes for the application.
| All routes are prefixed with '/admin' and use admin guard.
|
*/

// Admin Authentication Routes (Guest)
Route::middleware('guest:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Development only - register route
    if (app()->environment('local')) {
        Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
    }
});

// Admin Authenticated Routes
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/system-overview', [DashboardController::class, 'systemOverview'])->name('system.overview');
    
    // Authentication
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // User Management
    Route::middleware('admin:users.manage')->group(function () {
        Route::get('/users', function () {
            return view('admin.users.index');
        })->name('users.index');
        
        Route::get('/companies', function () {
            return view('admin.companies.index');
        })->name('companies.index');
        
        Route::get('/candidates', function () {
            return view('admin.candidates.index');
        })->name('candidates.index');
    });
    
    // Content Management
    Route::middleware('admin:content.moderate')->group(function () {
        Route::get('/jobs', function () {
            return view('admin.jobs.index');
        })->name('jobs.index');
        
        Route::get('/projects', function () {
            return view('admin.projects.index');
        })->name('projects.index');
    });
    
    // System Configuration
    Route::middleware('admin:system.configure')->group(function () {
        Route::get('/settings', function () {
            return view('admin.settings.index');
        })->name('settings.index');
        
        Route::get('/website', function () {
            return view('admin.website.index');
        })->name('website.index');
    });
    
    // Subscription Management
    Route::middleware('admin:subscriptions.manage')->group(function () {
        Route::get('/subscriptions', function () {
            return view('admin.subscriptions.index');
        })->name('subscriptions.index');
        
        Route::get('/plans', function () {
            return view('admin.plans.index');
        })->name('plans.index');
    });
    
    // Analytics
    Route::middleware('admin:analytics.view')->group(function () {
        Route::get('/analytics', function () {
            return view('admin.analytics.index');
        })->name('analytics.index');
        
        Route::get('/reports', function () {
            return view('admin.reports.index');
        })->name('reports.index');
    });
    
});