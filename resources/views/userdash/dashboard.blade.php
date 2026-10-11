@extends('layouts.admin')

@section('page_title', 'Admin Dashboard Overview')

@section('content')
<div class="container-fluid p-0">

    <!-- KPI Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs text-muted text-uppercase fw-bold">Total Students</span>
                    <span class="w-40-px h-40-px rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center fs-5">
                        <i class="ri-user-line"></i>
                    </span>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $totalStudents }}</h3>
                <span class="text-xs text-muted">Self-registered learners</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs text-muted text-uppercase fw-bold">Published Courses</span>
                    <span class="w-40-px h-40-px rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center fs-5">
                        <i class="ri-book-open-line"></i>
                    </span>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $totalCourses }}</h3>
                <span class="text-xs text-muted">Authority masterclasses</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs text-muted text-uppercase fw-bold">Certificates Awarded</span>
                    <span class="w-40-px h-40-px rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center fs-5">
                        <i class="ri-award-line"></i>
                    </span>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $totalCertificates }}</h3>
                <span class="text-xs text-muted">Verified digital badges</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs text-muted text-uppercase fw-bold">WhatsApp Follow-ups</span>
                    <span class="w-40-px h-40-px rounded-3 bg-success text-white d-flex align-items-center justify-content-center fs-5">
                        <i class="ri-whatsapp-line"></i>
                    </span>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $totalWhatsappMessages }}</h3>
                <span class="text-xs text-muted">Automated bot messages</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 text-white" style="background: linear-gradient(135deg, #0F172A 0%, #1E3A8A 100%);">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h5 class="fw-bold text-white mb-1">WhatsApp Bot Follow-Up & Broadcast Engine</h5>
                <p class="text-light opacity-75 text-xs mb-0">Send bulk announcements to all enrolled students or trigger the daily unstarted/incomplete follow-up routine.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.whatsapp.index') }}" class="btn btn-warning text-dark btn-sm rounded-pill px-3 fw-bold">
                    <i class="ri-broadcast-line me-1"></i> Open Broadcast Center
                </a>
            </div>
        </div>
    </div>

    <!-- Tables Row: Recent Enrollments & Recent Certificates -->
    <div class="row g-4">
        <!-- Recent Enrollments -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Recent Enrollments & Progress</h6>
                    <span class="text-xs text-muted">Latest 6 students</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-sm">
                        <thead class="table-light text-xs text-muted text-uppercase">
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Progress</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEnrollments as $enr)
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $enr->user->name }}</div>
                                        <div class="text-xs text-muted">{{ $enr->user->phone ?? $enr->user->email }}</div>
                                    </td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 180px;">{{ $enr->course->title }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress" style="width: 70px; height: 6px;">
                                                <div class="progress-bar bg-success" style="width: {{ $enr->progress_percentage }}%"></div>
                                            </div>
                                            <span class="text-xs text-muted">{{ $enr->progress_percentage }}%</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $enr->status === 'completed' ? 'bg-success' : 'bg-primary' }} text-xs rounded-pill">
                                            {{ ucfirst($enr->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No enrollments yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent WhatsApp Messages -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">WhatsApp Bot Feed</h6>
                    <a href="{{ route('admin.whatsapp.index') }}" class="text-primary text-xs fw-semibold">View All</a>
                </div>

                <div class="list-group list-group-flush">
                    @forelse($recentWhatsapp as $wm)
                        <div class="list-group-item px-0 py-2 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="badge {{ $wm->direction === 'outbound' ? 'bg-primary-subtle text-primary' : 'bg-success-subtle text-success' }} text-xs rounded-pill">
                                    {{ $wm->direction === 'outbound' ? '⬆ Outbound' : '⬇ Inbound' }}
                                </span>
                                <span class="text-xs text-muted">{{ $wm->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-xs fw-semibold text-dark">{{ $wm->phone_number }}</div>
                            <p class="text-xs text-muted mb-0 text-truncate">{{ $wm->message_body }}</p>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted text-xs">No WhatsApp interactions logged yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
