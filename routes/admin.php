<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ReportController;
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
        // General Users
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
        Route::post('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::post('/users/{user}/suspend', [UserManagementController::class, 'suspend'])->name('users.suspend');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/bulk-import', [UserManagementController::class, 'bulkImport'])->name('users.bulk-import');
        Route::get('/users/bulk-export', [UserManagementController::class, 'bulkExport'])->name('users.bulk-export');
        Route::get('/users/statistics', [UserManagementController::class, 'getStatistics'])->name('users.statistics');
        
        // Companies
        Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
        Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show');
        Route::get('/companies/{company}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
        Route::put('/companies/{company}', [CompanyController::class, 'update'])->name('companies.update');
        Route::post('/companies/{company}/verify', [CompanyController::class, 'verify'])->name('companies.verify');
        Route::post('/companies/{company}/reject-verification', [CompanyController::class, 'rejectVerification'])->name('companies.reject-verification');
        Route::post('/companies/{company}/suspend', [CompanyController::class, 'suspend'])->name('companies.suspend');
        Route::get('/companies/{company}/analytics', [CompanyController::class, 'analytics'])->name('companies.analytics');
        Route::get('/companies/statistics', [CompanyController::class, 'getStatistics'])->name('companies.statistics');
        Route::get('/companies/export', [CompanyController::class, 'export'])->name('companies.export');
        
        // Candidates
        Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
        Route::get('/candidates/{candidate}', [CandidateController::class, 'show'])->name('candidates.show');
        Route::get('/candidates/{candidate}/edit', [CandidateController::class, 'edit'])->name('candidates.edit');
        Route::put('/candidates/{candidate}', [CandidateController::class, 'update'])->name('candidates.update');
        Route::post('/candidates/{candidate}/suspend', [CandidateController::class, 'suspend'])->name('candidates.suspend');
        Route::get('/candidates/{candidate}/analytics', [CandidateController::class, 'analytics'])->name('candidates.analytics');
        Route::get('/candidates/statistics', [CandidateController::class, 'getStatistics'])->name('candidates.statistics');
        Route::get('/candidates/export', [CandidateController::class, 'export'])->name('candidates.export');
    });
    
    // Content Management
    Route::middleware('admin:content.moderate')->group(function () {
        // Jobs
        Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
        Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
        Route::post('/jobs/{job}/change-status', [JobController::class, 'changeStatus'])->name('jobs.change-status');
        Route::post('/jobs/{job}/change-visibility', [JobController::class, 'changeVisibility'])->name('jobs.change-visibility');
        Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
        Route::get('/jobs/{job}/analytics', [JobController::class, 'analytics'])->name('jobs.analytics');
        Route::get('/jobs/statistics', [JobController::class, 'getStatistics'])->name('jobs.statistics');
        Route::get('/jobs/export', [JobController::class, 'export'])->name('jobs.export');
        
        // Projects
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::post('/projects/{project}/change-status', [ProjectController::class, 'changeStatus'])->name('projects.change-status');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::get('/projects/statistics', [ProjectController::class, 'getStatistics'])->name('projects.statistics');
    });
    
    // System Configuration
    Route::middleware('admin:system.configure')->group(function () {
        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::get('/settings/job-types', [SettingsController::class, 'jobTypes'])->name('settings.job-types');
        Route::post('/settings/job-types', [SettingsController::class, 'storeJobType'])->name('settings.store-job-type');
        Route::get('/settings/industries', [SettingsController::class, 'industries'])->name('settings.industries');
        Route::get('/settings/skills', [SettingsController::class, 'skills'])->name('settings.skills');
        Route::get('/settings/website', [SettingsController::class, 'websiteSettings'])->name('settings.website');
        Route::put('/settings/website', [SettingsController::class, 'updateWebsiteSettings'])->name('settings.update-website');
    });
    
    // Subscription Management
    Route::middleware('admin:subscriptions.manage')->group(function () {
        Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show'])->name('subscriptions.show');
        Route::post('/subscriptions/{subscription}/update-status', [SubscriptionController::class, 'updateStatus'])->name('subscriptions.update-status');
        Route::get('/subscriptions/statistics', [SubscriptionController::class, 'getStatistics'])->name('subscriptions.statistics');
        
        // Subscription Plans
        Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
        Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
        Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
        Route::get('/plans/{plan}/edit', [PlanController::class, 'edit'])->name('plans.edit');
        Route::put('/plans/{plan}', [PlanController::class, 'update'])->name('plans.update');
        Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');
    });
    
    // Analytics
    Route::middleware('admin:analytics.view')->group(function () {
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
        Route::get('/analytics/system-stats', [AnalyticsController::class, 'systemStats'])->name('analytics.system-stats');
        Route::get('/analytics/user-growth', [AnalyticsController::class, 'userGrowth'])->name('analytics.user-growth');
        Route::get('/analytics/revenue-reports', [AnalyticsController::class, 'revenueReports'])->name('analytics.revenue-reports');
        Route::get('/analytics/job-trends', [AnalyticsController::class, 'jobTrends'])->name('analytics.job-trends');
        Route::get('/analytics/top-performing', [AnalyticsController::class, 'topPerforming'])->name('analytics.top-performing');
    });
    
    // Reports
    Route::middleware('admin:analytics.view')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports/user-activity', [ReportController::class, 'userActivity'])->name('reports.user-activity');
        Route::post('/reports/job-performance', [ReportController::class, 'jobPerformance'])->name('reports.job-performance');
        Route::post('/reports/revenue-analysis', [ReportController::class, 'revenueAnalysis'])->name('reports.revenue-analysis');
        Route::post('/reports/application-trends', [ReportController::class, 'applicationTrends'])->name('reports.application-trends');
        Route::post('/reports/company-performance', [ReportController::class, 'companyPerformance'])->name('reports.company-performance');
        Route::get('/reports/system-health', [ReportController::class, 'systemHealth'])->name('reports.system-health');
        Route::post('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    });
    
});