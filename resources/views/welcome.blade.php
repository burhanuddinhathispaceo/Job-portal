<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Job Portal - Find Your Dream Job</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 600px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .search-box {
            background: white;
            border-radius: 60px;
            padding: 10px 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        }
        
        .search-box input {
            border: none;
            outline: none;
            font-size: 16px;
            padding: 15px;
        }
        
        .search-box button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50px;
            padding: 15px 40px;
            color: white;
            font-weight: 600;
            transition: transform 0.3s;
        }
        
        .search-box button:hover {
            transform: scale(1.05);
        }
        
        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .stat-card .icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #718096;
            font-size: 14px;
            font-weight: 500;
        }
        
        /* Category Cards */
        .category-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            border: 2px solid #f7fafc;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .category-card:hover {
            border-color: #667eea;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.15);
        }
        
        .category-card .icon {
            width: 50px;
            height: 50px;
            margin: 0 auto 15px;
            background: linear-gradient(135deg, #667eea20 0%, #764ba220 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
            font-size: 20px;
        }
        
        /* Job Cards */
        .job-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
            margin-bottom: 20px;
        }
        
        .job-card:hover {
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transform: translateY(-3px);
        }
        
        .company-logo {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
            background: #f7fafc;
        }
        
        .job-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-remote {
            background: #e6fffa;
            color: #047481;
        }
        
        .badge-fulltime {
            background: #f0fff4;
            color: #22543d;
        }
        
        .badge-featured {
            background: linear-gradient(135deg, #667eea20 0%, #764ba220 100%);
            color: #667eea;
        }
        
        /* Company Cards */
        .company-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }
        
        .company-card:hover {
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transform: translateY(-3px);
        }
        
        .company-card img {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            margin-bottom: 15px;
            object-fit: cover;
        }
        
        /* Navigation */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .nav-link {
            color: #4a5568;
            font-weight: 500;
            margin: 0 15px;
            transition: color 0.3s;
        }
        
        .nav-link:hover {
            color: #667eea;
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            transition: transform 0.3s;
        }
        
        .btn-gradient:hover {
            transform: scale(1.05);
            color: white;
        }
        
        /* Section Titles */
        .section-title {
            font-size: 36px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 15px;
        }
        
        .section-subtitle {
            color: #718096;
            font-size: 18px;
            margin-bottom: 40px;
        }
        
        /* Footer */
        footer {
            background: #1a202c;
            color: white;
            padding: 50px 0 30px;
        }
        
        footer h5 {
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        footer a {
            color: #cbd5e0;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        footer a:hover {
            color: #667eea;
        }
        
        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-briefcase me-2"></i>JobPortal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#jobs">Find Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#companies">Companies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#categories">Categories</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-gradient ms-3" href="{{ route('register') }}">Sign Up</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-gradient ms-3" href="/home">Dashboard</a>
                        </li>
                    @endguest
                    <li class="nav-item">
                        <a class="btn btn-outline-primary ms-2" href="{{ route('admin.login') }}">Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center" style="margin-top: 76px;">
        <div class="container hero-content">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <h1 class="display-4 fw-bold mb-4">Find Your Dream Job Today</h1>
                    <p class="lead mb-5 opacity-90">Connect with top companies and discover opportunities that match your skills and aspirations</p>
                    
                    <!-- Search Box -->
                    <div class="search-box d-flex align-items-center">
                        <div class="flex-grow-1 d-flex align-items-center">
                            <i class="fas fa-search text-muted me-3"></i>
                            <input type="text" placeholder="Job title, keywords, or company" class="flex-grow-1">
                        </div>
                        <div class="d-flex align-items-center me-3">
                            <i class="fas fa-map-marker-alt text-muted me-3"></i>
                            <input type="text" placeholder="City or location" style="width: 200px;">
                        </div>
                        <button class="btn">
                            <i class="fas fa-search me-2"></i>Search Jobs
                        </button>
                    </div>
                    
                    <div class="mt-4">
                        <span class="text-white-50">Popular searches:</span>
                        <span class="badge bg-white bg-opacity-25 text-white ms-2 px-3 py-2">Remote</span>
                        <span class="badge bg-white bg-opacity-25 text-white ms-2 px-3 py-2">Full-time</span>
                        <span class="badge bg-white bg-opacity-25 text-white ms-2 px-3 py-2">Developer</span>
                        <span class="badge bg-white bg-opacity-25 text-white ms-2 px-3 py-2">Marketing</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="stat-number">{{ number_format($stats['total_jobs']) }}</div>
                        <div class="stat-label">Active Jobs</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="stat-number">{{ number_format($stats['total_companies']) }}</div>
                        <div class="stat-label">Trusted Companies</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number">{{ number_format($stats['total_candidates']) }}</div>
                        <div class="stat-label">Job Seekers</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-number">{{ number_format($stats['total_applications']) }}</div>
                        <div class="stat-label">Applications Sent</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Job Categories -->
    <section class="py-5" id="categories">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Popular Job Categories</h2>
                <p class="section-subtitle">Explore opportunities across various industries</p>
            </div>
            
            <div class="row g-4">
                @foreach($jobCategories as $category)
                <div class="col-md-4 col-lg-2">
                    <div class="category-card">
                        <div class="icon">
                            <i class="fas fa-{{ $category['icon'] }}"></i>
                        </div>
                        <h6 class="fw-semibold mb-2">{{ $category['name'] }}</h6>
                        <p class="text-muted small mb-0">{{ $category['count'] }} Jobs</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Recent Jobs -->
    <section class="py-5 bg-light" id="jobs">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Latest Job Openings</h2>
                <p class="section-subtitle">Discover your next career opportunity</p>
            </div>
            
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    @forelse($recentJobs as $job)
                    <div class="job-card">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                @if($job->company->logo)
                                    <img src="{{ asset($job->company->logo) }}" class="company-logo">
                                @else
                                    <div class="company-logo d-flex align-items-center justify-content-center bg-light">
                                        <i class="fas fa-building text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <h5 class="mb-1 fw-semibold">{{ $job->title }}</h5>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-building me-1"></i>{{ $job->company->company_name }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location ?? 'Remote' }}
                                </p>
                                <div>
                                    @if($job->is_remote)
                                        <span class="job-badge badge-remote">Remote</span>
                                    @endif
                                    <span class="job-badge badge-fulltime ms-2">Full-time</span>
                                    @if($job->visibility == 'featured')
                                        <span class="job-badge badge-featured ms-2">
                                            <i class="fas fa-star me-1"></i>Featured
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="text-end">
                                    <div class="fw-semibold text-primary mb-1">
                                        ${{ number_format($job->salary_min ?? 0) }} - ${{ number_format($job->salary_max ?? 0) }}
                                    </div>
                                    <div class="text-muted small">{{ $job->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No jobs available at the moment</p>
                    </div>
                    @endforelse
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('jobs.index') }}" class="btn btn-gradient btn-lg">
                            View All Jobs <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Companies -->
    <section class="py-5" id="companies">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Top Hiring Companies</h2>
                <p class="section-subtitle">Join industry-leading companies</p>
            </div>
            
            <div class="row g-4">
                @forelse($featuredCompanies as $company)
                <div class="col-md-6 col-lg-3">
                    <div class="company-card">
                        @if($company->logo)
                            <img src="{{ asset($company->logo) }}" alt="{{ $company->company_name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light rounded" style="width: 80px; height: 80px; margin: 0 auto 15px;">
                                <i class="fas fa-building fa-2x text-muted"></i>
                            </div>
                        @endif
                        <h6 class="fw-semibold mb-2">{{ $company->company_name }}</h6>
                        <p class="text-muted small mb-3">{{ $company->industry->name ?? 'Technology' }}</p>
                        <div class="badge bg-primary bg-opacity-10 text-primary">
                            {{ $company->jobs_count }} Open Positions
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No companies available</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-gradient-primary text-white">
        <div class="container text-center">
            <h2 class="display-5 fw-bold mb-4">Ready to Take the Next Step?</h2>
            <p class="lead mb-5 opacity-90">Join thousands of professionals who found their dream job through our platform</p>
            <div>
                <a href="{{ route('register') }}" class="btn btn-white btn-lg me-3" style="background: white; color: #667eea; padding: 15px 40px; border-radius: 30px;">
                    <i class="fas fa-user-plus me-2"></i>Create Account
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg" style="padding: 15px 40px; border-radius: 30px;">
                    <i class="fas fa-briefcase me-2"></i>Post a Job
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5>
                        <i class="fas fa-briefcase me-2"></i>JobPortal
                    </h5>
                    <p class="text-muted">Your gateway to amazing career opportunities. Connect with top companies and find your dream job today.</p>
                    <div class="mt-3">
                        <a href="#" class="text-white-50 me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white-50 me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white-50 me-3"><i class="fab fa-linkedin fa-lg"></i></a>
                        <a href="#" class="text-white-50"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-semibold mb-3">For Job Seekers</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Browse Jobs</a></li>
                        <li class="mb-2"><a href="#">Career Advice</a></li>
                        <li class="mb-2"><a href="#">Resume Builder</a></li>
                        <li class="mb-2"><a href="#">Job Alerts</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-semibold mb-3">For Employers</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Post a Job</a></li>
                        <li class="mb-2"><a href="#">Browse Candidates</a></li>
                        <li class="mb-2"><a href="#">Pricing Plans</a></li>
                        <li class="mb-2"><a href="#">Recruitment Solutions</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-semibold mb-3">Company</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">About Us</a></li>
                        <li class="mb-2"><a href="#">Contact</a></li>
                        <li class="mb-2"><a href="#">Privacy Policy</a></li>
                        <li class="mb-2"><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-semibold mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Help Center</a></li>
                        <li class="mb-2"><a href="#">FAQs</a></li>
                        <li class="mb-2"><a href="#">Report an Issue</a></li>
                        <li class="mb-2"><a href="#">Feedback</a></li>
                    </ul>
                </div>
            </div>
            
            <hr class="border-secondary my-4">
            
            <div class="text-center text-white-50">
                <p class="mb-0">&copy; 2024 JobPortal. All rights reserved. Made with <i class="fas fa-heart text-danger"></i> by Your Team</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Animate numbers on scroll
        const animateNumbers = () => {
            const numbers = document.querySelectorAll('.stat-number');
            numbers.forEach(num => {
                const target = parseInt(num.innerText.replace(/,/g, ''));
                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        num.innerText = target.toLocaleString();
                        clearInterval(timer);
                    } else {
                        num.innerText = Math.floor(current).toLocaleString();
                    }
                }, 30);
            });
        };
        
        // Trigger animation when stats section is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateNumbers();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        const statsSection = document.querySelector('.stat-card');
        if (statsSection) {
            observer.observe(statsSection);
        }
    </script>
</body>
</html>