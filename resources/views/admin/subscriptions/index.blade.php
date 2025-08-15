@extends('admin.layouts.app')

@section('title', __('admin.subscriptions.title'))

@section('content')
<div class="container-fluid py-4">
    <h1 class="h3 mb-4">{{ __('admin.subscriptions.management') }}</h1>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.subscriptions.total') }}</h6>
                    <h3>{{ $stats['total_subscriptions'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.subscriptions.active') }}</h6>
                    <h3>{{ $stats['active_subscriptions'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.subscriptions.expired') }}</h6>
                    <h3>{{ $stats['expired_subscriptions'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('admin.subscriptions.revenue') }}</h6>
                    <h3>${{ number_format($stats['total_revenue'] ?? 0, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscriptions Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('admin.subscriptions.company') }}</th>
                            <th>{{ __('admin.subscriptions.plan') }}</th>
                            <th>{{ __('admin.subscriptions.amount') }}</th>
                            <th>{{ __('admin.subscriptions.status') }}</th>
                            <th>{{ __('admin.subscriptions.start_date') }}</th>
                            <th>{{ __('admin.subscriptions.end_date') }}</th>
                            <th>{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->company->company_name }}</td>
                            <td>{{ $subscription->plan->name }}</td>
                            <td>{{ $subscription->currency }} {{ number_format($subscription->amount_paid, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ 
                                    $subscription->status == 'active' ? 'success' : 
                                    ($subscription->status == 'expired' ? 'warning' : 'danger') 
                                }}">
                                    {{ ucfirst($subscription->status) }}
                                </span>
                            </td>
                            <td>{{ $subscription->start_date }}</td>
                            <td>{{ $subscription->end_date }}</td>
                            <td>
                                <a href="{{ route('admin.subscriptions.show', $subscription) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
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
            {{ $subscriptions->links() }}
        </div>
    </div>
</div>
@endsection