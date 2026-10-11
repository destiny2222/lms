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
                    <span class="text-xs text-muted text-uppercase fw-bold">Data Rewards</span>
                    <span class="w-40-px h-40-px rounded-3 bg-info-subtle text-info d-flex align-items-center justify-content-center fs-5">
                        <i class="ri-wifi-line"></i>
                    </span>
                </div>
                @php $activeRewardCount = \App\Models\DataReward::count(); @endphp
                <h3 class="fw-bold text-dark mb-0">{{ $activeRewardCount }}</h3>
                <span class="text-xs text-muted">10-badge milestone claims</span>
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

        
    </div>

</div>
@endsection
