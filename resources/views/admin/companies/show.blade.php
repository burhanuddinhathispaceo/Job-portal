@extends('admin.layouts.app')

@section('title', 'View Company')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="card bg-gradient-primary text-white shadow-lg border-0 mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="h3 mb-0 font-weight-bold">
                        <i class="fas fa-building mr-2"></i>{{ $company->company_name }}
                    </h1>
                    <p class="mb-0 opacity-90">Company Profile Details</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.companies.edit', $company) }}" class="btn btn-light mr-2">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.companies.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Company Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            @if($company->logo)
                                <img src="{{ asset($company->logo) }}" class="img-thumbnail mb-3" style="max-width: 150px;">
                            @else
                                <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 150px; height: 150px;">
                                    <i class="fas fa-building fa-3x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h4 class="mb-3">{{ $company->company_name }}</h4>
                            <div class="row mb-2">
                                <div class="col-sm-4"><strong>Email:</strong></div>
                                <div class="col-sm-8">{{ $company->user->email }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4"><strong>Phone:</strong></div>
                                <div class="col-sm-8">{{ $company->phone ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4"><strong>Website:</strong></div>
                                <div class="col-sm-8">
                                    @if($company->website)
                                        <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4"><strong>Industry:</strong></div>
                                <div class="col-sm-8">{{ $company->industry->name ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4"><strong>Company Size:</strong></div>
                                <div class="col-sm-8">{{ $company->company_size ?? 'N/A' }} employees</div>
                            </div>
                        </div>
                    </div>
                    
                    @if($company->description)
                        <hr>
                        <h5>About Company</h5>
                        <p>{{ $company->description }}</p>
                    @endif
                </div>
            </div>

            <!-- Jobs & Projects -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Recent Job Postings</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Applications</th>
                                    <th>Posted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($company->jobs()->latest()->take(5)->get() as $job)
                                    <tr>
                                        <td>{{ $job->title }}</td>
                                        <td><span class="badge bg-{{ $job->status == 'active' ? 'success' : 'secondary' }}">{{ ucfirst($job->status) }}</span></td>
                                        <td>{{ $job->applications_count ?? 0 }}</td>
                                        <td>{{ $job->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No jobs posted yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Status Information</h5>
                    <div class="mb-3">
                        <small class="text-muted">Account Status</small>
                        <div><span class="badge bg-{{ $company->user->status == 'active' ? 'success' : 'danger' }}">{{ ucfirst($company->user->status) }}</span></div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Verification Status</small>
                        <div><span class="badge bg-{{ $company->verification_status == 'verified' ? 'success' : 'warning' }}">{{ ucfirst($company->verification_status) }}</span></div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Member Since</small>
                        <div>{{ $company->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Statistics</h5>
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="h4 text-primary">{{ $company->jobs_count ?? 0 }}</div>
                            <small class="text-muted">Total Jobs</small>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="h4 text-success">{{ $company->projects_count ?? 0 }}</div>
                            <small class="text-muted">Projects</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Location</h5>
                    <p class="mb-1">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        {{ $company->city ?? 'N/A' }}, {{ $company->state ?? '' }}
                    </p>
                    <p class="mb-0">{{ $company->country ?? 'N/A' }}</p>
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
</style>
@endpush
@endsection