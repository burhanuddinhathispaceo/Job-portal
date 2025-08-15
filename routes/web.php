<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {
    
    // Company routes
    Route::middleware('role:company')->prefix('company')->name('company.')->group(function () {
        Route::get('/dashboard', [CompanyController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [CompanyController::class, 'profile'])->name('profile');
        Route::put('/profile', [CompanyController::class, 'updateProfile'])->name('profile.update');
        
        // Job management
        Route::get('/jobs', [CompanyController::class, 'jobs'])->name('jobs.index');
        Route::get('/jobs/create', [CompanyController::class, 'createJob'])->name('jobs.create');
        Route::post('/jobs', [CompanyController::class, 'storeJob'])->name('jobs.store');
        Route::get('/jobs/{job}', [CompanyController::class, 'showJob'])->name('jobs.show');
        Route::get('/jobs/{job}/edit', [CompanyController::class, 'editJob'])->name('jobs.edit');
        Route::put('/jobs/{job}', [CompanyController::class, 'updateJob'])->name('jobs.update');
        Route::delete('/jobs/{job}', [CompanyController::class, 'destroyJob'])->name('jobs.destroy');
        Route::post('/jobs/{job}/publish', [CompanyController::class, 'publishJob'])->name('jobs.publish');
        
        // Applications
        Route::get('/applications', [CompanyController::class, 'applications'])->name('applications.index');
        Route::get('/applications/{application}', [CompanyController::class, 'showApplication'])->name('applications.show');
        Route::put('/applications/{application}', [CompanyController::class, 'updateApplication'])->name('applications.update');
    });
    
    // Candidate routes
    Route::middleware('role:candidate')->prefix('candidate')->name('candidate.')->group(function () {
        Route::get('/dashboard', [CandidateController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [CandidateController::class, 'profile'])->name('profile');
        Route::put('/profile', [CandidateController::class, 'updateProfile'])->name('profile.update');
        
        // Applications
        Route::get('/applications', [CandidateController::class, 'applications'])->name('applications.index');
        Route::post('/jobs/{job}/apply', [CandidateController::class, 'applyToJob'])->name('jobs.apply');
        
        // Bookmarks
        Route::get('/bookmarks', [CandidateController::class, 'bookmarks'])->name('bookmarks.index');
        Route::post('/bookmarks', [CandidateController::class, 'storeBookmark'])->name('bookmarks.store');
        Route::delete('/bookmarks/{bookmark}', [CandidateController::class, 'destroyBookmark'])->name('bookmarks.destroy');
    });
    
    // Admin routes (future implementation)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });
});
