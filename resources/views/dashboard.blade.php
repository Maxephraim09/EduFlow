@extends('layouts.admin')

@section('title', 'Dashboard - School Management System')
@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid px-0">
    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-to-r from-primary to-info text-white border-0 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="fw-bold mb-2">Welcome back, {{ Auth::user()->username }}!</h3>
                            <p class="mb-0 opacity-75">Here's what's happening with your school today.</p>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="bi bi-mortarboard fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Students</p>
                            <h2 class="fw-bold mb-0">{{ $totalStudents ?? 0 }}</h2>
                            <small class="text-success"><i class="bi bi-arrow-up"></i> +{{ $newStudentsThisMonth ?? 0 }} this month</small>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-people fs-1 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Teachers</p>
                            <h2 class="fw-bold mb-0">{{ $totalTeachers ?? 0 }}</h2>
                            <small class="text-muted">{{ $activeTeachers ?? 0 }} active</small>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-person-badge fs-1 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Classes</p>
                            <h2 class="fw-bold mb-0">{{ $totalClasses ?? 0 }}</h2>
                            <small class="text-muted">{{ $totalSections ?? 0 }} sections</small>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-building fs-1 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Revenue</p>
                            <h2 class="fw-bold mb-0">₦{{ number_format($totalRevenue ?? 0, 2) }}</h2>
                            <small class="text-success">This month: ₦{{ number_format($monthlyRevenue ?? 0, 2) }}</small>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-wallet2 fs-1 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold mb-0">Attendance Overview</h5>
                </div>
                <div class="card-body">
                    <canvas id="attendanceChart" height="250"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold mb-0">Revenue Trend</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Data Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Recent Students</h5>
                        <a href="{{ route('students.index') }}" class="btn btn-sm btn-link text-decoration-none">View All →</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($recentStudents ?? [] as $student)
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                            <i class="bi bi-person text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $student->first_name }} {{ $student->last_name }}</h6>
                                            <small class="text-muted">{{ $student->admission_number }}</small>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted">{{ $student->created_at->diffForHumans() }}</small>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-people fs-1 text-muted"></i>
                                <p class="text-muted mt-2">No students found</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Upcoming Events</h5>
                        <span class="badge bg-primary">{{ $upcomingEvents->count() ?? 0 }} events</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($upcomingEvents ?? [] as $event)
                            <div class="list-group-item px-0 d-flex gap-3">
                                <div class="text-center" style="min-width: 50px;">
                                    <div class="bg-primary bg-opacity-10 rounded p-2">
                                        <div class="fw-bold">{{ $event->start_datetime->format('d') }}</div>
                                        <small class="text-muted">{{ $event->start_datetime->format('M') }}</small>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1">{{ $event->title }}</h6>
                                    <small class="text-muted">
                                        <i class="bi bi-clock"></i> {{ $event->start_datetime->format('h:i A') }}
                                        @if($event->venue)
                                            <br><i class="bi bi-geo-alt"></i> {{ $event->venue }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-calendar fs-1 text-muted"></i>
                                <p class="text-muted mt-2">No upcoming events</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('students.create') }}" class="btn btn-outline-primary btn-lg text-start">
                            <i class="bi bi-person-plus me-2"></i> Add New Student
                        </a>
                        <a href="{{ route('fees.payments.create') }}" class="btn btn-outline-success btn-lg text-start">
                            <i class="bi bi-wallet2 me-2"></i> Record Fee Payment
                        </a>
                        <a href="{{ route('attendance.mark') }}" class="btn btn-outline-warning btn-lg text-start">
                            <i class="bi bi-calendar-check me-2"></i> Mark Attendance
                        </a>
                        <a href="{{ route('exams.create') }}" class="btn btn-outline-info btn-lg text-start">
                            <i class="bi bi-file-text me-2"></i> Create Examination
                        </a>
                        <a href="{{ route('results.entry') }}" class="btn btn-outline-secondary btn-lg text-start">
                            <i class="bi bi-graph-up me-2"></i> Enter Results
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Row -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold mb-0">Fee Collection Status by Class</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Collection Rate</th>
                                    <th>Amount Collected</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feeCollectionStatus ?? [] as $class => $data)
                                    <tr>
                                        <td class="fw-medium">{{ $class }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                    <div class="progress-bar bg-success" style="width: {{ $data['collected'] }}%"></div>
                                                </div>
                                                <span class="small">{{ $data['collected'] }}%</span>
                                            </div>
                                        </td>
                                        <td>₦{{ number_format($data['collected_amount'], 2) }}</td>
                                        <td>₦{{ number_format($data['total_amount'], 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox fs-1"></i>
                                            <p class="mt-2">No fee collection data available</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold mb-0">Subject Performance</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($subjectPerformance ?? [] as $subject)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-medium">{{ $subject['name'] }}</span>
                                    <span class="text-{{ $subject['average'] >= 70 ? 'success' : ($subject['average'] >= 50 ? 'warning' : 'danger') }}">
                                        {{ $subject['average'] }}%
                                    </span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-{{ $subject['average'] >= 70 ? 'success' : ($subject['average'] >= 50 ? 'warning' : 'danger') }}" 
                                         style="width: {{ $subject['average'] }}%">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-bar-chart fs-1 text-muted"></i>
                                <p class="text-muted mt-2">No performance data available</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Attendance Chart
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attendanceCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($attendanceLabels ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri']) !!},
            datasets: [{
                label: 'Present',
                data: {!! json_encode($attendanceData ?? [85, 88, 92, 87, 90]) !!},
                borderColor: '#1cc88a',
                backgroundColor: 'rgba(28, 200, 138, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#1cc88a',
                pointBorderColor: '#fff',
                pointRadius: 4,
                pointHoverRadius: 6
            }, {
                label: 'Absent',
                data: {!! json_encode($absentData ?? [15, 12, 8, 13, 10]) !!},
                borderColor: '#e74a3b',
                backgroundColor: 'rgba(231, 74, 59, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#e74a3b',
                pointBorderColor: '#fff',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + '%';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Percentage (%)'
                    }
                }
            }
        }
    });

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($revenueLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
            datasets: [{
                label: 'Revenue (₦)',
                data: {!! json_encode($revenueData ?? [150000, 180000, 220000, 210000, 250000, 280000]) !!},
                backgroundColor: '#4e73df',
                borderRadius: 8,
                barPercentage: 0.7,
                categoryPercentage: 0.8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '₦' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount (₦)'
                    },
                    ticks: {
                        callback: function(value) {
                            return '₦' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endpush