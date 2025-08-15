@extends('admin.layouts.app')

@section('title', __('admin.projects.title'))

@section('content')
<div class="container-fluid py-4">
    <h1 class="h3 mb-4">{{ __('admin.projects.management') }}</h1>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.projects.total') }}</h6>
                    <h3>{{ $stats['total_projects'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.projects.active') }}</h6>
                    <h3>{{ $stats['active_projects'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.projects.completed') }}</h6>
                    <h3>{{ $stats['completed_projects'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.projects.applications') }}</h6>
                    <h3>{{ $stats['total_applications'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('admin.projects.title') }}</th>
                            <th>{{ __('admin.projects.company') }}</th>
                            <th>{{ __('admin.projects.budget') }}</th>
                            <th>{{ __('admin.projects.status') }}</th>
                            <th>{{ __('admin.projects.applications') }}</th>
                            <th>{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                        <tr>
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->company->company_name }}</td>
                            <td>
                                {{ $project->budget_currency }} 
                                {{ number_format($project->budget_min) }} - 
                                {{ number_format($project->budget_max) }}
                            </td>
                            <td>
                                <span class="badge badge-{{ $project->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                            <td>{{ $project->applications_count }}</td>
                            <td>
                                <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">{{ __('admin.no_data') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $projects->links() }}
        </div>
    </div>
</div>
@endsection