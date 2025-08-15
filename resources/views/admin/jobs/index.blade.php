@extends('admin.layouts.app')

@section('title', __('admin.jobs.title'))

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">{{ __('admin.jobs.management') }}</h1>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.jobs.total') }}</h6>
                    <h3>{{ $stats['total_jobs'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.jobs.active') }}</h6>
                    <h3>{{ $stats['active_jobs'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.jobs.pending') }}</h6>
                    <h3>{{ $stats['pending_jobs'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.jobs.featured') }}</h6>
                    <h3>{{ $stats['featured_jobs'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.jobs.remote') }}</h6>
                    <h3>{{ $stats['remote_jobs'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.jobs.applications') }}</h6>
                    <h3>{{ $stats['total_applications'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Jobs Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('admin.jobs.title') }}</th>
                            <th>{{ __('admin.jobs.company') }}</th>
                            <th>{{ __('admin.jobs.type') }}</th>
                            <th>{{ __('admin.jobs.status') }}</th>
                            <th>{{ __('admin.jobs.visibility') }}</th>
                            <th>{{ __('admin.jobs.applications') }}</th>
                            <th>{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobs as $job)
                        <tr>
                            <td>
                                {{ $job->title }}
                                @if($job->is_remote)
                                    <span class="badge badge-info">{{ __('admin.remote') }}</span>
                                @endif
                            </td>
                            <td>{{ $job->company->company_name }}</td>
                            <td>{{ $job->jobType->name ?? '-' }}</td>
                            <td>
                                <span class="badge badge-{{ 
                                    $job->status == 'active' ? 'success' : 
                                    ($job->status == 'draft' ? 'secondary' : 
                                    ($job->status == 'expired' ? 'warning' : 'danger')) 
                                }}">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ 
                                    $job->visibility == 'featured' ? 'primary' : 
                                    ($job->visibility == 'highlighted' ? 'info' : 'light') 
                                }}">
                                    {{ ucfirst($job->visibility) }}
                                </span>
                            </td>
                            <td>{{ $job->applications_count }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">{{ __('admin.no_data') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $jobs->links() }}
        </div>
    </div>
</div>
@endsection