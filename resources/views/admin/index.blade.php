@extends('layouts.admin')

@section('title', 'Admin Dashboard — RACAi Discipleship')

@section('content')
<div class="container-fluid p-0">

    <!-- Top Action & Filter Header Row (Matching Dribbble Shopeers Reference) -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-1" style="font-size: 1.75rem; letter-spacing: -0.5px;">Dashboard</h1>
            <p class="text-secondary text-sm mb-0">Welcome back, {{ Auth::guard('admin')->user()?->name ?? 'Administrator' }}! Here is your discipleship academy overview.</p>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
      

            <a href="{{ route('admin.courses.create') }}"
                class="btn btn-primary rounded-pill px-4 py-2 text-xs fw-bold d-inline-flex align-items-center gap-2 shadow-sm" style="background-color: var(--primary); border-color: var(--primary);">
                <i class="ri-add-line fs-6"></i>
                <span>New Course</span>
            </a>
        </div>
    </div>

    <!-- 4 High-Impact KPI Cards (Shopeers Style) -->
    <div class="row g-4 mb-4">
        <!-- Card 1: Total Disciples -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card-shopeers h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary text-xs fw-bold text-uppercase" style="letter-spacing: 0.6px;">Total Learners</span>
                    <div class="stat-icon-squircle" style="background-color: #eff6ff; color: #2563eb;">
                        <i class="ri-user-smile-line"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-2">
                    <h2 class="stat-number-display">{{ number_format($stats['total_students']) }}</h2>
                    <span class="stat-badge-trend" style="background-color: #ecfdf5; color: #059669; border: 1px solid #d1fae5;">
                        <i class="ri-arrow-up-s-fill"></i> +15.5%
                    </span>
                </div>
                <span class="text-muted text-xs">vs. last month</span>
            </div>
        </div>

        <!-- Card 2: Published Courses -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card-shopeers h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary text-xs fw-bold text-uppercase" style="letter-spacing: 0.6px;">Curriculum Courses</span>
                    <div class="stat-icon-squircle" style="background-color: #fffbeb; color: #d97706;">
                        <i class="ri-book-open-line"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-2">
                    <h2 class="stat-number-display">{{ number_format($stats['total_courses']) }}</h2>
                    <span class="stat-badge-trend" style="background-color: #ecfdf5; color: #059669; border: 1px solid #d1fae5;">
                        <i class="ri-arrow-up-s-fill"></i> +8.4%
                    </span>
                </div>
                <span class="text-muted text-xs">Active curriculum modules</span>
            </div>
        </div>

        <!-- Card 3: Active Enrollments -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card-shopeers h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary text-xs fw-bold text-uppercase" style="letter-spacing: 0.6px;">Active Enrollments</span>
                    <div class="stat-icon-squircle" style="background-color: #f0fdfa; color: #0d9488;">
                        <i class="ri-focus-3-line"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-2">
                    <h2 class="stat-number-display">{{ number_format($stats['total_enrollments']) }}</h2>
                    <span class="stat-badge-trend" style="background-color: #eff6ff; color: #2563eb; border: 1px solid #dbeafe;">
                        <i class="ri-arrow-up-s-fill"></i> +24.4%
                    </span>
                </div>
                <span class="text-muted text-xs">Ongoing study journeys</span>
            </div>
        </div>

        <!-- Card 4: Verified Certificates -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card-shopeers h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-secondary text-xs fw-bold text-uppercase" style="letter-spacing: 0.6px;">Verified Badges</span>
                    <div class="stat-icon-squircle" style="background-color: #faf5ff; color: #7c3aed;">
                        <i class="ri-award-line"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-2">
                    <h2 class="stat-number-display">{{ number_format($stats['total_certificates']) }}</h2>
                    <span class="stat-badge-trend" style="background-color: #ecfdf5; color: #059669; border: 1px solid #d1fae5;">
                        <i class="ri-arrow-up-s-fill"></i> +100%
                    </span>
                </div>
                <span class="text-muted text-xs">Issued credentials</span>
            </div>
        </div>
    </div>

    <!-- Main Analytics & Content Grid -->
    <div class="row g-4">
        <!-- Left Column: Engagement Area Chart & Recent Enrollments Table -->
        <div class="col-12 col-xl-8 d-flex flex-column gap-4">

            <!-- Chart Card: Learning & Enrollment Analytics -->
            <div class="card-modern">
                <div class="card-modern-header flex-wrap gap-2">
                    <div>
                        <h6 class="fw-bold text-dark mb-1 fs-6">Learning Activity &amp; Growth</h6>
                        <p class="text-muted text-xs mb-0">Total disciple study hours and curriculum engagement</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1.5 text-xs fw-semibold rounded-pill">
                            <i class="ri-flashlight-line me-1"></i> +18.2% Growth
                        </span>
                    </div>
                </div>
                <div class="card-modern-body">
                    <!-- Key metric chips -->
                    <div class="d-flex flex-wrap align-items-center gap-4 mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="w-3 rounded-pill bg-primary" style="width: 12px; height: 12px;"></span>
                            <div>
                                <span class="d-block text-muted text-xs">Total Hours</span>
                                <span class="fw-bold text-dark text-sm">1,280 hrs</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="w-3 rounded-pill bg-secondary" style="width: 12px; height: 12px; background-color: #94a3b8 !important;"></span>
                            <div>
                                <span class="d-block text-muted text-xs">Previous Period</span>
                                <span class="fw-bold text-dark text-sm">1,020 hrs</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 ms-auto">
                            <div class="text-end">
                                <span class="d-block text-muted text-xs">Active Attendance</span>
                                <span class="fw-bold text-success text-sm">96.4% on track</span>
                            </div>
                        </div>
                    </div>

                    <!-- Apex Chart Container -->
                    <div id="learningAnalyticsAreaChart" style="min-height: 250px;"></div>
                </div>
            </div>

            <!-- Recent Disciple Enrollments Modern Table -->
            <div class="card-modern overflow-hidden">
                <div class="card-modern-header flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-squircle" style="background-color: #eff6ff; color: #2563eb;">
                            <i class="ri-user-shared-line"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0 fs-6">Recent Disciple Enrollments</h6>
                            <p class="text-muted text-xs mb-0">Track real-time student registrations and course progress</p>
                        </div>
                    </div>
                    <span class="badge bg-light text-secondary border px-3 py-1.5 text-xs fw-semibold rounded-pill">
                        Latest {{ count($recentEnrollments) }} Disciples
                    </span>
                </div>
                <div class="p-0">
                    <div class="table-responsive">
                        <table class="table-dribbble align-middle">
                            <thead>
                                <tr>
                                    <th>Disciple</th>
                                    <th>Course Module</th>
                                    <th>Enrolled Date</th>
                                    <th class="text-end">Progress Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentEnrollments as $enrollment)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="user-avatar-circle" style="width: 38px; height: 38px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                                                    {{ strtoupper(substr($enrollment->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="fw-bold text-dark text-sm mb-0 text-truncate" style="max-width: 180px;" title="{{ $enrollment->user->name ?? 'Unknown Disciple' }}">
                                                        {{ $enrollment->user->name ?? 'Unknown Disciple' }}
                                                    </div>
                                                    <div class="text-muted text-xs text-truncate" style="max-width: 180px;" title="{{ $enrollment->user->email ?? 'no-email@lms.test' }}">
                                                        {{ $enrollment->user->email ?? 'no-email@lms.test' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="w-7 h-7 rounded bg-light text-primary d-flex align-items-center justify-content-center p-1.5 border" style="border-radius: 8px;">
                                                    <i class="ri-book-open-line text-xs"></i>
                                                </div>
                                                <span class="fw-semibold text-dark text-sm text-truncate d-inline-block" style="max-width: 230px;" title="{{ $enrollment->course->title ?? 'N/A' }}">
                                                    {{ $enrollment->course->title ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-muted text-xs fw-medium text-nowrap">
                                            <i class="ri-calendar-line me-1 text-primary"></i>
                                            {{ $enrollment->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="text-end text-nowrap">
                                            @php
                                                $status = strtolower($enrollment->status ?? 'active');
                                            @endphp
                                            @if ($status === 'completed')
                                                <span class="pill-status pill-completed">
                                                    <span class="pill-status-dot"></span>
                                                    Completed
                                                </span>
                                            @elseif($status === 'in_progress' || $status === 'active')
                                                <span class="pill-status pill-in-progress">
                                                    <span class="pill-status-dot"></span>
                                                    In Progress
                                                </span>
                                            @else
                                                <span class="pill-status pill-enrolled">
                                                    <span class="pill-status-dot"></span>
                                                    {{ ucfirst($status) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted text-sm">
                                            <i class="ri-folder-open-line fs-2 d-block mb-2 text-secondary"></i>
                                            No student enrollments recorded yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Peak Days, Completion Gauge, Bot Control, Course Shortcuts -->
        <div class="col-12 col-xl-4 d-flex flex-column gap-4">

            <!-- Card 1: Peak Active Days Bar Chart (Matching Shopeers Tuesday Peak) -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <div>
                        <h6 class="fw-bold text-dark mb-0 fs-6">Peak Active Days</h6>
                        <p class="text-muted text-xs mb-0">Disciples activity distribution</p>
                    </div>
                    <span class="badge bg-primary text-white rounded-pill px-2.5 py-1 text-xs fw-bold">
                        816 Tue
                    </span>
                </div>
                <div class="card-modern-body pb-2">
                    <div id="weeklyPeakDaysBarChart" style="min-height: 200px;"></div>
                </div>
            </div>

            <!-- Card 2: Curriculum Completion Gauge -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <div>
                        <h6 class="fw-bold text-dark mb-0 fs-6">Curriculum Mastery</h6>
                        <p class="text-muted text-xs mb-0">Cohort completion target</p>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill text-xs px-2 py-0.5 fw-semibold">
                        On Track
                    </span>
                </div>
                <div class="card-modern-body text-center pt-2 pb-3">
                    <div id="masteryGaugeChart" style="min-height: 190px;"></div>
                    <p class="text-muted text-xs mb-0 mt-n2">78% of active disciples on schedule for certificate graduation.</p>
                </div>
            </div>

            <!-- Card 3: Automated WhatsApp Accountability Bot Widget -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ri-whatsapp-line fs-5 text-success"></i>
                        <h6 class="fw-bold text-dark mb-0 fs-6">WhatsApp Bot Control</h6>
                    </div>
                    <span class="badge bg-success text-white rounded-pill px-2.5 py-1 text-xs fw-bold d-inline-flex align-items-center gap-1">
                        <span class="spinner-grow spinner-grow-sm" role="status" style="width: 6px; height: 6px;"></span>
                        Live
                    </span>
                </div>
                <div class="card-modern-body">
                    <p class="text-muted text-xs mb-3">
                        Broadcast daily study reminders and follow-ups to disciples with pending masterclass lessons.
                    </p>
                    <form action="{{ route('admin.whatsapp.reminders') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-success btn-sm w-100 rounded-pill py-2.5 text-xs fw-bold d-flex align-items-center justify-content-center gap-2">
                            <i class="ri-refresh-line"></i>
                            <span>Run Daily Reminders</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Card 4: Active Curriculum Modules Shortcuts -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <div>
                        <h6 class="fw-bold text-dark mb-0 fs-6">Active Curriculum</h6>
                        <p class="text-muted text-xs mb-0">Quick lesson management</p>
                    </div>
                    <a href="{{ route('admin.courses.index') }}" class="text-primary text-xs fw-bold text-decoration-none">
                        Catalog <i class="ri-arrow-right-s-line"></i>
                    </a>
                </div>
                <div class="card-modern-body p-0">
                    <div class="list-group list-group-flush border-0">
                        @forelse($recentCourses as $course)
                            <div class="list-group-item d-flex align-items-center justify-content-between p-3 border-light">
                                <div class="d-flex align-items-center gap-2.5 min-w-0">
                                    <div class="stat-icon-squircle" style="width: 36px; height: 36px; background-color: #f1f5f9; color: #2563eb; font-size: 1rem;">
                                        <i class="ri-book-2-line"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="fw-bold text-dark text-xs text-truncate" style="max-width: 170px;" title="{{ $course->title }}">
                                            {{ $course->title }}
                                        </div>
                                        <div class="text-muted text-xs">
                                            {{ $course->lessons_count }} Lessons • {{ $course->enrollments_count }} Enrolled
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.courses.lessons', $course->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-1 text-xs fw-bold text-nowrap">
                                    Manage
                                </a>
                            </div>
                        @empty
                            <div class="p-3 text-center text-muted text-xs">
                                No courses created yet.
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
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Learning & Engagement Smooth Area Chart
        const areaEl = document.querySelector("#learningAnalyticsAreaChart");
        if (areaEl && typeof ApexCharts !== 'undefined') {
            const areaOptions = {
                series: [{
                    name: 'Study Hours (Current)',
                    data: [42, 60, 54, 78, 72, 94, 110]
                }, {
                    name: 'Study Hours (Previous)',
                    data: [30, 40, 48, 55, 50, 68, 78]
                }],
                chart: {
                    type: 'area',
                    height: 250,
                    fontFamily: 'Plus Jakarta Sans, sans-serif',
                    toolbar: { show: false },
                    sparkline: { enabled: false }
                },
                colors: ['#2563eb', '#94a3b8'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.04,
                        stops: [0, 90, 100]
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: [3, 2],
                    dashArray: [0, 4]
                },
                markers: {
                    size: 4,
                    colors: ['#2563eb', '#94a3b8'],
                    strokeColors: '#ffffff',
                    strokeWidth: 2
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: false } }
                },
                xaxis: {
                    categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    labels: {
                        style: { colors: '#64748b', fontSize: '11px', fontWeight: 600 }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#64748b', fontSize: '11px', fontWeight: 600 },
                        formatter: (val) => val + 'h'
                    }
                },
                legend: { show: false },
                tooltip: {
                    theme: 'light',
                    y: { formatter: (val) => val + ' hours' }
                }
            };
            const areaChart = new ApexCharts(areaEl, areaOptions);
            areaChart.render();
        }

        // 2. Peak Active Days Bar Chart (Matching Shopeers Tuesday highlight)
        const barEl = document.querySelector("#weeklyPeakDaysBarChart");
        if (barEl && typeof ApexCharts !== 'undefined') {
            const barOptions = {
                series: [{
                    name: 'Active Disciples',
                    data: [320, 450, 816, 420, 390, 510, 300]
                }],
                chart: {
                    type: 'bar',
                    height: 210,
                    fontFamily: 'Plus Jakarta Sans, sans-serif',
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '45%',
                        distributed: true
                    }
                },
                colors: ['#e2e8f0', '#e2e8f0', '#2563eb', '#e2e8f0', '#e2e8f0', '#e2e8f0', '#e2e8f0'],
                dataLabels: { enabled: false },
                legend: { show: false },
                xaxis: {
                    categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    labels: {
                        style: { colors: '#64748b', fontSize: '11px', fontWeight: 600 }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: { show: false },
                grid: { show: false },
                tooltip: {
                    theme: 'light',
                    y: { formatter: (val) => val + ' disciples' }
                }
            };
            const barChart = new ApexCharts(barEl, barOptions);
            barChart.render();
        }

        // 3. Curriculum Mastery Semi-Radial Gauge Chart
        const gaugeEl = document.querySelector("#masteryGaugeChart");
        if (gaugeEl && typeof ApexCharts !== 'undefined') {
            const gaugeOptions = {
                series: [78],
                chart: {
                    type: 'radialBar',
                    height: 210,
                    fontFamily: 'Plus Jakarta Sans, sans-serif',
                    sparkline: { enabled: true }
                },
                plotOptions: {
                    radialBar: {
                        startAngle: -90,
                        endAngle: 90,
                        track: {
                            background: '#f1f5f9',
                            strokeWidth: '95%'
                        },
                        dataLabels: {
                            name: { show: false },
                            value: {
                                offsetY: -4,
                                fontSize: '26px',
                                fontWeight: '800',
                                color: '#0f172a',
                                formatter: (val) => val + '%'
                            }
                        }
                    }
                },
                fill: {
                    colors: ['#10b981']
                },
                labels: ['Target Mastery']
            };
            const gaugeChart = new ApexCharts(gaugeEl, gaugeOptions);
            gaugeChart.render();
        }
    });
</script>
@endpush
