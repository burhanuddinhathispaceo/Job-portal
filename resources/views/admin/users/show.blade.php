@extends('admin.layouts.app')

@section('title', __('admin.users.view_user'))

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">{{ __('admin.users.user_profile') }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('admin.users.title') }}</a></li>
                            <li class="breadcrumb-item active">{{ $user->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> {{ __('admin.edit') }}
                    </a>
                    @if($user->status == 'active')
                        <button class="btn btn-warning" onclick="toggleStatus({{ $user->id }})">
                            <i class="fas fa-ban"></i> {{ __('admin.deactivate') }}
                        </button>
                    @else
                        <button class="btn btn-success" onclick="toggleStatus({{ $user->id }})">
                            <i class="fas fa-check"></i> {{ __('admin.activate') }}
                        </button>
                    @endif
                    <button class="btn btn-danger" onclick="deleteUser({{ $user->id }})">
                        <i class="fas fa-trash"></i> {{ __('admin.delete') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- User Info Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-4">
                        @if($user->role == 'candidate' && $user->candidate && $user->candidate->profile_picture)
                            <img src="{{ asset($user->candidate->profile_picture) }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        @elseif($user->role == 'company' && $user->company && $user->company->logo)
                            <img src="{{ asset($user->company->logo) }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-gradient-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                <i class="fas fa-user fa-3x"></i>
                            </div>
                        @endif
                    </div>
                    <h4 class="font-weight-bold">{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                    <div class="mb-3">
                        <span class="badge badge-pill badge-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'company' ? 'info' : 'success') }} px-3 py-2">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <span class="badge badge-pill badge-{{ $user->status == 'active' ? 'success' : ($user->status == 'suspended' ? 'danger' : 'warning') }} px-3 py-2">
                            <i class="fas fa-circle"></i> {{ ucfirst($user->status) }}
                        </span>
                    </div>
                    @if($user->mobile)
                        <p><i class="fas fa-phone"></i> {{ $user->mobile }}</p>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card shadow-sm border-0 mt-3">
                <div class="card-header bg-gradient-primary text-white">
                    <h6 class="mb-0">{{ __('admin.users.quick_stats') }}</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('admin.users.member_since') }}</span>
                        <strong>{{ $user->created_at->format('M d, Y') }}</strong>
                    </div>
                    @if($user->email_verified_at)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('admin.users.email_verified') }}</span>
                        <strong class="text-success">{{ __('admin.yes') }}</strong>
                    </div>
                    @endif
                    @if($user->last_login_at)
                    <div class="d-flex justify-content-between">
                        <span>{{ __('admin.users.last_login') }}</span>
                        <strong>{{ $user->last_login_at->diffForHumans() }}</strong>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Details Section -->
        <div class="col-md-8">
            <!-- Role-Specific Information -->
            @if($user->role == 'company' && $user->company)
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-gradient-info text-white">
                        <h6 class="mb-0">{{ __('admin.users.company_information') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>{{ __('admin.companies.name') }}:</strong> {{ $user->company->company_name }}</p>
                                <p><strong>{{ __('admin.companies.industry') }}:</strong> {{ $user->company->industry->name ?? '-' }}</p>
                                <p><strong>{{ __('admin.companies.size') }}:</strong> {{ $user->company->company_size ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>{{ __('admin.companies.website') }}:</strong> 
                                    @if($user->company->website)
                                        <a href="{{ $user->company->website }}" target="_blank">{{ $user->company->website }}</a>
                                    @else
                                        -
                                    @endif
                                </p>
                                <p><strong>{{ __('admin.companies.location') }}:</strong> 
                                    {{ $user->company->city ?? '' }}{{ $user->company->city && $user->company->country ? ', ' : '' }}{{ $user->company->country ?? '' }}
                                </p>
                                <p><strong>{{ __('admin.companies.verification') }}:</strong> 
                                    <span class="badge badge-{{ $user->company->verification_status == 'verified' ? 'success' : 'warning' }}">
                                        {{ ucfirst($user->company->verification_status ?? 'pending') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($user->role == 'candidate' && $user->candidate)
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-gradient-success text-white">
                        <h6 class="mb-0">{{ __('admin.users.candidate_information') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>{{ __('admin.candidates.full_name') }}:</strong> {{ $user->candidate->first_name }} {{ $user->candidate->last_name }}</p>
                                <p><strong>{{ __('admin.candidates.experience') }}:</strong> {{ $user->candidate->experience_years }} {{ __('admin.years') }}</p>
                                <p><strong>{{ __('admin.candidates.expected_salary') }}:</strong> 
                                    @if($user->candidate->expected_salary)
                                        ${{ number_format($user->candidate->expected_salary) }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>{{ __('admin.candidates.location') }}:</strong> 
                                    {{ $user->candidate->city ?? '' }}{{ $user->candidate->city && $user->candidate->country ? ', ' : '' }}{{ $user->candidate->country ?? '' }}
                                </p>
                                <p><strong>{{ __('admin.candidates.skills') }}:</strong> {{ $user->candidate->skills->count() }} {{ __('admin.skills') }}</p>
                                <p><strong>{{ __('admin.candidates.profile_completion') }}:</strong> 
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-success" style="width: {{ $user->candidate->profile_completion ?? 0 }}%">
                                            {{ $user->candidate->profile_completion ?? 0 }}%
                                        </div>
                                    </div>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recent Activities -->
            @if(isset($user->activities) && $user->activities->count() > 0)
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h6 class="mb-0">{{ __('admin.users.recent_activities') }}</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($user->activities as $activity)
                        <div class="timeline-item">
                            <div class="timeline-badge">
                                <i class="fas fa-circle text-primary"></i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h6 class="timeline-title">{{ $activity->activity_type }}</h6>
                                    <p class="text-muted"><small><i class="fas fa-clock"></i> {{ $activity->created_at->diffForHumans() }}</small></p>
                                </div>
                                @if($activity->description)
                                <div class="timeline-body">
                                    <p>{{ $activity->description }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #36d1dc 0%, #5b86e5 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.timeline {
    position: relative;
    padding: 20px 0;
}
.timeline-item {
    position: relative;
    padding-left: 40px;
    margin-bottom: 20px;
}
.timeline-badge {
    position: absolute;
    left: 0;
    top: 5px;
}
.timeline-panel {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 15px;
}
</style>

@push('scripts')
<script>
function toggleStatus(userId) {
    if (confirm('{{ __("admin.users.confirm_status_change") }}')) {
        $.post(`/admin/users/${userId}/toggle-status`, {
            _token: '{{ csrf_token() }}'
        }).done(function(response) {
            location.reload();
        });
    }
}

function deleteUser(userId) {
    if (confirm('{{ __("admin.users.confirm_delete") }}')) {
        $.ajax({
            url: `/admin/users/${userId}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                window.location.href = '{{ route("admin.users.index") }}';
            }
        });
    }
}
</script>
@endpush
@endsection