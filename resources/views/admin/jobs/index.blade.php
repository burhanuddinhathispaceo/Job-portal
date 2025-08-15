@extends('admin.layouts.app')

@section('title', 'Jobs Management')

@section('content')
<div class="container-fluid py-4">
    <!-- Gradient Header -->
    <div class="card bg-gradient-primary text-white shadow-lg border-0 mb-4">
        <div class="card-body py-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 mb-2 font-weight-bold">
                        <i class="fas fa-briefcase mr-2"></i>Jobs Management
                    </h1>
                    <p class="mb-0 opacity-90">Manage job postings, applications, and visibility settings</p>
                </div>
                <div class="col-md-4 text-md-right">
                    <a href="{{ route('admin.jobs.create') }}" class="btn btn-light btn-lg shadow-sm">
                        <i class="fas fa-plus-circle mr-2"></i>Post New Job
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="bg-primary bg-gradient rounded-circle p-3 text-white mb-3 mx-auto" style="width: 60px; height: 60px;">
                        <i class="fas fa-briefcase fa-lg"></i>
                    </div>
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Jobs</div>
                    <div class="h3 mb-0 font-weight-bold">{{ $stats['total_jobs'] ?? 0 }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="bg-success bg-gradient rounded-circle p-3 text-white mb-3 mx-auto" style="width: 60px; height: 60px;">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Jobs</div>
                    <div class="h3 mb-0 font-weight-bold">{{ $stats['active_jobs'] ?? 0 }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="bg-warning bg-gradient rounded-circle p-3 text-white mb-3 mx-auto" style="width: 60px; height: 60px;">
                        <i class="fas fa-star fa-lg"></i>
                    </div>
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Featured</div>
                    <div class="h3 mb-0 font-weight-bold">{{ $stats['featured_jobs'] ?? 0 }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="bg-info bg-gradient rounded-circle p-3 text-white mb-3 mx-auto" style="width: 60px; height: 60px;">
                        <i class="fas fa-home fa-lg"></i>
                    </div>
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Remote Jobs</div>
                    <div class="h3 mb-0 font-weight-bold">{{ $stats['remote_jobs'] ?? 0 }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="bg-danger bg-gradient rounded-circle p-3 text-white mb-3 mx-auto" style="width: 60px; height: 60px;">
                        <i class="fas fa-clock fa-lg"></i>
                    </div>
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Expiring Soon</div>
                    <div class="h3 mb-0 font-weight-bold">{{ $stats['expiring_soon'] ?? 0 }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="bg-purple bg-gradient rounded-circle p-3 text-white mb-3 mx-auto" style="width: 60px; height: 60px;">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                    <div class="text-xs font-weight-bold text-purple text-uppercase mb-1">Applications</div>
                    <div class="h3 mb-0 font-weight-bold">{{ $stats['total_applications'] ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.jobs.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small text-muted">Search Jobs</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" 
                               placeholder="Title, company, location..." value="{{ request('search') }}">
                    </div>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label small text-muted">Company</label>
                    <select name="company" class="form-select">
                        <option value="">All Companies</option>
                        @foreach($companies ?? [] as $company)
                            <option value="{{ $company->id }}" {{ request('company') == $company->id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small text-muted">Job Type</label>
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="full-time" {{ request('type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part-time" {{ request('type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                        <option value="contract" {{ request('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="freelance" {{ request('type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                        <option value="internship" {{ request('type') == 'internship' ? 'selected' : '' }}>Internship</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <label class="form-label small text-muted">Remote</label>
                    <select name="remote" class="form-select">
                        <option value="">All</option>
                        <option value="1" {{ request('remote') == '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ request('remote') == '0' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small text-muted">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="filled" {{ request('status') == 'filled' ? 'selected' : '' }}>Filled</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <label class="form-label small text-muted">Visibility</label>
                    <select name="visibility" class="form-select">
                        <option value="">All</option>
                        <option value="featured" {{ request('visibility') == 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="highlighted" {{ request('visibility') == 'highlighted' ? 'selected' : '' }}>Highlighted</option>
                        <option value="normal" {{ request('visibility') == 'normal' ? 'selected' : '' }}>Normal</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <label class="form-label small text-muted">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i>
                        </button>
                        <a href="{{ route('admin.jobs.index') }}" class="btn btn-light">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Jobs Table -->
    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-2"></i>Jobs List
                    </h5>
                </div>
                <div class="col text-right">
                    <span class="badge bg-light text-dark px-3 py-2">
                        Showing {{ $jobs->firstItem() ?? 0 }}-{{ $jobs->lastItem() ?? 0 }} 
                        of {{ $jobs->total() ?? 0 }} jobs
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th class="border-0">Job Title</th>
                            <th class="border-0">Company</th>
                            <th class="border-0">Location</th>
                            <th class="border-0">Salary Range</th>
                            <th class="border-0">Type</th>
                            <th class="border-0">Applications</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Visibility</th>
                            <th class="border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobs as $job)
                        <tr>
                            <td class="px-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $job->id }}">
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h6 class="mb-0 font-weight-bold">{{ $job->title }}</h6>
                                    <div class="small text-muted">
                                        @if($job->is_remote)
                                            <span class="badge bg-info-soft text-info me-1">
                                                <i class="fas fa-home mr-1"></i>Remote
                                            </span>
                                        @endif
                                        @if($job->application_deadline)
                                            <span class="text-muted">
                                                <i class="fas fa-calendar mr-1"></i>
                                                Deadline: {{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($job->company->logo)
                                        <img src="{{ asset($job->company->logo) }}" class="rounded-circle mr-2" 
                                             style="width: 35px; height: 35px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mr-2" 
                                             style="width: 35px; height: 35px;">
                                            <i class="fas fa-building" style="font-size: 12px;"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-weight-bold">{{ $job->company->company_name }}</div>
                                        @if($job->company->verification_status == 'verified')
                                            <span class="badge bg-success-soft text-success">
                                                <i class="fas fa-check-circle"></i> Verified
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <i class="fas fa-map-marker-alt text-muted mr-1"></i>
                                    {{ $job->location ?? 'Not specified' }}
                                </div>
                            </td>
                            <td>
                                @if($job->salary_min || $job->salary_max)
                                    <div>
                                        <strong>
                                            ${{ number_format($job->salary_min ?? 0) }} - 
                                            ${{ number_format($job->salary_max ?? 0) }}
                                        </strong>
                                        <div class="small text-muted">{{ $job->salary_currency ?? 'USD' }}/year</div>
                                    </div>
                                @else
                                    <span class="text-muted">Not disclosed</span>
                                @endif
                            </td>
                            <td>
                                @if($job->jobType)
                                    <span class="badge bg-secondary-soft text-secondary px-3 py-2">
                                        {{ $job->jobType->name }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-center">
                                    <span class="badge bg-purple-soft text-purple px-3 py-2">
                                        <i class="fas fa-users mr-1"></i>{{ $job->applications_count ?? 0 }}
                                    </span>
                                    @if($job->views_count > 0)
                                        <div class="small text-muted mt-1">
                                            <i class="fas fa-eye mr-1"></i>{{ $job->views_count }} views
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'active' => 'success',
                                        'draft' => 'secondary',
                                        'inactive' => 'warning',
                                        'expired' => 'danger',
                                        'filled' => 'info'
                                    ];
                                    $statusColor = $statusColors[$job->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusColor }}-soft text-{{ $statusColor }} px-3 py-2">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $visibilityIcons = [
                                        'featured' => 'star',
                                        'highlighted' => 'lightbulb',
                                        'normal' => 'circle'
                                    ];
                                    $visibilityColors = [
                                        'featured' => 'warning',
                                        'highlighted' => 'info',
                                        'normal' => 'secondary'
                                    ];
                                    $icon = $visibilityIcons[$job->visibility] ?? 'circle';
                                    $color = $visibilityColors[$job->visibility] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}-soft text-{{ $color }} px-3 py-2">
                                    <i class="fas fa-{{ $icon }} mr-1"></i>{{ ucfirst($job->visibility) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.jobs.show', $job) }}" 
                                       class="btn btn-sm btn-light rounded-circle" 
                                       data-bs-toggle="tooltip" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.jobs.edit', $job) }}" 
                                       class="btn btn-sm btn-primary rounded-circle" 
                                       data-bs-toggle="tooltip" title="Edit Job">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-info rounded-circle" 
                                            data-bs-toggle="tooltip" title="View Applications"
                                            onclick="viewApplications({{ $job->id }})">
                                        <i class="fas fa-users"></i>
                                    </button>
                                    @if($job->status == 'draft')
                                        <button class="btn btn-sm btn-success rounded-circle" 
                                                data-bs-toggle="tooltip" title="Publish Job"
                                                onclick="publishJob({{ $job->id }})">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    @endif
                                    <form action="{{ route('admin.jobs.destroy', $job) }}" 
                                          method="POST" class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this job?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-circle"
                                                data-bs-toggle="tooltip" title="Delete Job">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-briefcase fa-3x mb-3"></i>
                                    <p>No jobs found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($jobs->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <label class="me-2">Show</label>
                            <select class="form-select form-select-sm d-inline-block w-auto" onchange="window.location.href='?per_page='+this.value">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page', 50) == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <label class="ms-2">entries</label>
                        </div>
                        {{ $jobs->withQueryString()->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .bg-purple {
        background-color: #764ba2;
    }
    
    .bg-primary-soft {
        background-color: rgba(102, 126, 234, 0.1);
    }
    
    .bg-success-soft {
        background-color: rgba(40, 199, 111, 0.1);
    }
    
    .bg-warning-soft {
        background-color: rgba(255, 193, 7, 0.1);
    }
    
    .bg-danger-soft {
        background-color: rgba(234, 84, 85, 0.1);
    }
    
    .bg-info-soft {
        background-color: rgba(23, 162, 184, 0.1);
    }
    
    .bg-secondary-soft {
        background-color: rgba(108, 117, 125, 0.1);
    }
    
    .bg-purple-soft {
        background-color: rgba(118, 75, 162, 0.1);
    }
    
    .text-purple {
        color: #764ba2;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.03);
    }
    
    .btn-light {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
    }
    
    .rounded-circle {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
    
    .opacity-90 {
        opacity: 0.9;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Select all checkbox
    document.getElementById('selectAll')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
    
    // View applications
    function viewApplications(jobId) {
        window.location.href = '/admin/jobs/' + jobId + '/applications';
    }
    
    // Publish job
    function publishJob(jobId) {
        if (confirm('Are you sure you want to publish this job?')) {
            // Make AJAX call to publish job
            fetch('/admin/jobs/' + jobId + '/publish', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
        }
    }
</script>
@endpush
@endsection