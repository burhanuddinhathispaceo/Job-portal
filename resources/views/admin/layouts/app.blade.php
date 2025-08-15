<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - Admin @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Admin Styles -->
    <style>
        .admin-sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
            transition: all 0.3s;
        }
        
        .admin-sidebar.collapsed {
            width: 70px;
        }
        
        .admin-content {
            margin-left: 250px;
            transition: all 0.3s;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        .admin-content.expanded {
            margin-left: 70px;
        }
        
        .sidebar-brand {
            padding: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-item {
            margin-bottom: 0.25rem;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin: 0 0.5rem;
            transition: all 0.3s;
        }
        
        .nav-link:hover,
        .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: white !important;
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 0.5rem;
        }
        
        .admin-header {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem 2rem;
            margin-bottom: 2rem;
        }
        
        .stats-card {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-left: 4px solid;
        }
        
        .stats-card.primary { border-left-color: #667eea; }
        .stats-card.success { border-left-color: #28a745; }
        .stats-card.warning { border-left-color: #ffc107; }
        .stats-card.danger { border-left-color: #dc3545; }
        .stats-card.info { border-left-color: #17a2b8; }
        
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .breadcrumb-admin {
            background: transparent;
            padding: 0;
            margin-bottom: 1rem;
        }
        
        .sidebar-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            padding: 0.5rem;
            border-radius: 0.25rem;
            transition: all 0.3s;
        }
        
        .sidebar-toggle:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-sidebar.show {
                transform: translateX(0);
            }
            
            .admin-content {
                margin-left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div id="admin-app">
        <!-- Sidebar -->
        <nav class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-brand">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-shield-alt text-white me-2"></i>
                        <span class="text-white fw-bold sidebar-text">Admin Panel</span>
                    </div>
                    <button class="sidebar-toggle d-md-none" onclick="toggleSidebar()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <div class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span class="sidebar-text">Dashboard</span>
                        </a>
                    </li>
                    
                    {{-- User Management --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                           href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users"></i>
                            <span class="sidebar-text">Users</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.companies.*') ? 'active' : '' }}" 
                           href="{{ route('admin.companies.index') }}">
                            <i class="fas fa-building"></i>
                            <span class="sidebar-text">Companies</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.candidates.*') ? 'active' : '' }}" 
                           href="{{ route('admin.candidates.index') }}">
                            <i class="fas fa-user-tie"></i>
                            <span class="sidebar-text">Candidates</span>
                        </a>
                    </li>
                    
                    {{-- Content Management --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}" 
                           href="{{ route('admin.jobs.index') }}">
                            <i class="fas fa-briefcase"></i>
                            <span class="sidebar-text">Jobs</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" 
                           href="{{ route('admin.projects.index') }}">
                            <i class="fas fa-project-diagram"></i>
                            <span class="sidebar-text">Projects</span>
                        </a>
                    </li>
                    
                    {{-- Subscription Management --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}" 
                           href="{{ route('admin.subscriptions.index') }}">
                            <i class="fas fa-credit-card"></i>
                            <span class="sidebar-text">Subscriptions</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}" 
                           href="{{ route('admin.plans.index') }}">
                            <i class="fas fa-tags"></i>
                            <span class="sidebar-text">Plans</span>
                        </a>
                    </li>
                    
                    {{-- Analytics & Reports --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}" 
                           href="{{ route('admin.analytics.index') }}">
                            <i class="fas fa-chart-bar"></i>
                            <span class="sidebar-text">Analytics</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" 
                           href="{{ route('admin.reports.index') }}">
                            <i class="fas fa-file-alt"></i>
                            <span class="sidebar-text">Reports</span>
                        </a>
                    </li>
                    
                    {{-- System Configuration --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" 
                           href="{{ route('admin.settings.index') }}">
                            <i class="fas fa-cog"></i>
                            <span class="sidebar-text">Settings</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.website.*') ? 'active' : '' }}" 
                           href="{{ route('admin.website.index') }}">
                            <i class="fas fa-palette"></i>
                            <span class="sidebar-text">Website</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="admin-content" id="adminContent">
            <!-- Header -->
            <div class="admin-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <button class="sidebar-toggle d-md-none me-3" onclick="toggleSidebar()">
                            <i class="fas fa-bars text-dark"></i>
                        </button>
                        
                        <button class="sidebar-toggle d-none d-md-block me-3" onclick="collapseSidebar()">
                            <i class="fas fa-bars text-dark"></i>
                        </button>
                        
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-admin">
                                @yield('breadcrumb')
                            </ol>
                        </nav>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle text-decoration-none" 
                                    type="button" data-bs-toggle="dropdown">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2" 
                                         style="width: 35px; height: 35px;">
                                        <span class="text-white fw-bold">
                                            {{ auth()->guard('admin')->user()->initials }}
                                        </span>
                                    </div>
                                    <span class="text-dark">{{ auth()->guard('admin')->user()->name }}</span>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><h6 class="dropdown-header">Admin Account</h6></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Admin Scripts -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            sidebar.classList.toggle('show');
        }
        
        function collapseSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const content = document.getElementById('adminContent');
            
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');
            
            // Hide/show sidebar text
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            sidebarTexts.forEach(text => {
                text.style.display = sidebar.classList.contains('collapsed') ? 'none' : 'inline';
            });
        }
        
        // Auto-hide mobile sidebar when clicking outside
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('adminSidebar');
            const toggleBtn = document.querySelector('.sidebar-toggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>