@extends('admin.layouts.app')

@section('title', __('admin.candidates.title'))

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">{{ __('admin.candidates.management') }}</h1>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.candidates.total') }}</h6>
                    <h3>{{ $stats['total_candidates'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.candidates.active') }}</h6>
                    <h3>{{ $stats['active_candidates'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.candidates.verified') }}</h6>
                    <h3>{{ $stats['verified_candidates'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.candidates.recent_applications') }}</h6>
                    <h3>{{ $stats['recent_applications'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Candidates Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('admin.candidates.name') }}</th>
                            <th>{{ __('admin.candidates.email') }}</th>
                            <th>{{ __('admin.candidates.experience') }}</th>
                            <th>{{ __('admin.candidates.skills') }}</th>
                            <th>{{ __('admin.candidates.status') }}</th>
                            <th>{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidates as $candidate)
                        <tr>
                            <td>{{ $candidate->first_name }} {{ $candidate->last_name }}</td>
                            <td>{{ $candidate->user->email }}</td>
                            <td>{{ $candidate->experience_years }} {{ __('admin.years') }}</td>
                            <td>{{ $candidate->skills->count() }} {{ __('admin.skills') }}</td>
                            <td>
                                <span class="badge badge-{{ $candidate->user->status == 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($candidate->user->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.candidates.show', $candidate) }}" class="btn btn-sm btn-info">
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
            {{ $candidates->links() }}
        </div>
    </div>
</div>
@endsection