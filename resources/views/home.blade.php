@extends('layouts.app')

@section('title', 'Home')

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 100px 0;
        color: white;
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
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="1000,100 1000,0 0,100"/></svg>') no-repeat bottom;
        background-size: 100% 100px;
    }
    
    .search-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-top: -50px;
        position: relative;
        z-index: 10;
    }
    
    .feature-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        height: 100%;
        background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-size: 2rem;
    }
    
    .stats-section {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border-radius: 20px;
        padding: 60px 20px;
    }
    
    .stat-item {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .stat-number {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
    }
    
    .btn-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }
    
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 60px;
        color: #2c3e50;
    }
    
    .search-input {
        border-radius: 50px;
        border: 2px solid #e9ecef;
        padding: 15px 25px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .floating-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: -1;
    }
    
    .shape {
        position: absolute;
        opacity: 0.1;
        animation: float 6s ease-in-out infinite;
    }
    
    .shape:nth-child(1) {
        top: 10%;
        left: 10%;
        animation-delay: 0s;
    }
    
    .shape:nth-child(2) {
        top: 20%;
        right: 10%;
        animation-delay: 2s;
    }
    
    .shape:nth-child(3) {
        bottom: 20%;
        left: 20%;
        animation-delay: 4s;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(10deg); }
    }
    
    .testimonial-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        position: relative;
    }
    
    .testimonial-card::before {
        content: '"';
        position: absolute;
        top: -10px;
        left: 20px;
        font-size: 60px;
        color: #667eea;
        line-height: 1;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="floating-shapes">
        <div class="shape" style="width: 60px; height: 60px; background: white; border-radius: 50%;"></div>
        <div class="shape" style="width: 40px; height: 40px; background: white; border-radius: 50%;"></div>
        <div class="shape" style="width: 80px; height: 80px; background: white; border-radius: 50%;"></div>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-3 fw-bold mb-4">Find Your Dream Job Today</h1>
                <p class="lead mb-4 fs-5">Connect with top employers and discover opportunities that match your skills, passion, and career goals. Your next adventure starts here!</p>
                <div class="d-flex gap-3 flex-wrap">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg btn-custom text-white">
                            <i class="fas fa-rocket me-2"></i>Get Started Free
                        </a>
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-search me-2"></i>Browse Jobs
                        </a>
                    @else
                        <a href="{{ route('jobs.index') }}" class="btn btn-light btn-lg btn-custom text-white">
                            <i class="fas fa-briefcase me-2"></i>Explore Opportunities
                        </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300' fill='white' opacity='0.8'><rect x='50' y='100' width='300' height='150' rx='10' fill='white'/><circle cx='100' cy='140' r='20'/><rect x='140' y='130' width='150' height='8' rx='4'/><rect x='140' y='150' width='100' height='6' rx='3'/><rect x='80' y='180' width='200' height='6' rx='3'/><rect x='80' y='200' width='150' height='6' rx='3'/></svg>" 
                     alt="Job Portal Illustration" class="img-fluid" style="max-width: 400px;">
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<div class="container">
    <div class="search-card p-4 p-md-5">
        <h3 class="text-center mb-4 fw-bold">Start Your Job Search</h3>
        <form action="{{ route('jobs.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold text-muted">What job are you looking for?</label>
                    <input type="text" 
                           class="form-control search-input" 
                           name="search" 
                           placeholder="Job title, keywords, company..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted">Where?</label>
                    <input type="text" 
                           class="form-control search-input" 
                           name="location" 
                           placeholder="City, state, or remote..."
                           value="{{ request('location') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-custom btn-lg w-100 text-white">
                        <i class="fas fa-search me-2"></i>Find Jobs
                    </button>
                </div>
            </div>
        </form>
        <div class="text-center mt-3">
            <small class="text-muted">Over 10,000 jobs from top companies waiting for you</small>
        </div>
    </div>
</div>

<!-- Features Section -->
<section class="py-5 my-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Why Choose Our Platform?</h2>
            <p class="lead text-muted">Everything you need to find your perfect job or hire the best talent</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card card p-4 text-center">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="fw-bold mb-3">For Job Seekers</h5>
                    <p class="text-muted mb-4">Discover thousands of job opportunities, create a standout profile, and get hired by top companies worldwide.</p>
                    @guest
                        <a href="{{ route('register') }}?role=candidate" class="btn btn-outline-primary rounded-pill">
                            Join as Candidate
                        </a>
                    @endguest
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="feature-card card p-4 text-center">
                    <div class="feature-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h5 class="fw-bold mb-3">For Companies</h5>
                    <p class="text-muted mb-4">Post jobs, find qualified candidates, manage applications, and build your dream team with our powerful tools.</p>
                    @guest
                        <a href="{{ route('register') }}?role=company" class="btn btn-outline-primary rounded-pill">
                            Join as Employer
                        </a>
                    @endguest
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="feature-card card p-4 text-center">
                    <div class="feature-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Smart Matching</h5>
                    <p class="text-muted mb-4">Our AI-powered matching system connects the right candidates with the right opportunities for perfect fits.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5 my-5">
    <div class="container">
        <div class="stats-section">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Trusted by Thousands</h2>
                <p class="fs-5 opacity-75">Join our growing community of successful professionals</p>
            </div>
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number" data-count="12000">0</span>
                        <p class="mb-0">Active Jobs</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number" data-count="850">0</span>
                        <p class="mb-0">Companies</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number" data-count="45000">0</span>
                        <p class="mb-0">Candidates</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number" data-count="8500">0</span>
                        <p class="mb-0">Successful Hires</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 my-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">What Our Users Say</h2>
            <p class="lead text-muted">Success stories from our community</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="testimonial-card">
                    <p class="mb-4 text-muted">"I found my dream job within 2 weeks of joining. The platform made it so easy to connect with great companies!"</p>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <span class="text-white fw-bold">SA</span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Sarah Anderson</h6>
                            <small class="text-muted">Software Developer</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="testimonial-card">
                    <p class="mb-4 text-muted">"As an employer, this platform helped us find exceptional talent quickly. Highly recommend for any hiring needs!"</p>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <span class="text-white fw-bold">MJ</span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Michael Johnson</h6>
                            <small class="text-muted">HR Director</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="testimonial-card">
                    <p class="mb-4 text-muted">"The user interface is intuitive and the job matching is spot-on. Found multiple opportunities that fit my skills perfectly."</p>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-info d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <span class="text-white fw-bold">EL</span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Emily Liu</h6>
                            <small class="text-muted">Marketing Manager</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 my-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row align-items-center text-white">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3">Ready to Start Your Journey?</h2>
                <p class="fs-5 mb-0 opacity-75">Join thousands of successful professionals who found their dream careers with us.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                @guest
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg rounded-pill px-4">
                        <i class="fas fa-rocket me-2"></i>Get Started Now
                    </a>
                @else
                    <a href="{{ route('jobs.index') }}" class="btn btn-light btn-lg rounded-pill px-4">
                        <i class="fas fa-search me-2"></i>Find Your Next Role
                    </a>
                @endguest
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate counter numbers
    const counters = document.querySelectorAll('[data-count]');
    const speed = 1000; // Animation duration
    
    counters.forEach(counter => {
        const target = parseInt(counter.dataset.count);
        const increment = target / speed * 16; // 60fps
        
        const updateCounter = () => {
            const count = parseInt(counter.innerText);
            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(updateCounter, 16);
            } else {
                counter.innerText = target.toLocaleString();
            }
        };
        
        // Start animation when element is in view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        observer.observe(counter);
    });
    
    // Add smooth scrolling to anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});
</script>
@endpush
@endsection