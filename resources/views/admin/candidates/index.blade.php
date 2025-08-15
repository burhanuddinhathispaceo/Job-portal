@extends('admin.layouts.app')

@section('title', 'Candidates Management')

@section('content')
<div class="container-fluid py-4">
    <!-- Gradient Header -->
    <div class="card bg-gradient-primary text-white shadow-lg border-0 mb-4">
        <div class="card-body py-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 mb-2 font-weight-bold">
                        <i class="fas fa-user-tie mr-2"></i>Candidates Management
                    </h1>
                    <p class="mb-0 opacity-90">Manage job seekers, freelancers, and their profiles</p>
                </div>
                <div class="col-md-4 text-md-right">
                    <a href="{{ route('admin.candidates.create') }}" class="btn btn-light btn-lg shadow-sm">
                        <i class="fas fa-plus-circle mr-2"></i>Add New Candidate
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Candidates
                            </div>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['total_candidates'] ?? 0 }}</div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-users mr-1"></i>All registered candidates
                                </small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="bg-primary bg-gradient rounded-circle p-3 text-white">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Candidates
                            </div>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['active_candidates'] ?? 0 }}</div>
                            <div class="mt-2">
                                <small class="text-success">
                                    <i class="fas fa-user-check mr-1"></i>Currently job seeking
                                </small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="bg-success bg-gradient rounded-circle p-3 text-white">
                                <i class="fas fa-user-check fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Verified Profiles
                            </div>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['verified_candidates'] ?? 0 }}</div>
                            <div class="mt-2">
                                <small class="text-info">
                                    <i class="fas fa-badge-check mr-1"></i>Verified identities
                                </small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="bg-info bg-gradient rounded-circle p-3 text-white">
                                <i class="fas fa-badge-check fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Recent Applications
                            </div>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['recent_applications'] ?? 0 }}</div>
                            <div class="mt-2">
                                <small class="text-warning">
                                    <i class="fas fa-paper-plane mr-1"></i>Last 7 days
                                </small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="bg-warning bg-gradient rounded-circle p-3 text-white">
                                <i class="fas fa-paper-plane fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.candidates.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small text-muted">Search Candidate</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" 
                               placeholder="Name, email, skills..." value="{{ request('search') }}">
                    </div>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label small text-muted">Experience Level</label>
                    <select name="experience" class="form-select">
                        <option value="">All Levels</option>
                        <option value="0-2" {{ request('experience') == '0-2' ? 'selected' : '' }}>0-2 Years</option>
                        <option value="3-5" {{ request('experience') == '3-5' ? 'selected' : '' }}>3-5 Years</option>
                        <option value="6-10" {{ request('experience') == '6-10' ? 'selected' : '' }}>6-10 Years</option>
                        <option value="10+" {{ request('experience') == '10+' ? 'selected' : '' }}>10+ Years</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small text-muted">Profile Completion</label>
                    <select name="profile" class="form-select">
                        <option value="">All Profiles</option>
                        <option value="complete" {{ request('profile') == 'complete' ? 'selected' : '' }}>Complete (100%)</option>
                        <option value="partial" {{ request('profile') == 'partial' ? 'selected' : '' }}>Partial (50-99%)</option>
                        <option value="incomplete" {{ request('profile') == 'incomplete' ? 'selected' : '' }}>Incomplete (<50%)</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small text-muted">Account Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small text-muted">Sort By</label>
                    <select name="sort" class="form-select">
                        <option value="newest">Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="applications" {{ request('sort') == 'applications' ? 'selected' : '' }}>Most Applications</option>
                        <option value="experience" {{ request('sort') == 'experience' ? 'selected' : '' }}>Most Experience</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <label class="form-label small text-muted">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i>
                        </button>
                        <a href="{{ route('admin.candidates.index') }}" class="btn btn-light">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Candidates Table -->
    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-2"></i>Candidates List
                    </h5>
                </div>
                <div class="col text-right">
                    <span class="badge bg-light text-dark px-3 py-2">
                        Showing {{ $candidates->firstItem() ?? 0 }}-{{ $candidates->lastItem() ?? 0 }} 
                        of {{ $candidates->total() ?? 0 }} candidates
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
                            <th class="border-0">Candidate</th>
                            <th class="border-0">Contact</th>
                            <th class="border-0">Experience</th>
                            <th class="border-0">Skills</th>
                            <th class="border-0">Salary Expectation</th>
                            <th class="border-0">Applications</th>
                            <th class="border-0">Profile</th>
                            <th class="border-0">Status</th>
                            <th class="border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidates as $candidate)
                        <tr>
                            <td class="px-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $candidate->id }}">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($candidate->profile_photo)
                                        <img src="{{ asset($candidate->profile_photo) }}" class="rounded-circle mr-3" 
                                             style="width: 45px; height: 45px; object-fit: cover;">
                                    @else
                                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center mr-3" 
                                             style="width: 45px; height: 45px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0 font-weight-bold">
                                            {{ $candidate->first_name }} {{ $candidate->last_name }}
                                        </h6>
                                        <small class="text-muted">
                                            {{ $candidate->professional_title ?? 'No title specified' }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="mb-1">
                                        <i class="fas fa-envelope text-muted mr-1"></i>
                                        {{ $candidate->user->email }}
                                    </div>
                                    @if($candidate->phone)
                                        <div>
                                            <i class="fas fa-phone text-muted mr-1"></i>
                                            {{ $candidate->phone }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span class="badge bg-info-soft text-info px-3 py-2">
                                        {{ $candidate->experience_years }} Years
                                    </span>
                                    @if($candidate->current_position)
                                        <div class="small text-muted mt-1">
                                            {{ $candidate->current_position }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($candidate->skills && $candidate->skills->count() > 0)
                                    <div>
                                        @foreach($candidate->skills->take(3) as $skill)
                                            <span class="badge bg-secondary-soft text-secondary me-1 mb-1">
                                                {{ $skill->name }}
                                            </span>
                                        @endforeach
                                        @if($candidate->skills->count() > 3)
                                            <span class="badge bg-light text-dark">
                                                +{{ $candidate->skills->count() - 3 }} more
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">No skills listed</span>
                                @endif
                            </td>
                            <td>
                                @if($candidate->expected_salary)
                                    <div>
                                        <strong>${{ number_format($candidate->expected_salary) }}</strong>
                                        <div class="small text-muted">
                                            Current: ${{ number_format($candidate->current_salary ?? 0) }}
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="mb-1">
                                        <span class="badge bg-purple-soft text-purple">
                                            {{ $candidate->applications_count ?? 0 }} Jobs
                                        </span>
                                    </div>
                                    <div>
                                        <span class="badge bg-warning-soft text-warning">
                                            {{ $candidate->proposals_count ?? 0 }} Projects
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $completion = $candidate->profile_completion ?? 0;
                                    $completionClass = $completion >= 80 ? 'success' : ($completion >= 50 ? 'warning' : 'danger');
                                @endphp
                                <div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-{{ $completionClass }}" 
                                             role="progressbar" 
                                             style="width: {{ $completion }}%"
                                             aria-valuenow="{{ $completion }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $completion }}% Complete</small>
                                </div>
                            </td>
                            <td>
                                @if($candidate->user->status == 'active')
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" type="checkbox" 
                                               data-id="{{ $candidate->id }}" checked>
                                        <label class="form-check-label text-success small">Active</label>
                                    </div>
                                @else
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" type="checkbox" 
                                               data-id="{{ $candidate->id }}">
                                        <label class="form-check-label text-danger small">Inactive</label>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.candidates.show', $candidate) }}" 
                                       class="btn btn-sm btn-light rounded-circle" 
                                       data-bs-toggle="tooltip" title="View Profile">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.candidates.edit', $candidate) }}" 
                                       class="btn btn-sm btn-primary rounded-circle" 
                                       data-bs-toggle="tooltip" title="Edit Candidate">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-info rounded-circle" 
                                            data-bs-toggle="tooltip" title="View Resume"
                                            onclick="viewResume({{ $candidate->id }})">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                    <form action="{{ route('admin.candidates.destroy', $candidate) }}" 
                                          method="POST" class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this candidate?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-circle"
                                                data-bs-toggle="tooltip" title="Delete Candidate">
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
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <p>No candidates found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($candidates->hasPages())
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
                        {{ $candidates->withQueryString()->links() }}
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
    
    .progress {
        background-color: #e9ecef;
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
    
    // Status toggle
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const candidateId = this.dataset.id;
            const status = this.checked ? 'active' : 'inactive';
            // Make AJAX call to update status
        });
    });
    
    // View resume function
    function viewResume(candidateId) {
        // Open resume in new window or modal
        window.open('/admin/candidates/' + candidateId + '/resume', '_blank');
    }
</script>
@endpush
@endsection