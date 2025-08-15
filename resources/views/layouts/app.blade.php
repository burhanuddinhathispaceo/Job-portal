<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Job Portal') }} - @yield('title', 'Home')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Dynamic Theme Loading -->
    @php
        $theme = \App\Models\WebsiteSetting::getValue('theme', 'light');
        $primaryColor = \App\Models\WebsiteSetting::getValue('primary_color', '#667eea');
        $secondaryColor = \App\Models\WebsiteSetting::getValue('secondary_color', '#764ba2');
    @endphp
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        :root {
            --primary-color: {{ $primaryColor }};
            --secondary-color: {{ $secondaryColor }};
            --gradient: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);
        }
        
        @if($theme === 'dark')
        body {
            background-color: #1a1a1a;
            color: #ffffff;
        }
        
        .navbar {
            background-color: #2d3748 !important;
            border-bottom: 1px solid #4a5568;
        }
        
        .navbar-brand {
            color: #ffffff !important;
        }
        
        .nav-link {
            color: #e2e8f0 !important;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        .dropdown-menu {
            background-color: #4a5568;
            border: 1px solid #718096;
        }
        
        .dropdown-item {
            color: #e2e8f0;
        }
        
        .dropdown-item:hover {
            background-color: #718096;
            color: #ffffff;
        }
        
        footer {
            background-color: #2d3748 !important;
            color: #e2e8f0;
            border-top: 1px solid #4a5568;
        }
        @endif
        
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 15px 0;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: all 0.3s ease;
        }
        
        .nav-link {
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s;
            position: relative;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 50%;
            background: var(--gradient);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 80%;
        }
        
        .btn-primary {
            background: var(--gradient);
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            transition: transform 0.3s;
        }
        
        .btn-primary:hover {
            transform: scale(1.05);
        }
        
        .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
        }
    </style>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg fixed-top {{ $theme === 'dark' ? 'navbar-dark' : 'navbar-light bg-white' }}">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-briefcase me-2"></i>JobPortal
                </a>
                
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('jobs.index') }}">Find Jobs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Companies</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Categories</a>
                        </li>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary ms-3" href="{{ route('register') }}">Sign Up</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="btn btn-primary ms-3" href="/home">Dashboard</a>
                            </li>
                        @endguest
                        <li class="nav-item">
                            <a class="btn btn-outline-primary ms-2" href="{{ route('admin.login') }}">Admin</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main style="margin-top: 76px;">
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
        <footer class="{{ $theme === 'dark' ? 'bg-dark' : 'bg-light' }} mt-5 py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <h5>
                            <i class="fas fa-briefcase me-2"></i>JobPortal
                        </h5>
                        <p class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }}">Your gateway to amazing career opportunities. Connect with top companies and find your dream job today.</p>
                        <div class="mt-3">
                            <a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} me-3"><i class="fab fa-facebook fa-lg"></i></a>
                            <a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} me-3"><i class="fab fa-twitter fa-lg"></i></a>
                            <a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} me-3"><i class="fab fa-linkedin fa-lg"></i></a>
                            <a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }}"><i class="fab fa-instagram fa-lg"></i></a>
                        </div>
                    </div>
                    
                    <div class="col-lg-2 col-md-6 mb-4">
                        <h6 class="fw-semibold mb-3">For Job Seekers</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="{{ route('jobs.index') }}" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">Browse Jobs</a></li>
                            <li class="mb-2"><a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">Career Advice</a></li>
                            <li class="mb-2"><a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">Resume Builder</a></li>
                            <li class="mb-2"><a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">Job Alerts</a></li>
                        </ul>
                    </div>
                    
                    <div class="col-lg-2 col-md-6 mb-4">
                        <h6 class="fw-semibold mb-3">For Employers</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">Post a Job</a></li>
                            <li class="mb-2"><a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">Browse Candidates</a></li>
                            <li class="mb-2"><a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">Pricing Plans</a></li>
                            <li class="mb-2"><a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">Recruitment Solutions</a></li>
                        </ul>
                    </div>
                    
                    <div class="col-lg-2 col-md-6 mb-4">
                        <h6 class="fw-semibold mb-3">Company</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">About Us</a></li>
                            <li class="mb-2"><a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">Contact</a></li>
                            <li class="mb-2"><a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">Privacy Policy</a></li>
                            <li class="mb-2"><a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">Terms of Service</a></li>
                        </ul>
                    </div>
                    
                    <div class="col-lg-2 col-md-6 mb-4">
                        <h6 class="fw-semibold mb-3">Support</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">Help Center</a></li>
                            <li class="mb-2"><a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">FAQs</a></li>
                            <li class="mb-2"><a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">Report an Issue</a></li>
                            <li class="mb-2"><a href="#" class="{{ $theme === 'dark' ? 'text-light' : 'text-muted' }} text-decoration-none">Feedback</a></li>
                        </ul>
                    </div>
                </div>
                
                <hr class="{{ $theme === 'dark' ? 'border-secondary' : 'border-light' }} my-4">
                
                <div class="text-center {{ $theme === 'dark' ? 'text-light' : 'text-muted' }}">
                    <p class="mb-0">&copy; {{ date('Y') }} JobPortal. All rights reserved. Made with <i class="fas fa-heart text-danger"></i> by Your Team</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
