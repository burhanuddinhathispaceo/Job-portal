@extends('admin.layouts.app')

@section('title', 'View Project')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="card bg-gradient-primary text-white shadow-lg border-0 mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="h3 mb-0 font-weight-bold">
                        <i class="fas fa-project-diagram mr-2"></i>Project Details
                    </h1>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left mr-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Project Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle mr-2"></i>Project Information
                    </h5>
                    <div>
                        <span class="badge badge-{{ $project->status == 'active' ? 'success' : ($project->status == 'inactive' ? 'secondary' : 'danger') }} me-2">
                            {{ ucfirst($project->status) }}
                        </span>
                        <span class="badge badge-{{ $project->visibility == 'featured' ? 'warning' : 'info' }}">
                            {{ ucfirst($project->visibility) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h2 class="mb-2">{{ $project->title }}</h2>
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-building mr-2"></i>
                                <a href="{{ route('admin.companies.show', $project->company) }}" class="text-decoration-none">
                                    {{ $project->company->company_name }}
                                </a>
                                <span class="mx-2">•</span>
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ $project->location ?? 'Remote' }}
                                @if($project->is_remote)
                                    <span class="badge bg-success bg-opacity-10 text-success ms-2">Remote</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Project Type:</strong>
                            <span class="ms-2">{{ $project->projectType->name ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Duration:</strong>
                            <span class="ms-2">{{ $project->duration_months ? $project->duration_months . ' months' : 'Not specified' }}</span>
                        </div>
                        @if($project->budget_min || $project->budget_max)
                        <div class="col-md-6 mb-3">
                            <strong>Budget Range:</strong>
                            <span class="ms-2">
                                @if($project->budget_min && $project->budget_max)
                                    ${{ number_format($project->budget_min) }} - ${{ number_format($project->budget_max) }}
                                @elseif($project->budget_min)
                                    From ${{ number_format($project->budget_min) }}
                                @else
                                    Up to ${{ number_format($project->budget_max) }}
                                @endif
                            </span>
                        </div>
                        @endif
                        @if($project->application_deadline)
                        <div class="col-md-6 mb-3">
                            <strong>Application Deadline:</strong>
                            <span class="ms-2">{{ $project->application_deadline->format('M d, Y') }}</span>
                        </div>
                        @endif
                    </div>
                    
                    @if($project->description)
                    <div class="mt-4">
                        <h6 class="font-weight-bold">Project Description:</h6>
                        <div class="mt-2">{{ $project->description }}</div>
                    </div>
                    @endif
                    
                    @if($project->requirements)
                    <div class="mt-4">
                        <h6 class="font-weight-bold">Requirements:</h6>
                        <div class="mt-2">{{ $project->requirements }}</div>
                    </div>
                    @endif
                    
                    @if($project->skills->count() > 0)
                    <div class="mt-4">
                        <h6 class="font-weight-bold">Required Skills:</h6>
                        <div class="mt-2">
                            @foreach($project->skills as $skill)
                                <span class="badge bg-primary bg-opacity-10 text-primary me-2 mb-2">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Applications -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-file-alt mr-2"></i>Recent Applications
                    </h5>
                    <span class="badge badge-primary">{{ $project->applications()->count() }} Total</span>
                </div>
                <div class="card-body">
                    @forelse($project->applications()->with('candidate.user')->latest()->take(10)->get() as $application)
                        <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div>
                                <h6 class="mb-1">
                                    {{ $application->candidate->first_name ?? 'N/A' }} {{ $application->candidate->last_name ?? 'N/A' }}
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-envelope mr-1"></i>{{ $application->candidate->user->email ?? 'N/A' }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-calendar mr-1"></i>{{ $application->created_at->format('M d, Y') }}
                                </small>
                            </div>
                            <div>
                                <span class="badge badge-{{ $application->status == 'selected' ? 'success' : ($application->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-file-alt fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No applications received yet</p>
                        </div>
                    @endforelse
                    
                    @if($project->applications()->count() > 10)
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-outline-primary btn-sm">View All Applications</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Statistics -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-bar mr-2"></i>Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border-end">
                                <h4 class="mb-0 text-primary">{{ number_format($project->views_count ?? 0) }}</h4>
                                <small class="text-muted">Views</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <h4 class="mb-0 text-success">{{ $project->applications()->count() }}</h4>
                            <small class="text-muted">Applications</small>
                        </div>
                        <div class="col-6">
                            <h4 class="mb-0 text-warning">{{ $project->applications()->where('status', 'shortlisted')->count() }}</h4>
                            <small class="text-muted">Shortlisted</small>
                        </div>
                        <div class="col-6">
                            <h4 class="mb-0 text-info">{{ $project->applications()->where('status', 'selected')->count() }}</h4>
                            <small class="text-muted">Selected</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-building mr-2"></i>Company Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if($project->company->logo)
                            <img src="{{ asset($project->company->logo) }}" class="img-thumbnail" 
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px; margin: 0 auto;">
                                <i class="fas fa-building fa-2x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <h6 class="text-center mb-3">{{ $project->company->company_name }}</h6>
                    <ul class="list-unstyled">
                        @if($project->company->industry)
                        <li class="mb-2">
                            <strong>Industry:</strong> {{ $project->company->industry->name }}
                        </li>
                        @endif
                        @if($project->company->company_size)
                        <li class="mb-2">
                            <strong>Size:</strong> {{ $project->company->company_size }} employees
                        </li>
                        @endif
                        @if($project->company->website)
                        <li class="mb-2">
                            <strong>Website:</strong> 
                            <a href="{{ $project->company->website }}" target="_blank" class="text-decoration-none">
                                {{ parse_url($project->company->website, PHP_URL_HOST) }}
                            </a>
                        </li>
                        @endif
                        <li class="mb-2">
                            <strong>Status:</strong> 
                            <span class="badge badge-{{ $project->company->verification_status == 'verified' ? 'success' : 'warning' }}">
                                {{ ucfirst($project->company->verification_status) }}
                            </span>
                        </li>
                    </ul>
                    <div class="text-center">
                        <a href="{{ route('admin.companies.show', $project->company) }}" class="btn btn-outline-primary btn-sm">
                            View Company Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Project Activity -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-clock mr-2"></i>Activity
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Posted:</strong> {{ $project->created_at->format('M d, Y') }}
                        <small class="text-muted">({{ $project->created_at->diffForHumans() }})</small>
                    </div>
                    <div class="mb-3">
                        <strong>Last Updated:</strong> {{ $project->updated_at->format('M d, Y') }}
                    </div>
                    @if($project->is_urgent)
                    <div class="alert alert-warning alert-sm">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Urgent Requirement</strong>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt mr-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning">
                            <i class="fas fa-edit mr-2"></i>Edit Project
                        </a>
                        @if($project->status == 'active')
                            <form action="{{ route('admin.projects.change-status', $project) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="inactive">
                                <button type="submit" class="btn btn-secondary w-100">
                                    <i class="fas fa-pause mr-2"></i>Deactivate
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.projects.change-status', $project) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="active">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-play mr-2"></i>Activate
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this project?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash mr-2"></i>Delete Project
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .badge {
        font-size: 0.85em;
    }
    
    .alert-sm {
        padding: 0.5rem 0.75rem;
        margin-bottom: 0.5rem;
        font-size: 0.875em;
    }
</style>
@endpush
@endsection