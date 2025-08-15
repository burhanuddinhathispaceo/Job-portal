@extends('admin.layouts.app')

@section('title', __('admin.plans.title'))

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">{{ __('admin.plans.management') }}</h1>
        <a href="{{ route('admin.plans.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> {{ __('admin.plans.create_new') }}
        </a>
    </div>

    <!-- Plans Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('admin.plans.name') }}</th>
                            <th>{{ __('admin.plans.price') }}</th>
                            <th>{{ __('admin.plans.duration') }}</th>
                            <th>{{ __('admin.plans.job_limit') }}</th>
                            <th>{{ __('admin.plans.project_limit') }}</th>
                            <th>{{ __('admin.plans.features') }}</th>
                            <th>{{ __('admin.plans.status') }}</th>
                            <th>{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                        <tr>
                            <td>{{ $plan->name }}</td>
                            <td>{{ $plan->currency }} {{ number_format($plan->price, 2) }}</td>
                            <td>{{ $plan->duration_days }} {{ __('admin.days') }}</td>
                            <td>{{ $plan->job_post_limit }}</td>
                            <td>{{ $plan->project_post_limit }}</td>
                            <td>
                                @if($plan->candidate_search)
                                    <span class="badge badge-success">{{ __('admin.plans.candidate_search') }}</span>
                                @endif
                                @if($plan->analytics_access)
                                    <span class="badge badge-info">{{ __('admin.plans.analytics') }}</span>
                                @endif
                                @if($plan->priority_support)
                                    <span class="badge badge-warning">{{ __('admin.plans.priority_support') }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $plan->is_active ? 'success' : 'danger' }}">
                                    {{ $plan->is_active ? __('admin.active') : __('admin.inactive') }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.plans.edit', $plan) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger delete-plan" data-id="{{ $plan->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
            {{ $plans->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    $('.delete-plan').click(function() {
        const planId = $(this).data('id');
        if (confirm('{{ __("admin.plans.confirm_delete") }}')) {
            $.ajax({
                url: `/admin/plans/${planId}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection