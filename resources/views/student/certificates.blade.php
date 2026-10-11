@extends('layouts.student-dash')

@section('title', 'Certificates — Edudash LMS')

@section('content')
<!-- ========================================== -->
<!-- BREADCRUMB & HEADER -->
<!-- ========================================== -->
<div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <div>
        <h1 class="fw-semibold mb-4 h6 text-primary-light">Certificate</h1>
        <div class="text-xs">
            <a href="{{ route('student.dashboard') }}" class="text-secondary-light hover-text-primary hover-underline">Dashboard</a>
            <span class="text-secondary-light">/ Certificate</span>
        </div>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-success-subtle text-success px-12 py-8 rounded-pill fw-semibold text-xs d-inline-flex align-items-center gap-1">
            <i class="ri-shield-check-fill"></i> QR Verifiable
        </span>
        <a href="{{ route('courses.index') }}" class="btn btn-primary-600 btn-sm radius-8 d-flex align-items-center gap-6 px-16 py-8 fw-semibold">
            <i class="ri-compass-3-line"></i> Browse Catalog
        </a>
    </div>
</div>

<!-- ========================================== -->
<!-- 10-BADGE MILESTONE: 1 MONTH FREE DATA REWARD BANNER -->
<!-- ========================================== -->
@if(isset($milestoneProgress))
    @php
        $mReward = $milestoneProgress['reward'] ?? null;
        $badgeCount = $milestoneProgress['badge_count'] ?? $certificates->total();
        $targetGoal = $milestoneProgress['target'] ?? 10;
        $progressPct = $milestoneProgress['percentage'] ?? min(100, round(($badgeCount / 10) * 100));
        $remainingBadges = $milestoneProgress['remaining'] ?? max(0, 10 - $badgeCount);
    @endphp

    <div class="card border-0 shadow-1 radius-16 mb-24 overflow-hidden position-relative" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #334155 100%); color: #fff;">
        <div class="card-body p-20 position-relative" style="z-index: 2;">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="w-48-px h-48-px rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center fs-4 flex-shrink-0">
                        <i class="ri-wifi-line"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge px-10 py-4 rounded-pill text-xxs fw-bold text-uppercase" style="background: rgba(251, 191, 36, 0.2); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.4);">
                                10-Badge Milestone
                            </span>
                            <span class="text-xs text-white-50">1 Month Free Data Subscription</span>
                        </div>
                        <h6 class="fw-bold text-white mb-0 fs-6">
                            @if($badgeCount >= $targetGoal)
                                🏆 Milestone Achieved: {{ $badgeCount }}/{{ $targetGoal }} Badges!
                            @else
                                Earn {{ $targetGoal }} Verified Badges &rarr; Get 1 Month Free Mobile Data ({{ $badgeCount }}/{{ $targetGoal }} Earned)
                            @endif
                        </h6>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div style="min-width: 140px;" class="d-none d-sm-block">
                        <div class="d-flex justify-content-between text-xxs mb-1 text-white-50">
                            <span>Progress</span>
                            <span class="fw-bold text-warning">{{ $progressPct }}%</span>
                        </div>
                        <div class="progress" style="height: 6px; background-color: rgba(255, 255, 255, 0.2); border-radius: 999px;">
                            <div class="progress-bar bg-warning" style="width: {{ $progressPct }}%; border-radius: 999px;"></div>
                        </div>
                    </div>

                    @if($badgeCount >= $targetGoal)
                        @if(!$mReward || $mReward->isUnlocked())
                            <a href="{{ route('student.dashboard') }}" class="btn btn-warning text-dark btn-sm radius-8 fw-bold px-16 py-8 d-inline-flex align-items-center gap-1">
                                <i class="ri-gift-fill"></i> Claim Data Reward
                            </a>
                        @elseif($mReward->isClaimed())
                            <span class="badge bg-primary text-white text-xs px-12 py-8 rounded-pill">
                                <i class="ri-time-line me-1"></i> Queued for Credit ({{ $mReward->network_provider }})
                            </span>
                        @elseif($mReward->isFulfilled())
                            <span class="badge bg-success text-white text-xs px-12 py-8 rounded-pill">
                                <i class="ri-checkbox-circle-line me-1"></i> 1 Month Data Credited
                            </span>
                        @endif
                    @else
                        <span class="badge bg-white bg-opacity-20 text-white text-xs px-12 py-8 rounded-pill">
                            {{ $remainingBadges }} more {{ Str::plural('badge', $remainingBadges) }} to go
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

