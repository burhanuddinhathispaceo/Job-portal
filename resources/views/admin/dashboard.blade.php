@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@push('styles')
<style>
    .dashboard-welcome {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem;
        color: white;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.15);
    }
    
    .dashboard-welcome::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="white" opacity="0.1"><circle cx="50" cy="50" r="40"/></svg>') no-repeat;
        background-size: 200px 200px;
        animation: float 6s ease-in-out infinite;
    }
    
    .enhanced-stats-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        border: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
    }
    
    .enhanced-stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--card-color);
    }
    
    .enhanced-stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }
    
    .enhanced-stats-card.primary { --card-color: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .enhanced-stats-card.success { --card-color: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%); }
    .enhanced-stats-card.warning { --card-color: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .enhanced-stats-card.info { --card-color: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .enhanced-stats-card.danger { --card-color: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%); }
    
    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-bottom: 1rem;
    }
    
    .stats-icon.primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .stats-icon.success { background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%); }
    .stats-icon.warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .stats-icon.info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .stats-icon.danger { background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%); }
    
    .enhanced-stats-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        background: var(--card-color);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .enhanced-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        border: none;
        transition: all 0.3s ease;
        margin-bottom: 2rem;
        height: 100%;
    }
    
    .enhanced-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }
    
    .card-header-enhanced {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
        border-radius: 1rem 1rem 0 0 !important;
        padding: 1.5rem 2rem;
    }
    
    .activity-item {
        padding: 1rem;
        border-radius: 0.75rem;
        margin-bottom: 0.75rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .activity-item:hover {
        background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
        transform: translateX(5px);
    }
    
    .quick-action-card {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef !important;
    }
    
    .quick-action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        border-color: #dee2e6 !important;
    }
    
    .quick-action-icon {
        transition: transform 0.3s ease;
    }
    
    .quick-action-card:hover .quick-action-icon {
        transform: scale(1.1);
    }
    
    .metric-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .progress-enhanced {
        height: 8px;
        border-radius: 10px;
        background: #e9ecef;
        overflow: hidden;
    }
    
    .progress-bar-enhanced {
        height: 100%;
        border-radius: 10px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        transition: width 0.6s ease;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(5deg); }
    }
    
    @keyframes countUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .count-animation {
        animation: countUp 0.8s ease-out;
    }
    
    .chart-container {
        position: relative;
        padding: 1rem;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 0.75rem;
        margin: 1rem 0;
    }
</style>
@endpush

