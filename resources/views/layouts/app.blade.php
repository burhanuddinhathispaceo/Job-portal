<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Job Portal') }} - @yield('title', 'Home')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary fs-3" href="{{ route('home') }}">
                    <i class="fas fa-briefcase me-2"></i>{{ config('app.name', 'Job Portal') }}
                </a>
                
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link fw-semibold px-3" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold px-3" href="{{ route('jobs.index') }}">Find Jobs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold px-3" href="#">Companies</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold px-3" href="#">About</a>
                        </li>
                    </ul>
                    
                    <ul class="navbar-nav">
                        @guest
                            <li class="nav-item me-2">
                                <a class="nav-link fw-semibold" href="{{ route('login') }}">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary rounded-pill px-4" href="{{ route('register') }}">
                                    Get Started
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                        <span class="text-white fw-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    @if(Auth::user()->hasRole('admin'))
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                                        </a></li>
                                    @elseif(Auth::user()->hasRole('company'))
                                        <li><a class="dropdown-item" href="{{ route('company.dashboard') }}">
                                            <i class="fas fa-building me-2"></i>Company Dashboard
                                        </a></li>
                                        <li><a class="dropdown-item" href="{{ route('company.profile') }}">
                                            <i class="fas fa-user me-2"></i>Profile
                                        </a></li>
                                    @elseif(Auth::user()->hasRole('candidate'))
                                        <li><a class="dropdown-item" href="{{ route('candidate.dashboard') }}">
                                            <i class="fas fa-user-circle me-2"></i>Candidate Dashboard
                                        </a></li>
                                        <li><a class="dropdown-item" href="{{ route('candidate.profile') }}">
                                            <i class="fas fa-user-edit me-2"></i>Profile
                                        </a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="{{ Request::route()->getName() === 'home' ? '' : 'py-4' }}">
            @if(session('success'))
                <div class="container">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="container">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-light mt-5 py-4">
            <div class="container text-center">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Job Portal') }}. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>