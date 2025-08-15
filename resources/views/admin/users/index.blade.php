@extends('admin.layouts.app')

@section('title', __('admin.users.title'))

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white shadow-lg border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-0">
                                <i class="fas fa-users me-2"></i>{{ __('admin.users.management') }}
                            </h1>
                            <p class="mb-0 opacity-75">Manage system users, roles and permissions</p>
                        </div>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-plus-circle me-2"></i>{{ __('admin.create') }} {{ __('admin.users.title') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-primary-subtle rounded-circle">
                                <i class="fas fa-users text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">{{ __('admin.users.total_users') }}</p>
                            <h4 class="mb-0">{{ number_format($stats['total_users'] ?? 0) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-success-subtle rounded-circle">
                                <i class="fas fa-user-check text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">{{ __('admin.users.active_users') }}</p>
                            <h4 class="mb-0">{{ number_format($stats['active_users'] ?? 0) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-info-subtle rounded-circle">
                                <i class="fas fa-building text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">{{ __('admin.users.companies') }}</p>
                            <h4 class="mb-0">{{ number_format($stats['companies'] ?? 0) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-warning-subtle rounded-circle">
                                <i class="fas fa-user-tie text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">{{ __('admin.users.candidates') }}</p>
                            <h4 class="mb-0">{{ number_format($stats['candidates'] ?? 0) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light py-3">
            <h6 class="mb-0 fw-bold">
                <i class="fas fa-filter me-2"></i>{{ __('admin.users.filters') }}
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small text-muted">{{ __('admin.users.role') }}</label>
                        <select name="role" class="form-select" onchange="document.getElementById('filterForm').submit()">
                            <option value="">{{ __('admin.all_roles') }}</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                                <i class="fas fa-user-shield"></i> {{ __('admin.admin') }}
                            </option>
                            <option value="company" {{ request('role') == 'company' ? 'selected' : '' }}>
                                <i class="fas fa-building"></i> {{ __('admin.company') }}
                            </option>
                            <option value="candidate" {{ request('role') == 'candidate' ? 'selected' : '' }}>
                                <i class="fas fa-user-tie"></i> {{ __('admin.candidate') }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">{{ __('admin.status') }}</label>
                        <select name="status" class="form-select" onchange="document.getElementById('filterForm').submit()">
                            <option value="">{{ __('admin.all') }} Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                {{ __('admin.active') }}
                            </option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                {{ __('admin.inactive') }}
                            </option>
                            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>
                                {{ __('admin.suspended') }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted">{{ __('admin.search') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="{{ __('admin.users.search_placeholder') }}" 
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>{{ __('admin.search') }}
                        </button>
                        @if(request()->hasAny(['role', 'status', 'search']))
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light ms-2" title="Clear filters">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">{{ __('admin.users.list') }}</h6>
                <span class="badge bg-primary">{{ $users->total() }} {{ __('admin.results') }}</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th class="py-3">{{ __('admin.users.name') }}</th>
                            <th class="py-3">{{ __('admin.users.email') }}</th>
                            <th class="py-3">{{ __('admin.users.role') }}</th>
                            <th class="py-3">{{ __('admin.status') }}</th>
                            <th class="py-3">{{ __('admin.users.created_at') }}</th>
                            <th class="py-3 text-center">{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="px-4">
                                <div class="form-check">
                                    <input class="form-check-input user-checkbox" type="checkbox" value="{{ $user->id }}">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                        @if($user->role == 'company' && $user->company)
                                            <small class="text-muted">{{ $user->company->company_name }}</small>
                                        @elseif($user->role == 'candidate' && $user->candidate)
                                            <small class="text-muted">
                                                {{ $user->candidate->first_name }} {{ $user->candidate->last_name }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    {{ $user->email }}
                                    @if($user->email_verified_at)
                                        <i class="fas fa-check-circle text-success ms-1" title="Verified"></i>
                                    @else
                                        <i class="fas fa-exclamation-circle text-warning ms-1" title="Not verified"></i>
                                    @endif
                                </div>
                                @if($user->mobile)
                                    <small class="text-muted">{{ $user->mobile }}</small>
                                @endif
                            </td>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-user-shield me-1"></i>{{ ucfirst($user->role) }}
                                    </span>
                                @elseif($user->role == 'company')
                                    <span class="badge bg-info">
                                        <i class="fas fa-building me-1"></i>{{ ucfirst($user->role) }}
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        <i class="fas fa-user-tie me-1"></i>{{ ucfirst($user->role) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($user->status == 'active')
                                    <span class="badge bg-success-subtle text-success">
                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i>{{ ucfirst($user->status) }}
                                    </span>
                                @elseif($user->status == 'suspended')
                                    <span class="badge bg-danger-subtle text-danger">
                                        <i class="fas fa-ban me-1"></i>{{ ucfirst($user->status) }}
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning">
                                        <i class="fas fa-pause-circle me-1"></i>{{ ucfirst($user->status) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div>{{ $user->created_at->format('M d, Y') }}</div>
                                <small class="text-muted">{{ $user->created_at->format('h:i A') }}</small>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.users.show', $user) }}" 
                                       class="btn btn-sm btn-light-primary" 
                                       data-bs-toggle="tooltip" 
                                       title="{{ __('admin.view') }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="btn btn-sm btn-light-info" 
                                       data-bs-toggle="tooltip" 
                                       title="{{ __('admin.edit') }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    @if($user->status == 'active')
                                        <button type="button" 
                                                class="btn btn-sm btn-light-warning toggle-status" 
                                                data-id="{{ $user->id }}" 
                                                data-bs-toggle="tooltip" 
                                                title="{{ __('admin.deactivate') }}">
                                            <i class="fas fa-toggle-on"></i>
                                        </button>
                                    @else
                                        <button type="button" 
                                                class="btn btn-sm btn-light-success toggle-status" 
                                                data-id="{{ $user->id }}" 
                                                data-bs-toggle="tooltip" 
                                                title="{{ __('admin.activate') }}">
                                            <i class="fas fa-toggle-off"></i>
                                        </button>
                                    @endif
                                    <button type="button" 
                                            class="btn btn-sm btn-light-danger delete-user" 
                                            data-id="{{ $user->id }}" 
                                            data-bs-toggle="tooltip" 
                                            title="{{ __('admin.delete') }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>{{ __('admin.no_data') }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($users->hasPages())
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                    </div>
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .avatar-sm {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .avatar-title {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    .bg-primary-subtle {
        background-color: rgba(102, 126, 234, 0.1);
    }
    .bg-success-subtle {
        background-color: rgba(34, 197, 94, 0.1);
    }
    .bg-info-subtle {
        background-color: rgba(6, 182, 212, 0.1);
    }
    .bg-warning-subtle {
        background-color: rgba(251, 191, 36, 0.1);
    }
    .bg-danger-subtle {
        background-color: rgba(239, 68, 68, 0.1);
    }
    .btn-light-primary {
        background-color: rgba(102, 126, 234, 0.1);
        color: #667eea;
        border: none;
    }
    .btn-light-primary:hover {
        background-color: rgba(102, 126, 234, 0.2);
        color: #667eea;
    }
    .btn-light-info {
        background-color: rgba(6, 182, 212, 0.1);
        color: #06b6d4;
        border: none;
    }
    .btn-light-info:hover {
        background-color: rgba(6, 182, 212, 0.2);
        color: #06b6d4;
    }
    .btn-light-warning {
        background-color: rgba(251, 191, 36, 0.1);
        color: #fbbf24;
        border: none;
    }
    .btn-light-warning:hover {
        background-color: rgba(251, 191, 36, 0.2);
        color: #fbbf24;
    }
    .btn-light-success {
        background-color: rgba(34, 197, 94, 0.1);
        color: #22c55e;
        border: none;
    }
    .btn-light-success:hover {
        background-color: rgba(34, 197, 94, 0.2);
        color: #22c55e;
    }
    .btn-light-danger {
        background-color: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: none;
    }
    .btn-light-danger:hover {
        background-color: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    .card {
        border-radius: 12px;
    }
    .btn {
        border-radius: 8px;
    }
    .form-select, .form-control {
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }
    .form-select:focus, .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
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
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Toggle user status
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.id;
            if (confirm('{{ __("admin.users.confirm_status_change") }}')) {
                fetch(`/admin/users/${userId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        });
    });

    // Delete user
    document.querySelectorAll('.delete-user').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.id;
            if (confirm('{{ __("admin.users.confirm_delete") }}')) {
                fetch(`/admin/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        });
    });
</script>
@endpush