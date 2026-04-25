{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'EduCore') }} - Complete Education Management Platform</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4e73df;
            --primary-dark: #224abe;
            --secondary: #858796;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --dark: #5a5c69;
        }
        
        body {
            font-family: 'Nunito', 'Segoe UI', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        /* Navbar Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .navbar-brand i {
            background: none;
            -webkit-background-clip: unset;
            background-clip: unset;
            color: #667eea;
        }
        
        .nav-link {
            font-weight: 600;
            color: #4a5568 !important;
            transition: all 0.3s;
            margin: 0 0.5rem;
        }
        
        .nav-link:hover {
            color: #667eea !important;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white !important;
        }
        
        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 80px;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.3;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, #e0d4ff 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 1.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            color: rgba(255,255,255,0.9);
            margin-bottom: 2rem;
            line-height: 1.8;
        }
        
        .btn-hero {
            background: white;
            color: #667eea;
            border-radius: 50px;
            padding: 0.8rem 2rem;
            font-weight: 700;
            transition: all 0.3s;
            margin-right: 1rem;
        }
        
        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            color: #764ba2;
        }
        
        .btn-hero-outline {
            background: transparent;
            border: 2px solid white;
            color: white;
            border-radius: 50px;
            padding: 0.8rem 2rem;
            font-weight: 700;
            transition: all 0.3s;
        }
        
        .btn-hero-outline:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }
        
        /* Feature Cards */
        .features {
            padding: 80px 0;
            background: #f8f9fc;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .section-subtitle {
            color: #858796;
            margin-bottom: 3rem;
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
            height: 100%;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.15);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        
        .feature-icon i {
            font-size: 2.5rem;
            color: white;
        }
        
        .feature-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #2d3748;
        }
        
        .feature-desc {
            color: #718096;
            line-height: 1.6;
        }
        
        /* Stats Section */
        .stats {
            padding: 60px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }
        
        /* Modules Section */
        .modules {
            padding: 80px 0;
            background: white;
        }
        
        .module-card {
            background: #f8f9fc;
            border-radius: 15px;
            padding: 1.5rem;
            transition: all 0.3s;
            height: 100%;
            cursor: pointer;
        }
        
        .module-card:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-5px);
        }
        
        .module-card:hover .module-icon i,
        .module-card:hover .module-title,
        .module-card:hover .module-desc {
            color: white;
        }
        
        .module-icon i {
            font-size: 2rem;
            color: #667eea;
            margin-bottom: 1rem;
        }
        
        .module-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #2d3748;
        }
        
        .module-desc {
            font-size: 0.85rem;
            color: #718096;
        }
        
        /* Testimonials */
        .testimonials {
            padding: 80px 0;
            background: #f8f9fc;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            height: 100%;
        }
        
        .testimonial-text {
            font-size: 1rem;
            line-height: 1.8;
            color: #4a5568;
            margin-bottom: 1.5rem;
            font-style: italic;
        }
        
        .testimonial-author {
            font-weight: 700;
            color: #2d3748;
        }
        
        .testimonial-role {
            font-size: 0.85rem;
            color: #718096;
        }
        
        /* CTA Section */
        .cta {
            padding: 80px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
        }
        
        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }
        
        .cta-btn {
            background: white;
            color: #667eea;
            border-radius: 50px;
            padding: 0.8rem 2.5rem;
            font-weight: 700;
            transition: all 0.3s;
            margin-top: 2rem;
        }
        
        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        /* Footer */
        .footer {
            background: #1a202c;
            color: #a0aec0;
            padding: 60px 0 20px;
        }
        
        .footer-title {
            color: white;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .footer-link {
            color: #a0aec0;
            text-decoration: none;
            display: block;
            margin-bottom: 0.75rem;
            transition: color 0.3s;
        }
        
        .footer-link:hover {
            color: #667eea;
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
            transition: all 0.3s;
        }
        
        .social-icon:hover {
            background: #667eea;
            transform: translateY(-3px);
        }
        
        .social-icon i {
            color: white;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            .feature-card {
                margin-bottom: 1rem;
            }
        }
        
        /* Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-mortarboard-fill me-2"></i>\n                EduCore
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#modules">Modules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                @if (Route::has('login'))
                    <div class="ms-lg-3 mt-3 mt-lg-0">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-login">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-login">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-primary ms-2" style="border-radius: 50px;">
                                    <i class="bi bi-person-plus me-1"></i> Register
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-7" data-aos="fade-right">
                    <h1 class="hero-title">
                        Complete School Management <br>
                        <span style="color: #ffd700;">Solution</span> for Modern Education
                    </h1>
                    <p class="hero-subtitle">
                        Streamline administration, enhance learning experience, and connect 
                        teachers, students, and parents in one powerful platform.
                    </p>
                    <div>
                        <a href="{{ route('register') }}" class="btn btn-hero">
                            <i class="bi bi-rocket-takeoff me-2"></i> Get Started Free
                        </a>
                        <a href="#features" class="btn btn-hero-outline">
                            <i class="bi bi-play-circle me-2"></i> Watch Demo
                        </a>
                    </div>
                    <div class="mt-4">
                        <small class="text-white-50">
                            <i class="bi bi-check-circle-fill text-success me-1"></i> Free 30-day trial
                            <span class="mx-2">•</span>
                            <i class="bi bi-shield-check text-success me-1"></i> Secure & Reliable
                            <span class="mx-2">•</span>
                            <i class="bi bi-headset text-success me-1"></i> 24/7 Support
                        </small>
                    </div>
                </div>
                <div class="col-lg-5 text-center" data-aos="fade-left">
                    <div class="float-animation">
                        <img src="{{ asset('images/hero-illustration.svg') }}" alt="School Management" class="img-fluid" 
                             onerror="this.src='https://placehold.co/500x400/667eea/white?text=School+Management+System'">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4 mb-md-0" data-aos="zoom-in">
                    <div class="stat-number" id="statSchools">0</div>
                    <div class="stat-label">Schools Using SMS</div>
                </div>
                <div class="col-md-3 mb-4 mb-md-0" data-aos="zoom-in" data-aos-delay="100">
                    <div class="stat-number" id="statStudents">0</div>
                    <div class="stat-label">Active Students</div>
                </div>
                <div class="col-md-3 mb-4 mb-md-0" data-aos="zoom-in" data-aos-delay="200">
                    <div class="stat-number" id="statTeachers">0</div>
                    <div class="stat-label">Teachers Empowered</div>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
                    <div class="stat-number" id="statParents">0</div>
                    <div class="stat-label">Connected Parents</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <div class="text-center" data-aos="fade-up">
                <h2 class="section-title">Powerful Features for Modern Schools</h2>
                <p class="section-subtitle">Everything you need to manage your educational institution efficiently</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h3 class="feature-title">Student Management</h3>
                        <p class="feature-desc">Complete student profiles, enrollment, attendance tracking, and academic history in one place.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>
                        <h3 class="feature-title">Teacher Management</h3>
                        <p class="feature-desc">Staff profiles, attendance, payroll, performance evaluation, and class assignments.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-journal-bookmark-fill"></i>
                        </div>
                        <h3 class="feature-title">Examination System</h3>
                        <p class="feature-desc">Online exams, automatic grading, result processing, and report card generation.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <h3 class="feature-title">Fee Management</h3>
                        <p class="feature-desc">Online fee collection, automatic invoicing, payment tracking, and financial reports.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                        <h3 class="feature-title">Attendance Tracking</h3>
                        <p class="feature-desc">Biometric integration, real-time attendance, and automated parent notifications.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h3 class="feature-title">Analytics & Reports</h3>
                        <p class="feature-desc">Comprehensive dashboards, performance analytics, and customizable reports.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modules Section -->
    <section id="modules" class="modules">
        <div class="container">
            <div class="text-center" data-aos="fade-up">
                <h2 class="section-title">40+ Integrated Modules</h2>
                <p class="section-subtitle">Complete ecosystem for educational institutions</p>
            </div>
            <div class="row g-3">
                @php
                    $modules = [
                        ['icon' => 'bi-person-vcard', 'name' => 'Student Info', 'desc' => 'Complete student profiles'],
                        ['icon' => 'bi-person-badge', 'name' => 'Staff Management', 'desc' => 'Teacher & staff records'],
                        ['icon' => 'bi-building', 'name' => 'Class Management', 'desc' => 'Classes & sections'],
                        ['icon' => 'bi-book', 'name' => 'Subject Management', 'desc' => 'Subjects & curriculum'],
                        ['icon' => 'bi-calendar-check', 'name' => 'Attendance', 'desc' => 'Daily attendance tracking'],
                        ['icon' => 'bi-file-text', 'name' => 'Examinations', 'desc' => 'Exam scheduling & results'],
                        ['icon' => 'bi-graph-up', 'name' => 'Results', 'desc' => 'Grade & report cards'],
                        ['icon' => 'bi-wallet2', 'name' => 'Fee Collection', 'desc' => 'Payment processing'],
                        ['icon' => 'bi-journal-bookmark-fill', 'name' => 'Library', 'desc' => 'Book management'],
                        ['icon' => 'bi-bus-front', 'name' => 'Transport', 'desc' => 'Bus route tracking'],
                        ['icon' => 'bi-house-door', 'name' => 'Hostel', 'desc' => 'Accommodation'],
                        ['icon' => 'bi-chat-dots', 'name' => 'Communication', 'desc' => 'Parent portal'],
                        ['icon' => 'bi-calendar-event', 'name' => 'Events', 'desc' => 'Event management'],
                        ['icon' => 'bi-box-seam', 'name' => 'Inventory', 'desc' => 'Asset tracking'],
                        ['icon' => 'bi-calculator', 'name' => 'Payroll', 'desc' => 'Staff salaries'],
                        ['icon' => 'bi-laptop', 'name' => 'Online Learning', 'desc' => 'Virtual classes'],
                    ];
                @endphp
                
                @foreach($modules as $index => $module)
                    <div class="col-lg-3 col-md-4 col-6" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                        <div class="module-card text-center">
                            <div class="module-icon">
                                <i class="{{ $module['icon'] }}"></i>
                            </div>
                            <h4 class="module-title">{{ $module['name'] }}</h4>
                            <p class="module-desc">{{ $module['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="testimonials">
        <div class="container">
            <div class="text-center" data-aos="fade-up">
                <h2 class="section-title">Trusted by Schools Worldwide</h2>
                <p class="section-subtitle">What educators say about our School Management System</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="testimonial-card">
                        <i class="bi bi-quote fs-1 text-primary opacity-25"></i>
                        <p class="testimonial-text">"This system has transformed how we manage our school. From student records to fee collection, everything is now streamlined and efficient."</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person-fill text-white fs-4"></i>
                            </div>
                            <div>
                                <div class="testimonial-author">Dr. Sarah Johnson</div>
                                <div class="testimonial-role">Principal, Excel Academy</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <i class="bi bi-quote fs-1 text-primary opacity-25"></i>
                        <p class="testimonial-text">"The parent portal has improved communication with parents significantly. Attendance and grade updates are now instant."</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person-fill text-white fs-4"></i>
                            </div>
                            <div>
                                <div class="testimonial-author">Michael Chen</div>
                                <div class="testimonial-role">IT Director, Global School</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <i class="bi bi-quote fs-1 text-primary opacity-25"></i>
                        <p class="testimonial-text">"Excellent support team and feature-rich platform. The exam module with automatic result calculation saved us countless hours."</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person-fill text-white fs-4"></i>
                            </div>
                            <div>
                                <div class="testimonial-author">Prof. Adebayo Ogunlesi</div>
                                <div class="testimonial-role">Vice Chancellor, Unity University</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <div data-aos="zoom-in">
                <h2 class="cta-title">Ready to Transform Your School?</h2>
                <p class="mb-4">Join thousands of schools that trust our management system</p>
                <a href="{{ route('register') }}" class="btn cta-btn">
                    <i class="bi bi-calendar-check me-2"></i> Start Free Trial
                </a>
                <p class="mt-3 small">No credit card required | Free 30-day trial</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h4 class="footer-title">\n                        <i class="bi bi-mortarboard-fill me-2"></i> EduCore
                    </h4>
                    <p>Complete School Management System for modern educational institutions. Streamline operations, enhance learning, and connect stakeholders.</p>
                    <div>
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="footer-title">Quick Links</h5>
                    <a href="#home" class="footer-link">Dashboard</a>
                    <a href="#features" class="footer-link">Features</a>
                    <a href="#modules" class="footer-link">Modules</a>
                    <a href="#testimonials" class="footer-link">Testimonials</a>
                </div>
                <div class="col-lg-3 col-md-4 mb-4 mb-md-0">
                    <h5 class="footer-title">Support</h5>
                    <a href="#" class="footer-link">Help Center</a>
                    <a href="#" class="footer-link">Documentation</a>
                    <a href="#" class="footer-link">API Reference</a>
                    <a href="#" class="footer-link">Privacy Policy</a>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5 class="footer-title">Contact Us</h5>
                    <p><i class="bi bi-envelope me-2"></i> admin@mgtechs.com.ng</p>\n                    <p><i class="bi bi-telephone me-2"></i> +234 8161595906</p>\n                    <p><i class="bi bi-geo-alt me-2"></i> Yola, Nigeria</p>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} EduCore. Developed by <strong>MGTechs</strong> (mgtechs.com.ng, admin@mgtechs.com.ng, +234 8161595906). All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
        
        // Counter Animation
        function animateCounter(elementId, target, duration = 2000) {
            let start = 0;
            const increment = target / (duration / 16);
            const element = document.getElementById(elementId);
            
            const updateCounter = () => {
                start += increment;
                if (start < target) {
                    element.textContent = Math.floor(start).toLocaleString();
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target.toLocaleString();
                }
            };
            
            updateCounter();
        }
        
        // Start counters when in viewport
        const observerOptions = {
            threshold: 0.5
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter('statSchools', 5000);
                    animateCounter('statStudents', 25000);
                    animateCounter('statTeachers', 1800);
                    animateCounter('statParents', 15000);
                    observer.disconnect();
                }
            });
        }, observerOptions);
        
        observer.observe(document.querySelector('.stats'));
        
        // Smooth scroll
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
        
        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            }
        });
    </script>
</body>
</html>