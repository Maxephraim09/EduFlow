<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'School Management System'))</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900" rel="stylesheet" />
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --primary-dark: #224abe;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --dark-color: #5a5c69;
            --light-color: #f8f9fc;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Figtree', 'Segoe UI', system-ui, sans-serif;
            background-color: var(--light-color);
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 280px;
            background: linear-gradient(180deg, #040b22 0%, #010511 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0;
        }
        
        .sidebar-header h3 i {
            font-size: 1.5rem;
            margin-right: 10px;
        }
        
        .sidebar-header p {
            font-size: 0.75rem;
            opacity: 0.7;
            margin: 0;
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .sidebar-nav .nav-item {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            gap: 12px;
        }
        
        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .sidebar-nav .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            border-left: 4px solid #ffd700;
        }
        
        .sidebar-nav .nav-link i {
            width: 24px;
            font-size: 1.2rem;
        }
        
        .sidebar-nav .nav-link span {
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 280px;
            transition: all 0.3s ease;
        }
        
        /* Top Header */
        .top-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .top-header .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }
        
        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid #e3e6f0;
            padding: 1.5rem;
            text-align: center;
            color: var(--secondary-color);
            font-size: 0.85rem;
        }
        
        /* Content Area */
        .content-area {
            padding: 1.5rem;
            min-height: calc(100vh - 140px);
        }
        
        /* Cards */
        .stat-card {
            border: none;
            border-radius: 12px;
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        /* Mobile Toggle Button */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark-color);
            cursor: pointer;
        }
        
        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                left: -280px;
            }
            
            .sidebar.show {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-toggle {
                display: block;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
        }
        
        /* Dropdown */
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
            border-radius: 10px;
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }
        
        .dropdown-item:hover {
            background-color: var(--light-color);
        }
        
        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            font-size: 0.65rem;
            padding: 2px 5px;
            border-radius: 50%;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
    </style>
    
    @stack('styles')
</head>
<body>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>
                <i class="bi bi-mortarboard-fill"></i> EduCore
            </h3>
            <p>Complete School Management System</p>
        </div>
        
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Students</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}" href="{{ route('teachers.index') }}">
                    <i class="bi bi-person-badge-fill"></i>
                    <span>Teachers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('parents.*') ? 'active' : '' }}" href="{{ route('parents.index') }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Parents</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('classes.*') ? 'active' : '' }}" href="{{ route('classes.index') }}">
                    <i class="bi bi-building-fill"></i>
                    <span>Classes</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}" href="{{ route('subjects.index') }}">
                    <i class="bi bi-book-fill"></i>
                    <span>Subjects</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                    <i class="bi bi-calendar-check-fill"></i>
                    <span>Attendance</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('exams.*') ? 'active' : '' }}" href="{{ route('exams.index') }}">
                    <i class="bi bi-file-text-fill"></i>
                    <span>Exams</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('results.*') ? 'active' : '' }}" href="{{ route('results.index') }}">
                    <i class="bi bi-graph-up"></i>
                    <span>Results</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('fees.*') ? 'active' : '' }}" href="{{ route('fees.index') }}">
                    <i class="bi bi-wallet2"></i>
                    <span>Fees</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('library.*') ? 'active' : '' }}" href="{{ route('library.index') }}">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <span>Library</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('transport.*') ? 'active' : '' }}" href="{{ route('transport.index') }}">
                    <i class="bi bi-bus-front-fill"></i>
                    <span>Transport</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('hostel.*') ? 'active' : '' }}" href="{{ route('hostel.index') }}">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Hostel</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}" href="{{ route('events.index') }}">
                    <i class="bi bi-calendar-event-fill"></i>
                    <span>Events</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                    <i class="bi bi-file-spreadsheet-fill"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                    <i class="bi bi-gear-fill"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <div class="top-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <button class="mobile-toggle" id="mobileToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h5 class="page-title">@yield('page-title', 'Dashboard')</h5>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <!-- Notifications -->
                    <div class="dropdown">
                        <button class="btn btn-link text-dark position-relative" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-bell fs-5"></i>
                            @if(isset($unreadNotifications) && $unreadNotifications > 0)
                                <span class="notification-badge">{{ $unreadNotifications }}</span>
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-0" style="width: 320px;">
                            <div class="p-3 border-bottom">
                                <h6 class="mb-0">Notifications</h6>
                            </div>
                            <div class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                                @forelse($notifications ?? [] as $notification)
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        <p class="mb-0 small">{{ $notification->message }}</p>
                                    </a>
                                @empty
                                    <div class="p-3 text-center text-muted">
                                        <i class="bi bi-bell-slash fs-4"></i>
                                        <p class="mb-0 small">No new notifications</p>
                                    </div>
                                @endforelse
                            </div>
                            <div class="p-2 text-center border-top">
                                <a href="#" class="small text-decoration-none">View all</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-link text-dark dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                <span class="small fw-bold">{{ substr(Auth::user()->username, 0, 2) }}</span>
                            </div>
                            <span class="d-none d-md-inline">{{ Auth::user()->username }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> My Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-envelope me-2"></i> Messages</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Account Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0">&copy; {{ date('Y') }} School Management System. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <p class="mb-0">Developed by <strong>MGTechs</strong> (mgtechs.com.ng) | v2.0.0</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Mobile Sidebar Toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        if (mobileToggle) {
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.add('show');
                sidebarOverlay.classList.add('show');
            });
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });
        }
        
        // Initialize DataTables
        $(document).ready(function() {
            $('.datatable').DataTable({
                responsive: true,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        });
        
        // Confirm Delete
        function confirmDelete(formId) {
            if (confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                document.getElementById(formId).submit();
            }
        }
    </script>
    
    @stack('scripts')
</body>
</html>