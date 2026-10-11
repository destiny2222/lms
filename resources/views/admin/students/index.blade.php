@extends('layouts.admin')

@section('page_title', 'Disciples & Students')

@section('content')
<div class="container-fluid p-0">

    <!-- Top Page Header matching Larkon Breadcrumb / Title Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-0 text-uppercase" style="letter-spacing: 0.6px; font-size: 1.15rem;">Disciples &amp; Students</h4>
            <p class="text-muted text-xs mb-0">Monitor learner progress, course enrollments, and discipleship completion milestones</p>
        </div>
        <div class="text-sm text-muted">
            <span class="text-secondary fw-medium">Admin</span> &bull; <span class="text-primary fw-semibold">Disciples</span>
        </div>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Total Disciples</span>
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-group-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $stats['total_students'] }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Registered learner accounts</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Active Learners</span>
                    <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-book-read-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $stats['active_enrolled'] }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Enrolled in curriculum</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Graduates</span>
                    <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-checkbox-circle-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $stats['graduates'] }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Completed ≥ 1 course</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Total Enrollments</span>
                    <div class="rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-graduation-cap-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $stats['total_enrollments'] }}</h3>
                <span class="text-muted text-xs mt-1 d-block">All active course seats</span>
            </div>
        </div>
    </div>

    <!-- Main Card matching Larkon "All Product List" -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white larkon-main-card">
        
        <!-- Card Header: Title + Search & Filters -->
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <h5 class="fw-bold text-dark mb-0 fs-16">All Disciples Directory</h5>
                <span class="badge bg-light text-muted border text-xs px-2 py-1 rounded-pill">{{ $students->total() }} Total</span>
            </div>
            
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <!-- Search and Filters Form -->
                <form method="GET" action="{{ route('admin.students.index') }}" class="d-flex align-items-center gap-2 flex-wrap m-0">
                    <div class="input-group input-group-sm" style="width: 220px;">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="ri-search-line"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Search disciple..." value="{{ request('search') }}">
                    </div>

                    <select name="course_id" class="form-select form-select-sm bg-light" style="width: 180px;" onchange="this.form.submit()">
                        <option value="">All Courses</option>
                        @foreach($courses as $c)
                            <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>
                                {{ Str::limit($c->title, 25) }}
                            </option>
                        @endforeach
                    </select>

                    <select name="filter" class="form-select form-select-sm bg-light" style="width: 150px;" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="in_progress" {{ request('filter') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('filter') == 'completed' ? 'selected' : '' }}>Course Graduates</option>
                        <option value="certified" {{ request('filter') == 'certified' ? 'selected' : '' }}>Certified Disciples</option>
                    </select>

                    @if(request()->anyFilled(['search', 'course_id', 'filter']))
                        <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-outline-secondary" title="Clear Filters">
                            <i class="ri-refresh-line"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Table Responsive Container -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 larkon-table">
                <thead>
                    <tr>
                        <th style="min-width: 260px;" class="ps-4">Disciple Details</th>
                        <th style="min-width: 160px;">Contact / WhatsApp</th>
                        <th style="min-width: 130px;" class="text-center">Enrolled Courses</th>
                        <th style="min-width: 130px;" class="text-center">Completed</th>
                        <th style="min-width: 130px;" class="text-center">Certificates</th>
                        <th style="min-width: 140px;">Registered</th>
                        <th style="min-width: 120px;" class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        @php
                            $completedCount = $student->enrollments->where('status', 'completed')->count();
                            $certCount = $student->enrollments->whereNotNull('certificate')->count();
                        @endphp
                        <tr>
                            <!-- Disciple Avatar & Name -->
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; font-size: 14px;">
                                        {{ strtoupper(substr($student->name, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="fw-semibold text-dark fs-14 text-truncate" style="max-width: 220px;" title="{{ $student->name }}">
                                            {{ $student->name }}
                                        </div>
                                        <span class="text-muted text-xs d-block text-truncate" style="max-width: 220px;">
                                            {{ $student->email }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Phone & WhatsApp -->
                            <td>
                                @if($student->phone)
                                    <div class="d-flex align-items-center gap-1.5">
                                        <span class="text-dark fs-13 fw-medium">{{ $student->phone }}</span>
                                        @php
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $student->phone);
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="text-success text-decoration-none" title="Open WhatsApp Chat">
                                            <i class="ri-whatsapp-fill fs-5"></i>
                                        </a>
                                    </div>
                                @else
                                    <span class="text-muted text-xs">No phone set</span>
                                @endif
                            </td>

                            <!-- Enrolled Courses Count -->
                            <td class="text-center">
                                <span class="badge {{ $student->enrollments->count() > 0 ? 'bg-primary-subtle text-primary border border-primary-subtle' : 'bg-light text-secondary border' }} rounded-pill px-2.5 py-1 text-xs fw-semibold">
                                    {{ $student->enrollments->count() }} {{ Str::plural('Course', $student->enrollments->count()) }}
                                </span>
                            </td>

                            <!-- Completed Courses Count -->
                            <td class="text-center">
                                @if($completedCount > 0)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 text-xs fw-semibold">
                                        <i class="ri-check-line me-0.5"></i> {{ $completedCount }} Completed
                                    </span>
                                @else
                                    <span class="text-muted text-xs">0 Completed</span>
                                @endif
                            </td>

                            <!-- Certificates Count -->
                            <td class="text-center">
                                @if($certCount > 0)
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2.5 py-1 text-xs fw-semibold">
                                        <i class="ri-award-fill me-0.5"></i> {{ $certCount }} Issued
                                    </span>
                                @else
                                    <span class="text-muted text-xs">0 Certificates</span>
                                @endif
                            </td>

                            <!-- Registered Date -->
                            <td>
                                <span class="text-dark fs-13 fw-medium">{{ $student->created_at->format('M d, Y') }}</span>
                                <span class="text-muted text-xs d-block">{{ $student->created_at->diffForHumans() }}</span>
                            </td>

                            <!-- Actions -->
                            <td class="text-end pe-4">
                                <div class="d-inline-flex align-items-center gap-2">
                                    <!-- View Student Learning Journey Modal Trigger -->
                                    <button type="button" class="btn-larkon-action btn-larkon-edit" data-bs-toggle="modal" data-bs-target="#studentModal{{ $student->id }}" title="View Learning Journey">
                                        <i class="ri-eye-line"></i>
                                    </button>

                                    @if($student->phone)
                                        <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="btn-larkon-action btn-larkon-lessons" title="Direct WhatsApp Message">
                                            <i class="ri-whatsapp-line"></i>
                                        </a>
                                    @endif
                                </div>

                                <!-- Student Learning Profile Modal -->
                                <div class="modal fade text-start" id="studentModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                            <div class="modal-header bg-light border-bottom px-4 py-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 16px;">
                                                        {{ strtoupper(substr($student->name, 0, 2)) }}
                                                    </div>
                                                    <div>
                                                        <h5 class="modal-title fw-bold text-dark fs-16 mb-0">{{ $student->name }}</h5>
                                                        <span class="text-muted text-xs">{{ $student->email }} &bull; Joined {{ $student->created_at->format('M d, Y') }}</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body p-4">
                                                <h6 class="fw-bold text-dark mb-3">Enrolled Courses &amp; Progress ({{ $student->enrollments->count() }})</h6>
                                                
                                                @forelse($student->enrollments as $enrollment)
                                                    <div class="border rounded-3 p-3 mb-3 bg-white">
                                                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                                            <div>
                                                                <h6 class="fw-semibold text-dark mb-0.5">{{ $enrollment->course->title ?? 'Course' }}</h6>
                                                                <span class="text-muted text-xs">
                                                                    Enrolled on {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('M d, Y') : $enrollment->created_at->format('M d, Y') }}
                                                                </span>
                                                            </div>
                                                            <span class="badge {{ $enrollment->status === 'completed' ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary' }} rounded-pill px-2.5 py-1 text-xs fw-semibold">
                                                                {{ ucfirst($enrollment->status) }}
                                                            </span>
                                                        </div>

                                                        <!-- Progress Bar -->
                                                        <div class="d-flex align-items-center gap-2 mb-2">
                                                            <div class="progress flex-grow-1" style="height: 6px;">
                                                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $enrollment->progress_percentage }}%;" aria-valuenow="{{ $enrollment->progress_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                            <span class="text-xs fw-semibold text-dark">{{ $enrollment->progress_percentage }}%</span>
                                                        </div>

                                                        @if($enrollment->certificate)
                                                            <div class="d-flex align-items-center justify-content-between p-2 rounded-2 bg-light border text-xs mt-2">
                                                                <div class="d-flex align-items-center gap-2 text-dark">
                                                                    <i class="ri-award-fill text-warning fs-5"></i>
                                                                    <span>Certificate: <strong>{{ $enrollment->certificate->certificate_number }}</strong></span>
                                                                </div>
                                                                <a href="{{ route('certificates.verify', $enrollment->certificate->share_token) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-0.5 text-xxs">
                                                                    Verify Public Link <i class="ri-external-link-line ms-0.5"></i>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @empty
                                                    <div class="text-center py-4 text-muted">
                                                        <i class="ri-book-open-line fs-2 text-secondary mb-2 d-block"></i>
                                                        <p class="mb-0 text-xs">This disciple has not enrolled in any courses yet.</p>
                                                    </div>
                                                @endforelse
                                            </div>

                                            <div class="modal-footer bg-light px-4 py-2.5">
                                                <button type="button" class="btn btn-secondary rounded-pill px-3 text-xs" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                        <i class="ri-group-line fs-2 text-muted"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-1">No disciples found</h5>
                                    <p class="text-muted text-xs mb-0">No learners match your current search or filter criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($students->hasPages())
            <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span class="text-xs text-muted">
                    Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} disciples
                </span>
                <div>
                    {{ $students->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>

</div>

<style>
    .larkon-main-card {
        border-color: #eef2f6 !important;
    }
    .larkon-table thead th {
        background-color: #f8fafc;
        color: #475569;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 13px 16px;
        border-bottom: 1px solid #edf2f7;
        white-space: nowrap;
    }
    .larkon-table tbody td {
        padding: 16px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 13.5px;
    }
    .larkon-table tbody tr:hover td {
        background-color: #fafbfc;
    }

    /* Action Buttons Design */
    .btn-larkon-action {
        width: 36px !important;
        height: 36px !important;
        border-radius: 9px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border: 1px solid transparent !important;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
        text-decoration: none !important;
        font-size: 17px !important;
        cursor: pointer !important;
        padding: 0 !important;
        line-height: 1 !important;
        outline: none !important;
        box-shadow: none !important;
    }
    .btn-larkon-action:hover {
        transform: translateY(-2px) !important;
    }

    /* Learning Profile Button (Brand Blue) */
    .btn-larkon-edit {
        background-color: #eff6ff !important;
        border-color: #dbeafe !important;
        color: #2563eb !important;
    }
    .btn-larkon-edit:hover {
        background-color: #2563eb !important;
        border-color: #2563eb !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3) !important;
    }

    /* WhatsApp Button (Green) */
    .btn-larkon-lessons {
        background-color: #f0fdf4 !important;
        border-color: #dcfce7 !important;
        color: #16a34a !important;
    }
    .btn-larkon-lessons:hover {
        background-color: #16a34a !important;
        border-color: #16a34a !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3) !important;
    }
</style>
@endsection
