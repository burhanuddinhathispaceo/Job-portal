@extends('admin.layouts.app')

@section('title', __('admin.analytics.title'))

@section('content')
<div class="container-fluid py-4">
    <h1 class="h3 mb-4">{{ __('admin.analytics.dashboard') }}</h1>

    <!-- Overview Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6>{{ __('admin.analytics.total_users') }}</h6>
                    <h2>{{ number_format($overview['total_users'] ?? 0) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>{{ __('admin.analytics.total_jobs') }}</h6>
                    <h2>{{ number_format($overview['total_jobs'] ?? 0) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>{{ __('admin.analytics.total_applications') }}</h6>
                    <h2>{{ number_format($overview['total_applications'] ?? 0) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>{{ __('admin.analytics.total_revenue') }}</h6>
                    <h2>${{ number_format($overview['total_revenue'] ?? 0, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('admin.analytics.user_growth') }}</h5>
                </div>
                <div class="card-body">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('admin.analytics.job_trends') }}</h5>
                </div>
                <div class="card-body">
                    <canvas id="jobTrendsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('admin.analytics.revenue_overview') }}</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Fetch analytics data and render charts
$(document).ready(function() {
    // User Growth Chart
    $.get('{{ route("admin.analytics.user-growth") }}', function(data) {
        const ctx = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.map(item => item.period),
                datasets: [{
                    label: '{{ __("admin.analytics.new_users") }}',
                    data: data.map(item => item.new_users),
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            }
        });
    });

    // Job Trends Chart
    $.get('{{ route("admin.analytics.job-trends") }}', function(data) {
        const ctx = document.getElementById('jobTrendsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => item.period),
                datasets: [{
                    label: '{{ __("admin.analytics.jobs_posted") }}',
                    data: data.map(item => item.jobs_posted),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)'
                }, {
                    label: '{{ __("admin.analytics.applications") }}',
                    data: data.map(item => item.applications_received),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)'
                }]
            }
        });
    });

    // Revenue Chart
    $.get('{{ route("admin.analytics.revenue-reports") }}', function(data) {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.map(item => item.period),
                datasets: [{
                    label: '{{ __("admin.analytics.revenue") }}',
                    data: data.map(item => item.revenue),
                    borderColor: 'rgb(255, 206, 86)',
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    tension: 0.1
                }]
            }
        });
    });
});
</script>
@endpush
@endsection