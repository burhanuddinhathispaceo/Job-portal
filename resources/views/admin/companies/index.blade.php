@extends('admin.layouts.app')

@section('title', __('admin.companies.title'))

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">{{ __('admin.companies.management') }}</h1>
                <a href="{{ route('admin.companies.export') }}" class="btn btn-info">
                    <i class="fas fa-file-export"></i> {{ __('admin.companies.export') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        {{ __('admin.companies.total') }}
                    </div>
                    <div class="h5 mb-0 font-weight-bold">{{ $stats['total_companies'] ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        {{ __('admin.companies.active') }}
                    </div>
                    <div class="h5 mb-0 font-weight-bold">{{ $stats['active_companies'] ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        {{ __('admin.companies.verified') }}
                    </div>
                    <div class="h5 mb-0 font-weight-bold">{{ $stats['verified_companies'] ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        {{ __('admin.companies.premium') }}
                    </div>
                    <div class="h5 mb-0 font-weight-bold">{{ $stats['premium_companies'] ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Companies Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('admin.companies.list') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('admin.companies.id') }}</th>
                            <th>{{ __('admin.companies.name') }}</th>
                            <th>{{ __('admin.companies.email') }}</th>
                            <th>{{ __('admin.companies.industry') }}</th>
                            <th>{{ __('admin.companies.verification') }}</th>
                            <th>{{ __('admin.companies.subscription') }}</th>
                            <th>{{ __('admin.companies.status') }}</th>
                            <th>{{ __('admin.companies.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($companies as $company)
                        <tr>
                            <td>{{ $company->id }}</td>
                            <td>
                                @if($company->logo)
                                    <img src="{{ asset($company->logo) }}" class="img-thumbnail" style="width: 30px; height: 30px;">
                                @endif
                                {{ $company->company_name }}
                            </td>
                            <td>{{ $company->user->email }}</td>
                            <td>{{ $company->industry->name ?? '-' }}</td>
                            <td>
                                @if($company->verification_status == 'verified')
                                    <span class="badge badge-success">{{ __('admin.verified') }}</span>
                                @elseif($company->verification_status == 'pending')
                                    <span class="badge badge-warning">{{ __('admin.pending') }}</span>
                                @else
                                    <span class="badge badge-danger">{{ __('admin.rejected') }}</span>
                                @endif
                            </td>
                            <td>
                                @if($company->subscription && $company->subscription->status == 'active')
                                    <span class="badge badge-info">{{ $company->subscription->plan->name }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ __('admin.free') }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $company->user->status == 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($company->user->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.companies.show', $company) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.companies.edit', $company) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($company->verification_status == 'pending')
                                        <button class="btn btn-sm btn-success verify-company" data-id="{{ $company->id }}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">{{ __('admin.no_data') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $companies->links() }}
        </div>
    </div>
</div>
@endsection