@extends('admin.layouts.app')

@section('title', 'Companies Management')

@section('content')
<div class="container-fluid py-4">
    <!-- Gradient Header -->
    <div class="card bg-gradient-primary text-white shadow-lg border-0 mb-4">
        <div class="card-body py-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 mb-2 font-weight-bold">
                        <i class="fas fa-building mr-2"></i>Companies Management
                    </h1>
                    <p class="mb-0 opacity-90">Manage company accounts, verifications, and subscriptions</p>
                </div>
                <div class="col-md-4 text-md-right">
                    <a href="{{ route('admin.companies.create') }}" class="btn btn-light btn-lg shadow-sm">
                        <i class="fas fa-plus-circle mr-2"></i>Add New Company
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
                                Total Companies
                            </div>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['total_companies'] ?? 0 }}</div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-chart-line mr-1"></i>All registered companies
                                </small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="bg-primary bg-gradient rounded-circle p-3 text-white">
                                <i class="fas fa-building fa-2x"></i>
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
                                Verified Companies
                            </div>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['verified_companies'] ?? 0 }}</div>
                            <div class="mt-2">
                                <small class="text-success">
                                    <i class="fas fa-check-circle mr-1"></i>Verified & trusted
                                </small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="bg-success bg-gradient rounded-circle p-3 text-white">
                                <i class="fas fa-certificate fa-2x"></i>
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
                                Premium Subscribers
                            </div>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['premium_companies'] ?? 0 }}</div>
                            <div class="mt-2">
                                <small class="text-warning">
                                    <i class="fas fa-crown mr-1"></i>Paid subscriptions
                                </small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="bg-warning bg-gradient rounded-circle p-3 text-white">
                                <i class="fas fa-crown fa-2x"></i>
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
                                Active Companies
                            </div>
                            <div class="h3 mb-0 font-weight-bold">{{ $stats['active_companies'] ?? 0 }}</div>
                            <div class="mt-2">
                                <small class="text-info">
                                    <i class="fas fa-power-off mr-1"></i>Currently active
                                </small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="bg-info bg-gradient rounded-circle p-3 text-white">
                                <i class="fas fa-toggle-on fa-2x"></i>
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
            <form method="GET" action="{{ route('admin.companies.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small text-muted">Search Company</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" 
                               placeholder="Name, email, location..." value="{{ request('search') }}">
                    </div>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label small text-muted">Verification Status</label>
                    <select name="verification" class="form-select">
                        <option value="">All Status</option>
                        <option value="verified" {{ request('verification') == 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="pending" {{ request('verification') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ request('verification') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small text-muted">Subscription Type</label>
                    <select name="subscription" class="form-select">
                        <option value="">All Types</option>
                        <option value="free" {{ request('subscription') == 'free' ? 'selected' : '' }}>Free Plan</option>
                        <option value="premium" {{ request('subscription') == 'premium' ? 'selected' : '' }}>Premium Plans</option>
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
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Company Name</option>
                        <option value="jobs" {{ request('sort') == 'jobs' ? 'selected' : '' }}>Most Jobs</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <label class="form-label small text-muted">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i>
                        </button>
                        <a href="{{ route('admin.companies.index') }}" class="btn btn-light">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Companies Table -->
    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-2"></i>Companies List
                    </h5>
                </div>
                <div class="col text-right">
                    <span class="badge bg-light text-dark px-3 py-2">
                        Showing {{ $companies->firstItem() ?? 0 }}-{{ $companies->lastItem() ?? 0 }} 
                        of {{ $companies->total() ?? 0 }} companies
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
                            <th class="border-0">Company</th>
                            <th class="border-0">Contact</th>
                            <th class="border-0">Location</th>
                            <th class="border-0">Verification</th>
                            <th class="border-0">Subscription</th>
                            <th class="border-0">Jobs/Projects</th>
                            <th class="border-0">Status</th>
                            <th class="border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($companies as $company)
                        <tr>
                            <td class="px-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $company->id }}">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($company->logo)
                                        <img src="{{ asset($company->logo) }}" class="rounded-circle mr-3" 
                                             style="width: 45px; height: 45px; object-fit: cover;">
                                    @else
                                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center mr-3" 
                                             style="width: 45px; height: 45px;">
                                            <i class="fas fa-building"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0 font-weight-bold">{{ $company->company_name }}</h6>
                                        <small class="text-muted">
                                            {{ $company->industry->name ?? 'No Industry' }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="mb-1">
                                        <i class="fas fa-envelope text-muted mr-1"></i>
                                        {{ $company->user->email }}
                                    </div>
                                    @if($company->phone)
                                        <div>
                                            <i class="fas fa-phone text-muted mr-1"></i>
                                            {{ $company->phone }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div>
                                    <i class="fas fa-map-marker-alt text-muted mr-1"></i>
                                    {{ $company->city ?? 'N/A' }}, {{ $company->country ?? 'N/A' }}
                                </div>
                            </td>
                            <td>
                                @if($company->verification_status == 'verified')
                                    <span class="badge bg-success-soft text-success px-3 py-2">
                                        <i class="fas fa-check-circle mr-1"></i>Verified
                                    </span>
                                @elseif($company->verification_status == 'pending')
                                    <span class="badge bg-warning-soft text-warning px-3 py-2">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    </span>
                                @else
                                    <span class="badge bg-danger-soft text-danger px-3 py-2">
                                        <i class="fas fa-times-circle mr-1"></i>Rejected
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($company->subscriptions && $company->subscriptions->where('status', 'active')->first())
                                    @php $activeSub = $company->subscriptions->where('status', 'active')->first(); @endphp
                                    <div>
                                        <span class="badge bg-primary-soft text-primary px-3 py-2">
                                            <i class="fas fa-crown mr-1"></i>{{ $activeSub->plan->name ?? 'Premium' }}
                                        </span>
                                        <div class="small text-muted mt-1">
                                            Expires: {{ $activeSub->end_date ? $activeSub->end_date->format('M d, Y') : 'N/A' }}
                                        </div>
                                    </div>
                                @else
                                    <span class="badge bg-secondary-soft text-secondary px-3 py-2">
                                        <i class="fas fa-gift mr-1"></i>Free Plan
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="mb-1">
                                        <span class="badge bg-info-soft text-info">
                                            {{ $company->jobs_count ?? 0 }} Jobs
                                        </span>
                                    </div>
                                    <div>
                                        <span class="badge bg-purple-soft text-purple">
                                            {{ $company->projects_count ?? 0 }} Projects
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($company->user->status == 'active')
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" type="checkbox" 
                                               data-id="{{ $company->id }}" checked>
                                        <label class="form-check-label text-success small">Active</label>
                                    </div>
                                @else
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" type="checkbox" 
                                               data-id="{{ $company->id }}">
                                        <label class="form-check-label text-danger small">Inactive</label>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.companies.show', $company) }}" 
                                       class="btn btn-sm btn-light rounded-circle" 
                                       data-bs-toggle="tooltip" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.companies.edit', $company) }}" 
                                       class="btn btn-sm btn-primary rounded-circle" 
                                       data-bs-toggle="tooltip" title="Edit Company">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($company->verification_status == 'pending')
                                        <button class="btn btn-sm btn-success rounded-circle verify-company" 
                                                data-id="{{ $company->id }}"
                                                data-bs-toggle="tooltip" title="Verify Company">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    <form action="{{ route('admin.companies.destroy', $company) }}" 
                                          method="POST" class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this company?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-circle"
                                                data-bs-toggle="tooltip" title="Delete Company">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-building fa-3x mb-3"></i>
                                    <p>No companies found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($companies->hasPages())
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
                        {{ $companies->withQueryString()->links() }}
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
    
    // Verify company
    document.querySelectorAll('.verify-company').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to verify this company?')) {
                // Add verification logic here
                const companyId = this.dataset.id;
                // Make AJAX call to verify company
            }
        });
    });
    
    // Status toggle
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const companyId = this.dataset.id;
            const status = this.checked ? 'active' : 'inactive';
            // Make AJAX call to update status
        });
    });
</script>
@endpush
@endsection