<!-- ========================================== -->
<!-- CERTIFICATE DATA TABLE CONTAINER -->
<!-- ========================================== -->
<div class="card h-100 border-0 shadow-1 radius-16 bg-white">
    <div class="card-body p-0 dataTable-wrapper">

        <!-- Table Toolbar (Export, Search, Count) -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-16 px-20 py-16 border-bottom border-neutral-200">
            <div class="d-flex flex-wrap align-items-center gap-16">
                <!-- Search Form -->
                <form method="GET" action="{{ route('student.certificates') }}" class="navbar-search dt-search m-0">
                    <input type="text" name="search" value="{{ request('search') }}" class="dt-input bg-transparent radius-4" placeholder="Search course or certificate ID...">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
            </div>
            
            <div class="d-flex align-items-center gap-12 text-secondary-light text-xs">
                <span class="badge bg-neutral-100 text-neutral-700 px-12 py-6 rounded-pill fw-semibold">
                    Total: <strong class="text-dark">{{ $certificates->total() }}</strong> {{ Str::plural('Certificate', $certificates->total()) }}
                </span>
            </div>
        </div>

        <!-- Table View -->
        <div class="p-0 table-responsive" style="min-height: 280px; padding-bottom: 24px;">
            <table class="table bordered-table mb-0 align-middle" id="dataTable" style="min-width: 960px;">
                <thead>
                    <tr class="bg-neutral-50 text-xs text-secondary-light text-uppercase fw-semibold">
                        <th scope="col" class="py-14 px-16" style="width: 70px; min-width: 70px;">
                            <div class="form-check style-check d-flex align-items-center">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">S.L</label>
                            </div>
                        </th>
                        <th scope="col" class="py-14 px-16" style="min-width: 200px;">Name</th>
                        <th scope="col" class="py-14 px-16" style="min-width: 260px;">Class / Course</th>
                        <th scope="col" class="py-14 px-16" style="min-width: 240px;">Certificate Name</th>
                        <th scope="col" class="py-14 px-16 text-center" style="width: 140px; min-width: 140px;">Background Image</th>
                        <th scope="col" class="py-14 px-16 text-end" style="min-width: 190px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($certificates as $cert)
                        @php
                            $student = $cert->enrollment->user;
                            $course = $cert->enrollment->course;
                        @endphp
                        <tr>
                            <!-- Serial Number -->
                            <td class="py-16 px-16">
                                <div class="form-check style-check d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</label>
                                </div>
                            </td>

                            <!-- Student Name & Avatar -->
                            <td class="py-16 px-16">
                                <div class="d-flex align-items-center">
                                    <div class="w-40-px h-40-px rounded-circle bg-primary-600 text-white d-flex align-items-center justify-content-center fw-bold fs-6 flex-shrink-0 me-12 shadow-xs">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                    <div class="text-truncate">
                                        <h6 class="text-sm mb-0 fw-semibold text-primary-light text-truncate">{{ $student->name }}</h6>
                                        <span class="text-xs text-secondary-light d-block">ID: <span class="fw-semibold font-monospace">#ATB-{{ str_pad($student->id, 5, '0', STR_PAD_LEFT) }}</span></span>
                                    </div>
                                </div>
                            </td>

                            <!-- Course / Class -->
                            <td class="py-16 px-16">
                                <span class="fw-medium text-primary-light d-block text-truncate" style="max-width: 280px;" title="{{ $course->title }}">{{ $course->title }}</span>
                                <span class="badge bg-primary-subtle text-primary text-xs">{{ $course->level ?? 'All Levels' }} &bull; {{ $course->duration_hours }} hrs</span>
                            </td>

                            <!-- Certificate Title & Issued Date -->
                            <td class="py-16 px-16">
                                <span class="fw-semibold text-dark d-block">Certificate of Completion</span>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <span class="badge bg-neutral-100 text-neutral-700 font-monospace text-xs">{{ $cert->certificate_number }}</span>
                                    <span class="text-xxs text-secondary-light"><i class="ri-calendar-line me-1"></i>{{ $cert->issued_at->format('M d, Y') }}</span>
                                </div>
                            </td>

                            <!-- Background / Certificate Preview Image -->
                            <td class="py-16 px-16 text-center">
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#certModal{{ $cert->id }}" class="d-inline-block transition-all hover-scale" title="Click to preview certificate">
                                    <img src="{{ asset('dash/assets/images/thumbs/certificate-img.png') }}" alt="Certificate Template Image" class="radius-8 shadow-xs border" style="max-height: 48px; width: auto;">
                                </a>
                            </td>

                            <!-- Action Group & Dropdown -->
                            <td class="py-16 px-16 text-end">
                                <div class="d-inline-flex align-items-center justify-content-end gap-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm radius-8 px-10 py-6 d-inline-flex align-items-center gap-1 text-xs fw-semibold" data-bs-toggle="modal" data-bs-target="#certModal{{ $cert->id }}" title="View Certificate">
                                        <i class="ri-eye-line"></i> View
                                    </button>
                                    <a href="{{ route('certificates.pdf', $cert->id) }}" class="btn btn-outline-success btn-sm radius-8 px-10 py-6 d-inline-flex align-items-center gap-1 text-xs fw-semibold" title="Download PDF">
                                        <i class="ri-printer-line"></i> PDF
                                    </a>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-outline-neutral-300 btn-sm radius-8 px-8 py-6 text-secondary-light bg-hover-neutral-100 d-inline-flex align-items-center" data-bs-toggle="dropdown" data-bs-boundary="viewport" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" title="More Actions">
                                            <iconify-icon icon="tabler:dots-vertical" class="fs-6"></iconify-icon>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border p-12 radius-12 shadow-lg" style="z-index: 1060; min-width: 200px;">
                                            <li>
                                                <button type="button" class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-2 py-6" data-bs-toggle="modal" data-bs-target="#certModal{{ $cert->id }}">
                                                    <i class="ri-eye-line text-primary"></i> View in Modal
                                                </button>
                                            </li>
                                            <li>
                                                <a href="{{ route('certificates.pdf', $cert->id) }}" class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-2 py-6">
                                                    <i class="ri-printer-line text-success"></i> Print / Download PDF
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('certificates.verify', $cert->share_token) }}" target="_blank" class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-2 py-6">
                                                    <i class="ri-external-link-line text-info"></i> Public Verification
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-48 bg-neutral-50">
                                <div class="w-64-px h-64-px rounded-circle bg-warning-subtle text-warning mx-auto d-flex align-items-center justify-content-center fs-2 mb-16 shadow-sm">
                                    <i class="ri-award-line"></i>
                                </div>
                                <h6 class="fw-bold text-primary-light mb-4">No Certificates Earned Yet</h6>
                                <p class="text-secondary-light text-sm mb-16 max-w-400-px mx-auto">Complete all video lessons in any enrolled masterclass and pass the final exam to generate your official verified certificate and badge.</p>
                                <a href="{{ route('courses.index') }}" class="btn btn-primary-600 btn-sm radius-8 px-20 py-10 fw-semibold">
                                    <i class="ri-compass-3-line me-1"></i> Browse Course Catalog
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($certificates->hasPages())
            <div class="px-20 py-16 border-top">
                {{ $certificates->links() }}
            </div>
        @endif
    </div>
