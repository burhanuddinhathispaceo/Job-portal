@extends('admin.layouts.app')

@section('title', __('admin.settings.title'))

@section('content')
<div class="container-fluid py-4">
    <h1 class="h3 mb-4">{{ __('admin.settings.system_configuration') }}</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-briefcase fa-3x mb-3 text-primary"></i>
                    <h5>{{ __('admin.settings.job_types') }}</h5>
                    <p class="text-muted">{{ $stats['job_types'] ?? 0 }} {{ __('admin.items') }}</p>
                    <a href="{{ route('admin.settings.job-types') }}" class="btn btn-primary btn-sm">
                        {{ __('admin.manage') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-project-diagram fa-3x mb-3 text-info"></i>
                    <h5>{{ __('admin.settings.project_types') }}</h5>
                    <p class="text-muted">{{ $stats['project_types'] ?? 0 }} {{ __('admin.items') }}</p>
                    <a href="#" class="btn btn-info btn-sm">{{ __('admin.manage') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-industry fa-3x mb-3 text-success"></i>
                    <h5>{{ __('admin.settings.industries') }}</h5>
                    <p class="text-muted">{{ $stats['industries'] ?? 0 }} {{ __('admin.items') }}</p>
                    <a href="{{ route('admin.settings.industries') }}" class="btn btn-success btn-sm">
                        {{ __('admin.manage') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-tools fa-3x mb-3 text-warning"></i>
                    <h5>{{ __('admin.settings.skills') }}</h5>
                    <p class="text-muted">{{ $stats['skills'] ?? 0 }} {{ __('admin.items') }}</p>
                    <a href="{{ route('admin.settings.skills') }}" class="btn btn-warning btn-sm">
                        {{ __('admin.manage') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-cog fa-3x mb-3 text-secondary"></i>
                    <h5>{{ __('admin.settings.website_settings') }}</h5>
                    <p class="text-muted">{{ __('admin.settings.configure_website') }}</p>
                    <a href="{{ route('admin.settings.website') }}" class="btn btn-secondary">
                        {{ __('admin.settings.manage_settings') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection