@extends('admin.layouts.app')

@section('title', 'View Candidate')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="card bg-gradient-primary text-white shadow-lg border-0 mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="h3 mb-0 font-weight-bold">
                        <i class="fas fa-user mr-2"></i>Candidate Details
                    </h1>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.candidates.edit', $candidate) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.candidates.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left mr-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    @if($candidate->profile_photo)
                        <img src="{{ asset($candidate->profile_photo) }}" class="img-thumbnail rounded-circle mb-3" 
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 150px; height: 150px;">
                            <i class="fas fa-user fa-3x text-muted"></i>
                        </div>
                    @endif
                    
                    <h4 class="font-weight-bold mb-1">{{ $candidate->first_name }} {{ $candidate->last_name }}</h4>
                    @if($candidate->professional_title)
                        <p class="text-muted mb-3">{{ $candidate->professional_title }}</p>
                    @endif
                    
                    <div class="d-flex justify-content-center mb-3">
                        <span class="badge badge-{{ $candidate->status == 'active' ? 'success' : ($candidate->status == 'inactive' ? 'secondary' : 'danger') }} px-3 py-2">
                            <i class="fas fa-circle mr-1"></i>{{ ucfirst($candidate->status) }}
                        </span>
                    </div>
                    
                    <div class="row text-center border-top pt-3">
                        <div class="col-4">
                            <h5 class="mb-0 text-primary">{{ $candidate->applications()->count() }}</h5>
                            <small class="text-muted">Applications</small>
                        </div>
                        <div class="col-4">
                            <h5 class="mb-0 text-success">{{ $candidate->user ? $candidate->user->bookmarks()->count() : 0 }}</h5>
                            <small class="text-muted">Bookmarks</small>
                        </div>
                        <div class="col-4">
                            <h5 class="mb-0 text-info">{{ $candidate->profile_completion ?? 0 }}%</h5>
                            <small class="text-muted">Complete</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-address-book mr-2"></i>Contact Information
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-envelope text-muted mr-2"></i>
                            <strong>Email:</strong> {{ $candidate->email }}
                        </li>
                        @if($candidate->phone)
                        <li class="mb-2">
                            <i class="fas fa-phone text-muted mr-2"></i>
                            <strong>Phone:</strong> {{ $candidate->phone }}
                        </li>
                        @endif
                        @if($candidate->date_of_birth)
                        <li class="mb-2">
                            <i class="fas fa-birthday-cake text-muted mr-2"></i>
                            <strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($candidate->date_of_birth)->format('M d, Y') }}
                        </li>
                        @endif
                        @if($candidate->gender)
                        <li class="mb-2">
                            <i class="fas fa-venus-mars text-muted mr-2"></i>
                            <strong>Gender:</strong> {{ ucfirst(str_replace('_', ' ', $candidate->gender)) }}
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            @if($candidate->address || $candidate->city || $candidate->state || $candidate->country)
            <!-- Location Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-map-marker-alt mr-2"></i>Location
                    </h5>
                </div>
                <div class="card-body">
                    @if($candidate->address)
                        <p class="mb-1"><strong>Address:</strong> {{ $candidate->address }}</p>
                    @endif
                    @if($candidate->city || $candidate->state)
                        <p class="mb-1">
                            <strong>City/State:</strong> 
                            {{ $candidate->city }}{{ $candidate->city && $candidate->state ? ', ' : '' }}{{ $candidate->state }}
                        </p>
                    @endif
                    @if($candidate->country)
                        <p class="mb-1"><strong>Country:</strong> {{ $candidate->country }}</p>
                    @endif
                    @if($candidate->postal_code)
                        <p class="mb-0"><strong>Postal Code:</strong> {{ $candidate->postal_code }}</p>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Professional Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-briefcase mr-2"></i>Professional Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($candidate->professional_title)
                        <div class="col-md-6 mb-3">
                            <strong>Professional Title:</strong>
                            <p class="mb-0">{{ $candidate->professional_title }}</p>
                        </div>
                        @endif
                        
                        @if($candidate->experience_years !== null)
                        <div class="col-md-6 mb-3">
                            <strong>Years of Experience:</strong>
                            <p class="mb-0">{{ $candidate->experience_years }} years</p>
                        </div>
                        @endif
                        
                        @if($candidate->current_salary)
                        <div class="col-md-6 mb-3">
                            <strong>Current Salary:</strong>
                            <p class="mb-0">${{ number_format($candidate->current_salary) }}</p>
                        </div>
                        @endif
                        
                        @if($candidate->expected_salary)
                        <div class="col-md-6 mb-3">
                            <strong>Expected Salary:</strong>
                            <p class="mb-0">${{ number_format($candidate->expected_salary) }}</p>
                        </div>
                        @endif
                    </div>
                    
                    @if($candidate->professional_summary)
                    <div class="mt-3">
                        <strong>Professional Summary:</strong>
                        <p class="mt-2 mb-0">{{ $candidate->professional_summary }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Recent Applications -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-file-alt mr-2"></i>Recent Applications
                    </h5>
                    <span class="badge badge-primary">{{ $candidate->applications()->count() }} Total</span>
                </div>
                <div class="card-body">
                    @forelse($candidate->applications()->with('job.company')->latest()->take(5)->get() as $application)
                        <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div>
                                <h6 class="mb-1">{{ $application->job->title ?? 'N/A' }}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-building mr-1"></i>{{ $application->job->company->company_name ?? 'N/A' }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-calendar mr-1"></i>{{ $application->created_at->format('M d, Y') }}
                                </small>
                            </div>
                            <div>
                                <span class="badge badge-{{ $application->status == 'accepted' ? 'success' : ($application->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-file-alt fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No applications found</p>
                        </div>
                    @endforelse
                    
                    @if($candidate->applications()->count() > 5)
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-outline-primary btn-sm">View All Applications</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Account Activity -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-clock mr-2"></i>Account Activity
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Member Since:</strong> {{ $candidate->created_at->format('M d, Y') }}</p>
                            <p><strong>Last Updated:</strong> {{ $candidate->updated_at->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Profile Completion:</strong> {{ $candidate->profile_completion ?? 0 }}%</p>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-primary" style="width: {{ $candidate->profile_completion ?? 0 }}%"></div>
                            </div>
                        </div>
                    </div>
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
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <a href="{{ route('admin.candidates.edit', $candidate) }}" class="btn btn-warning btn-block">
                                <i class="fas fa-edit mr-2"></i>Edit Candidate
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            @if($candidate->status == 'active')
                                <form action="{{ route('admin.candidates.suspend', $candidate) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to suspend this candidate?')">
                                        <i class="fas fa-ban mr-2"></i>Suspend Account
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-success btn-block" disabled>
                                    <i class="fas fa-check mr-2"></i>Account {{ ucfirst($candidate->status) }}
                                </button>
                            @endif
                        </div>
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
    
    .progress {
        border-radius: 10px;
    }
    
    .progress-bar {
        border-radius: 10px;
    }
</style>
@endpush
@endsection