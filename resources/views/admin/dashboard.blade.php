@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6">
        <div class="stats-card primary">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="stats-number text-primary">{{ number_format($stats['total_users']) }}</div>
                    <div class="text-muted">Total Users</div>
                </div>
                <div class="ms-3">
                    <i class="fas fa-users fa-2x text-primary opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stats-card success">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="stats-number text-success">{{ number_format($stats['total_companies']) }}</div>
                    <div class="text-muted">Companies</div>
                </div>
                <div class="ms-3">
                    <i class="fas fa-building fa-2x text-success opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stats-card warning">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="stats-number text-warning">{{ number_format($stats['active_jobs']) }}</div>
                    <div class="text-muted">Active Jobs</div>
                </div>
                <div class="ms-3">
                    <i class="fas fa-briefcase fa-2x text-warning opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stats-card info">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="stats-number text-info">{{ number_format($stats['total_applications']) }}</div>
                    <div class="text-muted">Applications</div>
                </div>
                <div class="ms-3">
                    <i class="fas fa-file-alt fa-2x text-info opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Growth Chart -->
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Platform Growth</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Last 12 Months
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Last 6 Months</a></li>
                        <li><a class="dropdown-item" href="#">Last 12 Months</a></li>
                        <li><a class="dropdown-item" href="#">Last Year</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <canvas id="growthChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Overview</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Candidates</span>
                    <span class="fw-bold text-primary">{{ number_format($stats['total_candidates']) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Active Subscriptions</span>
                    <span class="fw-bold text-success">{{ number_format($stats['active_subscriptions']) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Success Rate</span>
                    <span class="fw-bold text-info">
                        {{ $stats['total_applications'] > 0 ? round(($stats['active_subscriptions'] / $stats['total_applications']) * 100, 1) : 0 }}%
                    </span>
                </div>
                <hr>
                <button class="btn btn-primary btn-sm w-100" onclick="refreshStats()">
                    <i class="fas fa-sync-alt me-2"></i>Refresh Data
                </button>
            </div>
        </div>
        
        <!-- System Health -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">System Health</h5>
            </div>
            <div class="card-body" id="systemHealth">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Users -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Users</h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @forelse($recentUsers as $user)
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" 
                             style="width: 40px; height: 40px;">
                            <span class="text-white fw-bold">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $user->name }}</div>
                            <small class="text-muted">{{ ucfirst($user->role) }} • {{ $user->created_at->diffForHumans() }}</small>
                        </div>
                        <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted text-center">No recent users</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Recent Jobs -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Jobs</h5>
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @forelse($recentJobs as $job)
                    <div class="d-flex align-items-start mb-3">
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ Str::limit($job->title, 30) }}</div>
                            <small class="text-muted">
                                {{ $job->company->company_name ?? $job->company->user->name }}
                                • {{ $job->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <span class="badge bg-{{ $job->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($job->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted text-center">No recent jobs</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Recent Applications -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Applications</h5>
                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @forelse($recentApplications as $application)
                    <div class="d-flex align-items-start mb-3">
                        <div class="rounded-circle bg-info d-flex align-items-center justify-content-center me-3" 
                             style="width: 35px; height: 35px;">
                            <span class="text-white fw-bold">{{ substr($application->candidate->user->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $application->candidate->user->name }}</div>
                            <small class="text-muted">
                                Applied to {{ Str::limit($application->job->title, 25) }}
                                • {{ $application->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <span class="badge bg-{{ $application->status === 'pending' ? 'warning' : 'primary' }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted text-center">No recent applications</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Popular Skills & Industries -->
<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Popular Skills</h5>
            </div>
            <div class="card-body">
                <canvas id="skillsChart" style="height: 250px;"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Industry Distribution</h5>
            </div>
            <div class="card-body">
                <canvas id="industryChart" style="height: 250px;"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Growth Chart
const growthCtx = document.getElementById('growthChart').getContext('2d');
const monthlyStats = @json($monthlyStats);

new Chart(growthCtx, {
    type: 'line',
    data: {
        labels: monthlyStats.map(stat => stat.month),
        datasets: [{
            label: 'Users',
            data: monthlyStats.map(stat => stat.users),
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            tension: 0.4
        }, {
            label: 'Jobs',
            data: monthlyStats.map(stat => stat.jobs),
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4
        }, {
            label: 'Applications',
            data: monthlyStats.map(stat => stat.applications),
            borderColor: '#ffc107',
            backgroundColor: 'rgba(255, 193, 7, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Skills Chart
const skillsCtx = document.getElementById('skillsChart').getContext('2d');
const popularSkills = @json($popularSkills);

new Chart(skillsCtx, {
    type: 'doughnut',
    data: {
        labels: popularSkills.map(skill => skill.name),
        datasets: [{
            data: popularSkills.map(skill => skill.count),
            backgroundColor: [
                '#667eea', '#28a745', '#ffc107', '#dc3545', '#17a2b8',
                '#6c757d', '#fd7e14', '#e83e8c', '#6f42c1', '#20c997'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Industry Chart
const industryCtx = document.getElementById('industryChart').getContext('2d');
const industryStats = @json($industryStats);

new Chart(industryCtx, {
    type: 'bar',
    data: {
        labels: industryStats.map(industry => industry.name),
        datasets: [{
            label: 'Companies',
            data: industryStats.map(industry => industry.count),
            backgroundColor: 'rgba(102, 126, 234, 0.8)',
            borderColor: '#667eea',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Load system health
function loadSystemHealth() {
    fetch('{{ route("admin.system.overview") }}')
        .then(response => response.json())
        .then(data => {
            const healthDiv = document.getElementById('systemHealth');
            healthDiv.innerHTML = `
                <div class="row text-center">
                    <div class="col-6 mb-2">
                        <small class="text-muted">Database</small>
                        <div class="fw-bold">${data.database_size}</div>
                    </div>
                    <div class="col-6 mb-2">
                        <small class="text-muted">Storage</small>
                        <div class="fw-bold">${data.storage_usage}</div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Cache</small>
                        <div class="fw-bold text-${data.cache_status === 'Working' ? 'success' : 'danger'}">${data.cache_status}</div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Queue</small>
                        <div class="fw-bold text-success">${data.queue_status}</div>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            document.getElementById('systemHealth').innerHTML = 
                '<p class="text-danger text-center">Failed to load system data</p>';
        });
}

function refreshStats() {
    window.location.reload();
}

// Load system health on page load
document.addEventListener('DOMContentLoaded', function() {
    loadSystemHealth();
});
</script>
@endpush
@endsection