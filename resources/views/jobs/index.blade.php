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
                            <!-- Job Type Filter -->
                            <div class="filter-section mb-4">
                                <h6 class="fw-semibold mb-3">Job Type</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="employment_type[]" value="full_time" 
                                           {{ in_array('full_time', request('employment_type', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label">Full Time</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="employment_type[]" value="part_time"
                                           {{ in_array('part_time', request('employment_type', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label">Part Time</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="employment_type[]" value="contract"
                                           {{ in_array('contract', request('employment_type', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label">Contract</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="employment_type[]" value="remote"
                                           {{ in_array('remote', request('employment_type', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label">Remote</label>
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
                                            @if($job->employment_type)
                                                <span class="job-tag">
                                                    <i class="fas fa-clock"></i> {{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}
                                                </span>
                                            @endif
                                            @if($job->is_remote)
                                                <span class="job-tag remote">
                                                    <i class="fas fa-wifi"></i> Remote
                                                </span>
                                            @endif
                                            @if($job->experience_level)
                                                <span class="job-tag">
                                                    <i class="fas fa-star"></i> {{ ucfirst($job->experience_level) }} Level
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
                <div class="d-flex justify-content-center">
                    {{ $jobs->withQueryString()->links() }}
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
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .text-white-75 {
        color: rgba(255, 255, 255, 0.75);
    }
    
    .btn-white {
        background: white;
        color: #667eea;
        border: none;
        font-weight: 600;
    }
    
    .btn-white:hover {
        background: #f8f9fa;
        color: #667eea;
        transform: translateY(-2px);
    }
    
    .search-form .input-group {
        border-radius: 50px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .job-card {
        transition: all 0.3s ease;
        border-radius: 15px;
    }
    
    .job-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }
    
    .company-logo {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 12px;
    }
    
    .company-logo-wrapper .company-logo {
        border: 2px solid #f8f9fa;
    }
    
    .job-title a:hover {
        color: #667eea !important;
    }
    
    .job-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f8f9fa;
        color: #6c757d;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.875rem;
        margin-right: 8px;
        margin-bottom: 6px;
    }
    
    .job-tag.remote {
        background: #e6fffa;
        color: #047481;
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
        border-radius: 15px;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
    }
    
    .results-header h2 {
        color: #2d3748;
    }
    
    @media (max-width: 768px) {
        .hero-section {
            padding: 3rem 0 !important;
        }
        
        .search-form .row > div {
            margin-bottom: 1rem;
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