@extends('layouts.admin')

@section('page_title', 'Issued Certificates')

@section('content')
<div class="container-fluid p-0">

    <!-- Top Page Header matching Larkon Breadcrumb / Title Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-0 text-uppercase" style="letter-spacing: 0.6px; font-size: 1.15rem;">Issued Certificates</h4>
            <p class="text-muted text-xs mb-0">Manage verifiable completion credentials, public badges, and discipleship graduation records</p>
        </div>
        <div class="text-sm text-muted">
            <span class="text-secondary fw-medium">Admin</span> &bull; <span class="text-primary fw-semibold">Certificates</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert" style="background-color: #ecfdf5; color: #065f46;">
            <i class="ri-checkbox-circle-fill fs-5 text-success"></i>
            <div class="fw-medium text-sm">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="ri-error-warning-fill fs-5 text-danger"></i>
            <div class="fw-medium text-sm">{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Top KPI Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Total Issued</span>
                    <div class="rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-award-fill fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $stats['total_issued'] }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Official credentials generated</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Certified Disciples</span>
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-user-star-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $stats['unique_students'] }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Graduates with &ge; 1 certificate</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Issued This Month</span>
                    <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-calendar-check-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $stats['this_month'] }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Graduations in {{ now()->format('F Y') }}</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-xs fw-semibold text-uppercase">Eligible Courses</span>
                    <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ri-book-open-line fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $courses->count() }}</h3>
                <span class="text-muted text-xs mt-1 d-block">Courses in curriculum</span>
            </div>
        </div>
    </div>

    <!-- Main Card matching Larkon "All Product List" -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white larkon-main-card">
        
        <!-- Card Header: Title + Search & Filters -->
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <h5 class="fw-bold text-dark mb-0 fs-16">All Certificates Directory</h5>
                <span class="badge bg-light text-muted border text-xs px-2 py-1 rounded-pill">{{ $certificates->total() }} Records</span>
            </div>
            
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <!-- Search and Filters Form -->
                <form method="GET" action="{{ route('admin.certificates.index') }}" class="d-flex align-items-center gap-2 flex-wrap m-0">
                    <div class="input-group input-group-sm" style="width: 260px;">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="ri-search-line"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Search cert #, disciple, course..." value="{{ request('search') }}">
                    </div>

                    <select name="course_id" class="form-select form-select-sm bg-light" style="width: 190px;" onchange="this.form.submit()">
                        <option value="">All Courses</option>
                        @foreach($courses as $c)
                            <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>
                                {{ Str::limit($c->title, 25) }}
                            </option>
                        @endforeach
                    </select>

                    @if(request()->anyFilled(['search', 'course_id']))
                        <a href="{{ route('admin.certificates.index') }}" class="btn btn-sm btn-outline-secondary" title="Clear Filters">
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
                        <th style="min-width: 260px;" class="ps-4">Certificate Serial &amp; ID</th>
                        <th style="min-width: 240px;">Disciple / Recipient</th>
                        <th style="min-width: 220px;">Course Completed</th>
                        <th style="min-width: 140px;">Issued Date</th>
                        <th style="min-width: 100px;" class="text-center">Verification</th>
                        <th style="min-width: 180px;" class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($certificates as $certificate)
                        @php
                            $user = $certificate->enrollment?->user;
                            $course = $certificate->enrollment?->course;
                        @endphp
                        <tr>
                            <!-- Serial & Number -->
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="rounded-3 bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px;">
                                        <i class="ri-award-fill fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold font-monospace text-dark fs-13 mb-0.5 text-nowrap" style="white-space: nowrap !important; word-break: keep-all !important; display: inline-block;">
                                            {{ $certificate->certificate_number }}
                                        </div>
                                        <div class="d-flex align-items-center gap-1">
                                            <span class="text-muted text-xxs font-monospace">Token: {{ Str::limit($certificate->share_token, 10) }}</span>
                                            <button type="button" class="btn btn-link p-0 text-muted" onclick="navigator.clipboard.writeText('{{ $certificate->share_url }}'); this.innerHTML='<i class=\'ri-check-line text-success\'></i>'; setTimeout(() => this.innerHTML='<i class=\'ri-file-copy-line\'></i>', 1500);" title="Copy Public URL">
                                                <i class="ri-file-copy-line text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Disciple details -->
                            <td>
                                @if($user)
                                    <div class="d-flex align-items-center gap-2.5">
                                        <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; font-size: 13px;">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="fw-semibold text-dark fs-14 text-truncate" style="max-width: 200px;" title="{{ $user->name }}">
                                                {{ $user->name }}
                                            </div>
                                            <span class="text-muted text-xs d-block text-truncate" style="max-width: 200px;">
                                                {{ $user->email }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted text-xs italic">User account deleted</span>
                                @endif
                            </td>

                            <!-- Course Title -->
                            <td>
                                @if($course)
                                    <div class="min-w-0">
                                        <div class="fw-medium text-dark fs-13 text-truncate" style="max-width: 220px;" title="{{ $course->title }}">
                                            {{ $course->title }}
                                        </div>
                                        <span class="badge bg-light text-muted border text-xxs px-2 py-0.5 rounded-pill">
                                            {{ ucfirst($course->level ?? 'General') }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-muted text-xs italic">Course archived</span>
                                @endif
                            </td>

                            <!-- Issue Date -->
                            <td>
                                <span class="text-dark fs-13 fw-medium">
                                    {{ $certificate->issued_at ? $certificate->issued_at->format('M d, Y') : $certificate->created_at->format('M d, Y') }}
                                </span>
                                <span class="text-muted text-xs d-block">
                                    {{ $certificate->issued_at ? $certificate->issued_at->diffForHumans() : $certificate->created_at->diffForHumans() }}
                                </span>
                            </td>

                            <!-- Status Badge -->
                            <td class="text-center">
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 text-xs fw-semibold">
                                    <i class="ri-checkbox-circle-fill me-0.5"></i> Active
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="text-end pe-4">
                                <div class="d-inline-flex align-items-center gap-1.5">
                                    <!-- Public Verify Link -->
                                    <a href="{{ route('certificates.verify', $certificate->share_token) }}" target="_blank" class="btn-larkon-action btn-larkon-view" title="Open Public Verification Link">
                                        <i class="ri-external-link-line"></i>
                                    </a>

                                    <!-- PDF Download -->
                                    <a href="{{ route('certificates.pdf', $certificate->id) }}" class="btn-larkon-action btn-larkon-edit" title="Download Official PDF">
                                        <i class="ri-file-download-line"></i>
                                    </a>

                                    <!-- Details Modal Trigger -->
                                    <button type="button" class="btn-larkon-action btn-larkon-lessons" data-bs-toggle="modal" data-bs-target="#certModal{{ $certificate->id }}" title="Certificate Details &amp; Social Links">
                                        <i class="ri-eye-line"></i>
                                    </button>

                                    <!-- Revoke Modal Trigger -->
                                    <button type="button" class="btn-larkon-action btn-larkon-delete" data-bs-toggle="modal" data-bs-target="#revokeModal{{ $certificate->id }}" title="Revoke Certificate">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>

                                <!-- Details Modal -->
                                <div class="modal fade text-start" id="certModal{{ $certificate->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                            <div class="modal-header bg-light border-bottom px-4 py-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="ri-award-fill text-warning fs-4"></i>
                                                    <h5 class="modal-title fw-bold text-dark fs-16 mb-0">Certificate Details</h5>
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body p-4">
                                                <div class="text-center pb-3 mb-3 border-bottom">
                                                    <span class="text-xs text-muted text-uppercase fw-semibold">Certificate Serial</span>
                                                    <h4 class="fw-bold font-monospace text-dark mb-1">{{ $certificate->certificate_number }}</h4>
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5 text-xs">
                                                        <i class="ri-shield-check-fill me-0.5"></i> Authenticated Credential
                                                    </span>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="text-xs text-muted fw-semibold mb-1">RECIPIENT</label>
                                                    <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-light">
                                                        <span class="fw-semibold text-dark fs-14">{{ $user->name ?? 'N/A' }}</span>
                                                        <span class="text-muted text-xs">{{ $user->email ?? '' }}</span>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="text-xs text-muted fw-semibold mb-1">COMPLETED COURSE</label>
                                                    <div class="p-2.5 rounded-3 bg-light">
                                                        <span class="fw-semibold text-dark fs-14 d-block">{{ $course->title ?? 'N/A' }}</span>
                                                        <span class="text-muted text-xs">Issued on {{ $certificate->issued_at ? $certificate->issued_at->format('F d, Y') : 'N/A' }}</span>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="text-xs text-muted fw-semibold mb-1">PUBLIC VERIFICATION LINK</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control bg-light font-monospace text-xs" value="{{ $certificate->share_url }}" readonly id="certUrl{{ $certificate->id }}">
                                                        <button class="btn btn-outline-secondary" type="button" onclick="navigator.clipboard.writeText('{{ $certificate->share_url }}'); this.innerHTML='Copied!'; setTimeout(() => this.innerHTML='Copy', 1500);">
                                                            Copy
                                                        </button>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label class="text-xs text-muted fw-semibold mb-2">STUDENT SHARE LINKS</label>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <a href="{{ $certificate->linkedin_share_url }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-xs">
                                                            <i class="ri-linkedin-fill me-1"></i> LinkedIn
                                                        </a>
                                                        <a href="{{ $certificate->twitter_share_url }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-3 text-xs">
                                                            <i class="ri-twitter-x-fill me-1"></i> X / Twitter
                                                        </a>
                                                        <a href="{{ $certificate->whatsapp_share_url }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 text-xs">
                                                            <i class="ri-whatsapp-fill me-1"></i> WhatsApp
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer bg-light px-4 py-2.5 justify-content-between">
                                                <a href="{{ route('certificates.pdf', $certificate->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 text-xs">
                                                    <i class="ri-download-2-line me-1"></i> Download PDF
                                                </a>
                                                <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3 text-xs" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Revoke Confirmation Modal -->
                                <div class="modal fade text-start" id="revokeModal{{ $certificate->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                            <div class="modal-header border-0 pb-0">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center px-4 pt-0 pb-4">
                                                <div class="rounded-circle bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                                                    <i class="ri-alert-line fs-2"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark mb-1">Revoke Certificate?</h5>
                                                <p class="text-muted text-xs mb-3">
                                                    Are you sure you want to permanently revoke certificate <strong class="font-monospace text-dark">{{ $certificate->certificate_number }}</strong>? The public verification link will no longer function.
                                                </p>
                                                <form action="{{ route('admin.certificates.destroy', $certificate->id) }}" method="POST" class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                                        <button type="button" class="btn btn-sm btn-light rounded-pill px-3 text-xs" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3 text-xs">Yes, Revoke</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                        <i class="ri-award-line fs-2 text-muted"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-1">No certificates found</h5>
                                    <p class="text-muted text-xs mb-0">No certificates have been issued yet, or none match your search criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($certificates->hasPages())
            <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span class="text-xs text-muted">
                    Showing {{ $certificates->firstItem() ?? 0 }} to {{ $certificates->lastItem() ?? 0 }} of {{ $certificates->total() }} certificates
                </span>
                <div>
                    {{ $certificates->links('pagination::bootstrap-5') }}
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

    /* 1. Public Verify Link (Purple) */
    .btn-larkon-view {
        background-color: #f5f3ff !important;
        border-color: #ede9fe !important;
        color: #7c3aed !important;
    }
    .btn-larkon-view:hover {
        background-color: #7c3aed !important;
        border-color: #7c3aed !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3) !important;
    }

    /* 2. Download PDF (Brand Blue) */
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

    /* 3. Details Modal (Green) */
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

    /* 4. Revoke / Delete (Rose / Red) */
    .btn-larkon-delete {
        background-color: #fef2f2 !important;
        border-color: #fee2e2 !important;
        color: #dc2626 !important;
    }
    .btn-larkon-delete:hover {
        background-color: #dc2626 !important;
        border-color: #dc2626 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3) !important;
    }
</style>
@endsection