</div>

<!-- ========================================== -->
<!-- VIEW CERTIFICATE MODALS -->
<!-- ========================================== -->
@foreach($certificates as $cert)
    @php
        $student = $cert->enrollment->user;
        $course = $cert->enrollment->course;
    @endphp
    <div class="modal fade" id="certModal{{ $cert->id }}" tabindex="-1" aria-labelledby="certModalLabel{{ $cert->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg radius-16 overflow-hidden">
                <div class="modal-header bg-primary-600 text-white p-20 border-0">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ri-award-fill fs-4"></i>
                        <div>
                            <h6 class="modal-title fw-bold text-white mb-0" id="certModalLabel{{ $cert->id }}">{{ $course->title }}</h6>
                            <span class="text-xs opacity-75 font-monospace">Certificate #{{ $cert->certificate_number }}</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-24 text-center bg-light">
                    <!-- Certificate Styled Showcase Card -->
                    <div class="p-32 rounded-3 bg-white border shadow-sm mx-auto position-relative" style="max-width: 680px; border: 8px solid #0F172A !important; outline: 2px dashed #D97706; outline-offset: -5px;">
                        <div class="text-warning fs-1 mb-8">
                            <i class="ri-award-fill"></i>
                        </div>
                        <h6 class="text-xs text-uppercase text-secondary-light letter-spacing-3 mb-4 fw-bold">AUTHORITY LEARNING & EDUCATION FOUNDATION</h6>
                        <h3 class="fw-bold text-dark mb-4" style="font-family: Georgia, serif;">CERTIFICATE OF COMPLETION</h3>
                        <p class="text-xs text-secondary-light mb-12">This is to officially certify that</p>
                        <h4 class="fw-bold text-primary mb-12" style="font-family: Georgia, serif; text-decoration: underline; text-decoration-color: #F59E0B;">
                            {{ $student->name }}
                        </h4>
                        <p class="text-secondary-light text-xs mx-auto mb-16" style="max-width: 480px;">
                            has successfully completed all required modules, progressive assessments, and honors examination for
                        </p>
                        <div class="p-12 bg-light rounded-3 d-inline-block px-24 mb-16 border">
                            <h6 class="fw-bold text-dark mb-0">{{ $course->title }}</h6>
                            <span class="text-xxs text-secondary-light">{{ $course->duration_hours }} Credit Hours &bull; Authority Masterclass</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between pt-16 border-top text-start text-xs text-secondary-light">
                            <div>
                                <span class="d-block fw-bold text-dark">{{ $course->tutor->name ?? 'Dr. Jane Mitchell' }}</span>
                                <span class="text-xxs">Director of Curriculum</span>
                            </div>
                            <div class="text-center">
                                <span class="badge bg-success-subtle text-success text-xxs px-8 py-4 rounded-pill fw-bold">
                                    <i class="ri-shield-check-fill me-1"></i> QR Verified
                                </span>
                            </div>
                            <div class="text-end">
                                <span class="d-block fw-bold text-dark">{{ $cert->issued_at->format('M d, Y') }}</span>
                                <span class="text-xxs">Date of Issue</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-white p-16 border-top d-flex justify-content-between">
                    <a href="{{ route('certificates.verify', $cert->share_token) }}" target="_blank" class="btn btn-outline-primary btn-sm radius-8 px-16 fw-semibold">
                        <i class="ri-external-link-line me-1"></i> Public Verification Page
                    </a>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-secondary btn-sm radius-8 px-16" data-bs-dismiss="modal">Close</button>
                        <a href="{{ route('certificates.pdf', $cert->id) }}" class="btn btn-success btn-sm radius-8 px-16 fw-bold">
                            <i class="ri-download-2-line me-1"></i> Download Official PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