@section('content')
<!-- Welcome Section -->
<div class="dashboard-welcome">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <h4 class="fw-bold mb-1">Welcome back, {{ auth()->guard('admin')->user()->name }}! 👋</h4>
            <p class="mb-0 opacity-75 small">Here's what's happening with your job portal today.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <div class="text-white opacity-75 small">
                <i class="fas fa-calendar me-2"></i>{{ now()->format('M j, Y') }}
            </div>
            <div class="text-white">
                <i class="fas fa-clock me-2"></i><span id="currentTime"></span>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="enhanced-stats-card primary">
            <div class="stats-icon primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="enhanced-stats-number primary count-animation" data-target="{{ $stats['total_users'] }}">0</div>
            <div class="text-muted fw-semibold">Total Users</div>
            <div class="mt-2">
                <span class="metric-badge">
                    <i class="fas fa-arrow-up me-1"></i>+12.5%
                </span>
                <span class="text-muted ms-2 small">vs last month</span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="enhanced-stats-card success">
            <div class="stats-icon success">
                <i class="fas fa-building"></i>
            </div>
            <div class="enhanced-stats-number success count-animation" data-target="{{ $stats['total_companies'] }}">0</div>
            <div class="text-muted fw-semibold">Companies</div>
            <div class="mt-2">
                <span class="metric-badge" style="background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);">
                    <i class="fas fa-arrow-up me-1"></i>+8.3%
                </span>
                <span class="text-muted ms-2 small">vs last month</span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="enhanced-stats-card warning">
            <div class="stats-icon warning">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="enhanced-stats-number warning count-animation" data-target="{{ $stats['active_jobs'] }}">0</div>
            <div class="text-muted fw-semibold">Active Jobs</div>
            <div class="mt-2">
                <span class="metric-badge" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="fas fa-arrow-up me-1"></i>+15.7%
                </span>
                <span class="text-muted ms-2 small">vs last month</span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="enhanced-stats-card info">
            <div class="stats-icon info">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="enhanced-stats-number info count-animation" data-target="{{ $stats['total_applications'] }}">0</div>
            <div class="text-muted fw-semibold">Applications</div>
            <div class="mt-2">
                <span class="metric-badge" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="fas fa-arrow-up me-1"></i>+22.1%
                </span>
                <span class="text-muted ms-2 small">vs last month</span>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="enhanced-card">
            <div class="card-header-enhanced">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-bolt text-primary me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body" style="padding: 1.5rem;">
                <div class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <div class="quick-action-card text-center p-4 h-100 border rounded-3 bg-white shadow-sm">
                            <div class="quick-action-icon mb-3">
                                <i class="fas fa-users fa-3x text-primary"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Manage Users</h6>
                            <p class="text-muted small mb-3">View & edit user accounts</p>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm px-4">
                                <i class="fas fa-arrow-right me-1"></i>Access
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="quick-action-card text-center p-4 h-100 border rounded-3 bg-white shadow-sm">
                            <div class="quick-action-icon mb-3">
                                <i class="fas fa-briefcase fa-3x text-success"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Job Moderation</h6>
                            <p class="text-muted small mb-3">Review job postings</p>
                            <a href="{{ route('admin.jobs.index') }}" class="btn btn-success btn-sm px-4">
                                <i class="fas fa-arrow-right me-1"></i>Access
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="quick-action-card text-center p-4 h-100 border rounded-3 bg-white shadow-sm">
                            <div class="quick-action-icon mb-3">
                                <i class="fas fa-chart-line fa-3x text-info"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Analytics</h6>
                            <p class="text-muted small mb-3">View detailed reports</p>
                            <a href="{{ route('admin.analytics.index') }}" class="btn btn-info btn-sm px-4">
                                <i class="fas fa-arrow-right me-1"></i>Access
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="quick-action-card text-center p-4 h-100 border rounded-3 bg-white shadow-sm">
                            <div class="quick-action-icon mb-3">
                                <i class="fas fa-cog fa-3x text-warning"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Settings</h6>
                            <p class="text-muted small mb-3">Configure system</p>
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-warning btn-sm px-4">
                                <i class="fas fa-arrow-right me-1"></i>Access
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Growth Chart -->
    <div class="col-xl-8 mb-4">
        <div class="enhanced-card">
            <div class="card-header-enhanced d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-chart-line text-primary me-2"></i>Platform Growth
                </h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-calendar me-1"></i>Last 12 Months
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-week me-2"></i>Last 6 Months</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-calendar me-2"></i>Last 12 Months</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-alt me-2"></i>Last Year</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body" style="padding: 1.5rem;">
                <div class="chart-container">
                    <canvas id="growthChart" style="height: 280px;"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats & System Health -->
    <div class="col-xl-4 mb-4 d-flex flex-column">
        <!-- Quick Overview -->
        <div class="enhanced-card mb-3 flex-fill">
            <div class="card-header-enhanced">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-tachometer-alt text-success me-2"></i>Quick Overview
                </h5>
            </div>
            <div class="card-body" style="padding: 1rem;">
                <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px;">
                            <i class="fas fa-user-tie text-white" style="font-size: 0.7rem;"></i>
                        </div>
                        <span class="fw-semibold small">Candidates</span>
                    </div>
                    <span class="fw-bold text-primary small">{{ number_format($stats['total_candidates']) }}</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px;">
                            <i class="fas fa-crown text-white" style="font-size: 0.7rem;"></i>
                        </div>
                        <span class="fw-semibold small">Active Subscriptions</span>
                    </div>
                    <span class="fw-bold text-success small">{{ number_format($stats['active_subscriptions']) }}</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-info d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px;">
                            <i class="fas fa-percentage text-white" style="font-size: 0.7rem;"></i>
                        </div>
                        <span class="fw-semibold small">Success Rate</span>
                    </div>
                    <span class="fw-bold text-info small">
                        {{ $stats['total_applications'] > 0 ? round(($stats['active_subscriptions'] / $stats['total_applications']) * 100, 1) : 0 }}%
                    </span>
                </div>
                
                <div class="progress-enhanced mb-2">
                    <div class="progress-bar-enhanced" style="width: {{ $stats['total_applications'] > 0 ? round(($stats['active_subscriptions'] / $stats['total_applications']) * 100, 1) : 0 }}%"></div>
                </div>
                
                <button class="btn w-100 py-1 btn-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;" onclick="refreshStats()">
                    <i class="fas fa-sync-alt me-2"></i>Refresh Data
                </button>
            </div>
        </div>
        
        <!-- System Health -->
        <div class="enhanced-card flex-fill">
            <div class="card-header-enhanced">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-heartbeat text-danger me-2"></i>System Health
                </h5>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center" id="systemHealth" style="padding: 1rem; min-height: 120px;">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mt-2 mb-0 small">Loading system metrics...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Recent Users -->
    <div class="col-xl-4 mb-4 d-flex">
        <div class="enhanced-card flex-fill">
            <div class="card-header-enhanced d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-user-plus text-primary me-2"></i>Recent Users
                </h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye me-1"></i>View All
                </a>
            </div>
            <div class="card-body" style="padding: 1.25rem; min-height: 350px; max-height: 350px; overflow-y: auto;">
                @forelse($recentUsers as $user)
                    <div class="activity-item">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <span class="text-white fw-bold small">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold text-dark small">{{ $user->name }}</div>
                                <div class="d-flex align-items-center mt-1">
                                    <span class="badge bg-{{ $user->role === 'company' ? 'info' : 'success' }} me-2" style="font-size: 0.6rem;">
                                        <i class="fas fa-{{ $user->role === 'company' ? 'building' : 'user' }} me-1"></i>
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'secondary' }} rounded-pill" style="font-size: 0.6rem;">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 d-flex flex-column justify-content-center align-items-center" style="height: 300px;">
                        <i class="fas fa-users fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No recent users</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Recent Jobs -->
    <div class="col-xl-4 mb-4 d-flex">
        <div class="enhanced-card flex-fill">
            <div class="card-header-enhanced d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-briefcase text-success me-2"></i>Recent Jobs
                </h5>
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-sm btn-outline-success">
                    <i class="fas fa-eye me-1"></i>View All
                </a>
            </div>
            <div class="card-body" style="padding: 1.25rem; min-height: 350px; max-height: 350px; overflow-y: auto;">
                @forelse($recentJobs as $job)
                    <div class="activity-item">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 35px; height: 35px; background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);">
                                <i class="fas fa-briefcase text-white" style="font-size: 0.7rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold text-dark small">{{ Str::limit($job->title, 25) }}</div>
                                <div class="d-flex align-items-center mt-1">
                                    <span class="badge bg-light text-dark me-2" style="font-size: 0.6rem;">
                                        <i class="fas fa-building me-1"></i>
                                        {{ Str::limit($job->company->company_name ?? $job->company->user->name, 15) }}
                                    </span>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $job->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <span class="badge bg-{{ $job->status === 'active' ? 'success' : ($job->status === 'draft' ? 'warning' : 'secondary') }} rounded-pill" style="font-size: 0.6rem;">
                                {{ ucfirst($job->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 d-flex flex-column justify-content-center align-items-center" style="height: 300px;">
                        <i class="fas fa-briefcase fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No recent jobs</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Recent Applications -->
    <div class="col-xl-4 mb-4 d-flex">
        <div class="enhanced-card flex-fill">
            <div class="card-header-enhanced d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-file-alt text-info me-2"></i>Recent Applications
                </h5>
                <a href="#" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-eye me-1"></i>View All
                </a>
            </div>
            <div class="card-body" style="padding: 1.25rem; min-height: 350px; max-height: 350px; overflow-y: auto;">
                @forelse($recentApplications as $application)
                    <div class="activity-item">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 35px; height: 35px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <span class="text-white fw-bold small">{{ substr($application->candidate->user->name ?? 'U', 0, 1) }}</span>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold text-dark small">{{ $application->candidate->user->name ?? 'Unknown' }}</div>
                                <div class="d-flex align-items-center mt-1">
                                    <span class="badge bg-light text-dark me-2" style="font-size: 0.6rem;">
                                        @if($application->job)
                                            <i class="fas fa-briefcase me-1"></i>
                                            {{ Str::limit($application->job->title, 15) }}
                                        @elseif($application->project)
                                            <i class="fas fa-project-diagram me-1"></i>
                                            {{ Str::limit($application->project->title, 15) }}
                                        @else
                                            <i class="fas fa-question me-1"></i>
                                            N/A
                                        @endif
                                    </span>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $application->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <span class="badge bg-{{ $application->status === 'applied' ? 'warning' : ($application->status === 'selected' ? 'success' : 'secondary') }} rounded-pill" style="font-size: 0.6rem;">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 d-flex flex-column justify-content-center align-items-center" style="height: 300px;">
                        <i class="fas fa-file-alt fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No recent applications</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Popular Skills & Industries -->
<div class="row mb-4">
    <div class="col-xl-6 mb-4">
        <div class="enhanced-card">
            <div class="card-header-enhanced">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-star text-warning me-2"></i>Popular Skills
                </h5>
            </div>
            <div class="card-body" style="padding: 2rem;">
                <div class="chart-container">
                    <canvas id="skillsChart" style="height: 250px;"></canvas>
                </div>
                <div class="text-center mt-3">
                    <small class="text-muted">Top 10 most demanded skills in job postings</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6 mb-4">
        <div class="enhanced-card">
            <div class="card-header-enhanced">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-industry text-info me-2"></i>Industry Distribution
                </h5>
            </div>
            <div class="card-body" style="padding: 2rem;">
                <div class="chart-container">
                    <canvas id="industryChart" style="height: 250px;"></canvas>
                </div>
                <div class="text-center mt-3">
                    <small class="text-muted">Companies registered by industry sectors</small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Current time display
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { 
            hour12: true, 
            hour: '2-digit', 
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('currentTime').textContent = timeString;
    }
    updateTime();
    setInterval(updateTime, 1000);

    // Animated counter function
    function animateCounters() {
        const counters = document.querySelectorAll('[data-target]');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 2000; // 2 seconds
            const step = target / (duration / 16); // 60fps
            let current = 0;
            
            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    counter.textContent = target.toLocaleString();
                    clearInterval(timer);
                } else {
                    counter.textContent = Math.floor(current).toLocaleString();
                }
            }, 16);
        });
    }

    // Start counter animation after a short delay
    setTimeout(animateCounters, 500);

    // Enhanced Growth Chart
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
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }, {
                label: 'Jobs',
                data: monthlyStats.map(stat => stat.jobs),
                borderColor: '#56ab2f',
                backgroundColor: 'rgba(86, 171, 47, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#56ab2f',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }, {
                label: 'Applications',
                data: monthlyStats.map(stat => stat.applications),
                borderColor: '#f093fb',
                backgroundColor: 'rgba(240, 147, 251, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#f093fb',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    cornerRadius: 10,
                    displayColors: true
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });

    // Enhanced Skills Chart
    const skillsCtx = document.getElementById('skillsChart').getContext('2d');
    const popularSkills = @json($popularSkills);

    new Chart(skillsCtx, {
        type: 'doughnut',
        data: {
            labels: popularSkills.map(skill => skill.name),
            datasets: [{
                data: popularSkills.map(skill => skill.count),
                backgroundColor: [
                    '#667eea', '#56ab2f', '#f093fb', '#4facfe', '#ff416c',
                    '#ffc107', '#17a2b8', '#6c757d', '#fd7e14', '#e83e8c'
                ],
                borderWidth: 3,
                borderColor: '#ffffff',
                hoverBorderWidth: 5,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    cornerRadius: 10
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 2000
            }
        }
    });

    // Enhanced Industry Chart
    const industryCtx = document.getElementById('industryChart').getContext('2d');
    const industryStats = @json($industryStats);

    new Chart(industryCtx, {
        type: 'bar',
        data: {
            labels: industryStats.map(industry => industry.name),
            datasets: [{
                label: 'Companies',
                data: industryStats.map(industry => industry.count),
                backgroundColor: industryStats.map((_, index) => {
                    const colors = [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(86, 171, 47, 0.8)',
                        'rgba(240, 147, 251, 0.8)',
                        'rgba(79, 172, 254, 0.8)',
                        'rgba(255, 65, 108, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(23, 162, 184, 0.8)',
                        'rgba(108, 117, 125, 0.8)'
                    ];
                    return colors[index % colors.length];
                }),
                borderColor: industryStats.map((_, index) => {
                    const colors = [
                        '#667eea', '#56ab2f', '#f093fb', '#4facfe',
                        '#ff416c', '#ffc107', '#17a2b8', '#6c757d'
                    ];
                    return colors[index % colors.length];
                }),
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    cornerRadius: 10
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 45,
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutBounce'
            }
        }
    });

    // Enhanced system health loader
    function loadSystemHealth() {
        fetch('{{ route("admin.system.overview") }}')
            .then(response => response.json())
            .then(data => {
                const healthDiv = document.getElementById('systemHealth');
                healthDiv.innerHTML = `
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                    <i class="fas fa-database text-white"></i>
                                </div>
                                <small class="text-muted fw-semibold">Database</small>
                            </div>
                            <div class="fw-bold text-primary">${data.database_size}</div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <div class="rounded-circle bg-info d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                    <i class="fas fa-hdd text-white"></i>
                                </div>
                                <small class="text-muted fw-semibold">Storage</small>
                            </div>
                            <div class="fw-bold text-info">${data.storage_usage}</div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <div class="rounded-circle bg-${data.cache_status === 'Working' ? 'success' : 'danger'} d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                    <i class="fas fa-memory text-white"></i>
                                </div>
                                <small class="text-muted fw-semibold">Cache</small>
                            </div>
                            <div class="fw-bold text-${data.cache_status === 'Working' ? 'success' : 'danger'}">${data.cache_status}</div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                    <i class="fas fa-tasks text-white"></i>
                                </div>
                                <small class="text-muted fw-semibold">Queue</small>
                            </div>
                            <div class="fw-bold text-warning">${data.queue_status}</div>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                document.getElementById('systemHealth').innerHTML = 
                    '<div class="text-center py-3"><i class="fas fa-exclamation-triangle text-danger fa-2x mb-2"></i><p class="text-danger">Failed to load system data</p></div>';
            });
    }

    // Load system health with delay for better UX
    setTimeout(loadSystemHealth, 1000);
});

function refreshStats() {
    // Add loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Refreshing...';
    button.disabled = true;
    
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}
</script>
@endpush
@endsection