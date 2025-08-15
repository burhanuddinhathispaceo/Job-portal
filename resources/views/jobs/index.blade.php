@extends('layouts.app')

@section('title', 'Browse Jobs')

@section('content')
<!-- Hero Section -->
<div class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold text-white mb-3">Find Your Dream Job</h1>
                <p class="lead text-white-75 mb-4">Discover amazing opportunities from top companies worldwide</p>
                
                <!-- Quick Search -->
                <form action="{{ route('jobs.index') }}" method="GET" class="search-form">
                    <div class="row g-2">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-0" 
                                       placeholder="Job title, keywords..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0">
                                    <i class="fas fa-map-marker-alt text-muted"></i>
                                </span>
                                <input type="text" name="location" class="form-control border-0" 
                                       placeholder="Location..." value="{{ request('location') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-white btn-lg w-100 fw-semibold">
                                <i class="fas fa-search me-2"></i>Search Jobs
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 text-center">
                <div class="hero-stats">
                    <div class="stat-item">
                        <h3 class="text-white fw-bold">{{ number_format($totalJobs ?? 0) }}</h3>
                        <p class="text-white-75 mb-0">Active Jobs</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <!-- Advanced Filters Sidebar -->
        <div class="col-lg-3">
            <div class="filters-sidebar sticky-top" style="top: 100px;">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-gradient-primary text-white">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-filter me-2"></i>Filter Jobs
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('jobs.index') }}" method="GET" id="filterForm">
                            <!-- Work Type Filter -->
                            <div class="filter-section mb-4">
                                <h6 class="fw-semibold mb-3">Work Type</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="employment_type[]" value="remote"
                                           {{ in_array('remote', request('employment_type', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        <i class="fas fa-wifi me-1"></i>Remote Work
                                    </label>
                                </div>
                            </div>

                            <!-- Experience Level -->
                            <div class="filter-section mb-4">
                                <h6 class="fw-semibold mb-3">Experience Level</h6>
                                <select name="experience_level" class="form-select">
                                    <option value="">Any Level</option>
                                    <option value="entry" {{ request('experience_level') == 'entry' ? 'selected' : '' }}>Entry Level</option>
                                    <option value="mid" {{ request('experience_level') == 'mid' ? 'selected' : '' }}>Mid Level</option>
                                    <option value="senior" {{ request('experience_level') == 'senior' ? 'selected' : '' }}>Senior Level</option>
                                    <option value="executive" {{ request('experience_level') == 'executive' ? 'selected' : '' }}>Executive</option>
                                </select>
                            </div>

                            <!-- Salary Range -->
                            <div class="filter-section mb-4">
                                <h6 class="fw-semibold mb-3">Salary Range</h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" name="salary_min" class="form-control" 
                                               placeholder="Min" value="{{ request('salary_min') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="salary_max" class="form-control" 
                                               placeholder="Max" value="{{ request('salary_max') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-search me-2"></i>Apply Filters
                            </button>
                            <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-times me-2"></i>Clear All
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Jobs List -->
        <div class="col-lg-9">
            <!-- Results Header -->
            <div class="results-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Available Opportunities</h2>
                    <p class="text-muted mb-0">Showing {{ $jobs->firstItem() ?? 0 }}-{{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} jobs</p>
                </div>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto;" onchange="updateSort(this)">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="salary_high" {{ request('sort') == 'salary_high' ? 'selected' : '' }}>Salary: High to Low</option>
                        <option value="salary_low" {{ request('sort') == 'salary_low' ? 'selected' : '' }}>Salary: Low to High</option>
                        <option value="company" {{ request('sort') == 'company' ? 'selected' : '' }}>Company A-Z</option>
                    </select>
                </div>
            </div>
            
            @if($jobs->count() > 0)
                <div class="jobs-grid">
                    @foreach($jobs as $job)
                        <div class="job-card card border-0 shadow-sm mb-4 hover-lift">
                            <div class="card-body p-4">
                                <div class="row align-items-start">
                                    <!-- Company Logo -->
                                    <div class="col-auto">
                                        <div class="company-logo-wrapper">
                                            @if($job->company->logo)
                                                <img src="{{ asset($job->company->logo) }}" alt="{{ $job->company->company_name }}" class="company-logo">
                                            @else
                                                <div class="company-logo bg-gradient-primary d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-building text-white"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Job Details -->
                                    <div class="col">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h5 class="job-title mb-1">
                                                    <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none text-dark fw-semibold">
                                                        {{ $job->title }}
                                                        @if($job->is_urgent)
                                                            <span class="badge bg-danger ms-2">Urgent</span>
                                                        @endif
                                                    </a>
                                                </h5>
                                                <div class="company-info d-flex align-items-center text-muted mb-2">
                                                    <span class="fw-medium">{{ $job->company->company_name }}</span>
                                                    @if($job->company->verification_status == 'verified')
                                                        <i class="fas fa-check-circle text-success ms-1" title="Verified Company"></i>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($job->salary_min || $job->salary_max)
                                                <div class="salary-info text-end">
                                                    <div class="salary-range fw-bold text-success">
                                                        @if($job->salary_min && $job->salary_max)
                                                            ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                                                        @elseif($job->salary_min)
                                                            From ${{ number_format($job->salary_min) }}
                                                        @else
                                                            Up to ${{ number_format($job->salary_max) }}
                                                        @endif
                                                    </div>
                                                    <small class="text-muted">{{ ucfirst($job->salary_type ?? 'yearly') }}</small>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Job Description -->
                                        <p class="job-description text-muted mb-3">{{ Str::limit($job->description, 150) }}</p>
                                        
                                        <!-- Job Tags -->
                                        <div class="job-tags mb-3">
                                            @if($job->location)
                                                <span class="job-tag">
                                                    <i class="fas fa-map-marker-alt"></i> {{ $job->location }}
                                                </span>
                                            @endif
                                            @if($job->jobType)
                                                <span class="job-tag">
                                                    <i class="fas fa-briefcase"></i> {{ $job->jobType->name }}
                                                </span>
                                            @endif
                                            @if($job->is_remote)
                                                <span class="job-tag remote">
                                                    <i class="fas fa-wifi"></i> Remote
                                                </span>
                                            @endif
                                            @if($job->experience_min || $job->experience_max)
                                                <span class="job-tag">
                                                    <i class="fas fa-star"></i> 
                                                    @if($job->experience_min && $job->experience_max)
                                                        {{ $job->experience_min }}-{{ $job->experience_max }} years
                                                    @elseif($job->experience_min)
                                                        {{ $job->experience_min }}+ years
                                                    @else
                                                        Up to {{ $job->experience_max }} years
                                                    @endif
                                                </span>
                                            @endif
                                            @if($job->visibility == 'featured')
                                                <span class="job-tag featured">
                                                    <i class="fas fa-star"></i> Featured
                                                </span>
                                            @endif
                                            @if($job->visibility == 'highlighted')
                                                <span class="job-tag highlighted">
                                                    <i class="fas fa-bolt"></i> Highlighted
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Job Actions -->
                                        <div class="job-actions d-flex justify-content-between align-items-center">
                                            <div class="job-meta">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt me-1"></i>Posted {{ $job->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            <div class="action-buttons d-flex gap-2">
                                                @auth
                                                    @if(auth()->user()->role == 'candidate')
                                                        <button type="button" class="btn btn-outline-primary btn-sm bookmark-btn" data-job-id="{{ $job->id }}">
                                                            <i class="fas fa-bookmark"></i>
                                                        </button>
                                                    @endif
                                                @endauth
                                                <a href="{{ route('jobs.show', $job) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-arrow-right me-1"></i>View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    <div class="pagination-wrapper">
                        {{ $jobs->withQueryString()->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4>No jobs found</h4>
                    <p class="text-muted">Try adjusting your search criteria or check back later for new opportunities.</p>
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary">Browse All Jobs</a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    @php
        $primaryColor = \App\Models\WebsiteSetting::getValue('primary_color', '#667eea');
        $secondaryColor = \App\Models\WebsiteSetting::getValue('secondary_color', '#764ba2');
        $theme = \App\Models\WebsiteSetting::getValue('theme', 'light');
    @endphp
    
    :root {
        --primary-color: {{ $primaryColor }};
        --secondary-color: {{ $secondaryColor }};
        --gradient: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);
        --gradient-light: linear-gradient(135deg, {{ $primaryColor }}15 0%, {{ $secondaryColor }}15 100%);
    }
    
    body {
        @if($theme === 'dark')
        background-color: #1a1a1a;
        color: #ffffff;
        @else
        background-color: #f8f9fa;
        @endif
    }
    
    .hero-section {
        background: var(--gradient);
        position: relative;
        overflow: hidden;
        min-height: 65vh;
        display: flex;
        align-items: center;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M40 40c0-11.046-8.954-20-20-20s-20 8.954-20 20 8.954 20 20 20 20-8.954 20-20zm20 0c0-11.046-8.954-20-20-20s-20 8.954-20 20 8.954 20 20 20 20-8.954 20-20z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        animation: float 20s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }
    
    .text-white-75 {
        color: rgba(255, 255, 255, 0.75);
    }
    
    .btn-white {
        background: white;
        color: var(--primary-color);
        border: none;
        font-weight: 600;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        border-radius: 50px;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        position: relative;
        overflow: hidden;
    }
    
    .btn-white::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.5s;
    }
    
    .btn-white:hover::before {
        left: 100%;
    }
    
    .btn-white:hover {
        background: #f8f9fa;
        color: var(--primary-color);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.2);
    }
    
    .search-form .input-group {
        border-radius: 50px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0,0,0,0.15);
        backdrop-filter: blur(10px);
    }
    
    .search-form .input-group-text {
        border: none;
        padding: 1rem 1.5rem;
    }
    
    .search-form .form-control {
        border: none;
        padding: 1rem 1.5rem;
        font-size: 1.1rem;
    }
    
    .search-form .form-control:focus {
        box-shadow: none;
    }
    
    .bg-gradient-primary {
        background: var(--gradient) !important;
    }
    
    @if($theme === 'dark')
    .card {
        background-color: #2d3748;
        border: 1px solid #4a5568;
        color: #ffffff;
    }
    
    .card-header {
        background-color: #4a5568 !important;
        border-bottom: 1px solid #718096;
        color: #ffffff;
    }
    
    .form-control, .form-select {
        background-color: #4a5568;
        border: 1px solid #718096;
        color: #ffffff;
    }
    
    .form-control:focus, .form-select:focus {
        background-color: #4a5568;
        border-color: var(--primary-color);
        color: #ffffff;
        box-shadow: 0 0 0 0.2rem {{ $primaryColor }}25;
    }
    
    .text-muted {
        color: #a0aec0 !important;
    }
    
    .text-dark {
        color: #ffffff !important;
    }
    
    .job-card {
        background-color: #2d3748;
        border: 1px solid #4a5568;
    }
    
    .job-card:hover {
        background-color: #4a5568;
        border-color: var(--primary-color);
    }
    
    .job-tag {
        background: #4a5568;
        color: #e2e8f0;
    }
    
    .job-tag.remote {
        background: #065f46;
        color: #6ee7b7;
    }
    
    .job-tag.featured {
        background: #7c2d12;
        color: #fed7aa;
    }
    
    .job-tag.highlighted {
        background: #7c2d12;
        color: #fbbf24;
    }
    
    .filters-sidebar .card {
        background-color: #2d3748;
        border: 1px solid #4a5568;
    }
    
    .admin-header {
        background-color: #2d3748 !important;
        border-bottom: 1px solid #4a5568;
    }
    
    .results-header h2 {
        color: #ffffff;
    }
    @endif
    
    .job-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        position: relative;
        overflow: hidden;
    }
    
    .job-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .job-card:hover {
        transform: translateY(-8px);
        @if($theme === 'dark')
        box-shadow: 0 20px 40px rgba(0,0,0,0.3) !important;
        @else
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
        @endif
    }
    
    .job-card:hover::before {
        opacity: 1;
    }
    
    .company-logo {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    
    .company-logo-wrapper {
        position: relative;
    }
    
    .company-logo-wrapper .company-logo {
        border: 3px solid {{ $theme === 'dark' ? '#4a5568' : '#f8f9fa' }};
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .job-card:hover .company-logo {
        transform: scale(1.05);
        border-color: var(--primary-color);
    }
    
    .job-title a {
        transition: all 0.3s ease;
        position: relative;
    }
    
    .job-title a:hover {
        color: var(--primary-color) !important;
    }
    
    .job-title a::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -2px;
        left: 0;
        background: var(--gradient);
        transition: width 0.3s ease;
    }
    
    .job-title a:hover::after {
        width: 100%;
    }
    
    .job-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        @if($theme === 'dark')
        background: #4a5568;
        color: #e2e8f0;
        @else
        background: #f8f9fa;
        color: #6c757d;
        @endif
        padding: 6px 14px;
        border-radius: 25px;
        font-size: 0.875rem;
        font-weight: 500;
        margin-right: 8px;
        margin-bottom: 8px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    
    .job-tag:hover {
        transform: translateY(-1px);
        border-color: var(--primary-color);
    }
    
    .job-tag.remote {
        @if($theme === 'dark')
        background: #065f46;
        color: #6ee7b7;
        @else
        background: #e6fffa;
        color: #047481;
        @endif
    }
    
    .job-tag.featured {
        @if($theme === 'dark')
        background: #7c2d12;
        color: #fed7aa;
        @else
        background: #fef3c7;
        color: #d97706;
        @endif
    }
    
    .job-tag.highlighted {
        @if($theme === 'dark')
        background: #7c2d12;
        color: #fbbf24;
        @else
        background: #fef3c7;
        color: #d97706;
        @endif
    }
    
    .filter-section {
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 1rem;
    }
    
    .filter-section:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .filters-sidebar .card {
        border-radius: 20px;
        border: none;
        @if($theme === 'light')
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        @endif
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .filters-sidebar .card-header {
        border-radius: 20px 20px 0 0;
        border: none;
        background: var(--gradient) !important;
    }
    
    .filter-section {
        border-bottom: 1px solid {{ $theme === 'dark' ? '#4a5568' : '#e9ecef' }};
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
    }
    
    .results-header h2 {
        @if($theme === 'dark')
        color: #ffffff;
        @else
        color: #2d3748;
        @endif
        position: relative;
    }
    
    .results-header h2::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 50px;
        height: 3px;
        background: var(--gradient);
        border-radius: 2px;
    }
    
    .btn-primary {
        background: var(--gradient);
        border: none;
        border-radius: 10px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-primary:hover::before {
        left: 100%;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .hero-stats {
        background: rgba(255,255,255,0.1);
        border-radius: 20px;
        padding: 2rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
    }
    
    .stat-item h3 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .hero-section {
            padding: 3rem 0 !important;
            min-height: 50vh;
        }
        
        .search-form .row > div {
            margin-bottom: 1rem;
        }
        
        .search-form .form-control,
        .search-form .btn {
            font-size: 1rem;
            padding: 0.875rem 1.25rem;
        }
        
        .filters-sidebar {
            margin-bottom: 2rem;
        }
        
        .job-card .row {
            text-align: center;
        }
        
        .job-card .col-auto {
            margin-bottom: 1rem;
        }
        
        .company-logo {
            width: 60px;
            height: 60px;
        }
        
        .hero-stats {
            margin-top: 2rem;
            padding: 1.5rem;
        }
        
        .stat-item h3 {
            font-size: 2.5rem;
        }
    }
    
    /* Pagination Styles */
    .pagination-wrapper {
        background: {{ $theme === 'dark' ? '#2d3748' : 'rgba(255,255,255,0.95)' }};
        border-radius: 15px;
        padding: 1rem;
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: {{ $theme === 'dark' ? '1px solid #4a5568' : '1px solid rgba(255,255,255,0.2)' }};
    }
    
    .pagination .page-link {
        @if($theme === 'dark')
        background-color: #4a5568;
        border: 1px solid #718096;
        color: #e2e8f0;
        @else
        background-color: #ffffff;
        border: 1px solid #e9ecef;
        color: #6c757d;
        @endif
        padding: 0.75rem 1rem;
        margin: 0 2px;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .pagination .page-link:hover {
        @if($theme === 'dark')
        background-color: #718096;
        border-color: var(--primary-color);
        color: #ffffff;
        @else
        background-color: #f8f9fa;
        border-color: var(--primary-color);
        color: var(--primary-color);
        @endif
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .pagination .page-item.active .page-link {
        background: var(--gradient);
        border-color: transparent;
        color: #ffffff;
        font-weight: 600;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .pagination .page-item.disabled .page-link {
        @if($theme === 'dark')
        background-color: #2d3748;
        border-color: #4a5568;
        color: #718096;
        @else
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #adb5bd;
        @endif
        opacity: 0.6;
    }
    
    .pagination .page-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .pagination .page-link:hover::before {
        left: 100%;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bookmark functionality
    document.querySelectorAll('.bookmark-btn').forEach(button => {
        button.addEventListener('click', function() {
            const jobId = this.dataset.jobId;
            
            fetch('/candidate/bookmarks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    bookmarkable_type: 'App\\Models\\Job',
                    bookmarkable_id: jobId 
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.innerHTML = '<i class="fas fa-bookmark"></i>';
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-success');
                    this.disabled = true;
                    this.title = 'Bookmarked';
                } else {
                    alert(data.error || 'Failed to bookmark job');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Please login to bookmark jobs');
            });
        });
    });
    
    // Auto-submit filters on change
    document.querySelectorAll('#filterForm input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // Add a small delay to allow multiple selections
            setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 300);
        });
    });
});

// Sort functionality
function updateSort(select) {
    const url = new URL(window.location);
    url.searchParams.set('sort', select.value);
    window.location = url;
}

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>
@endpush
@endsection