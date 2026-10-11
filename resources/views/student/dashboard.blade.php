@extends('layouts.student-dash')

@section('title', 'Student Learning Dashboard')

@section('content')
<!-- Welcome Header -->
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-20">
    <div>
        <h4 class="fw-bold mb-1 fs-5 text-dark">Welcome back, {{ auth()->user()->name }}! 👋</h4>
        <p class="text-secondary-light text-xs mb-0">Track your discipleship progress, video stream lessons, and earned credentials.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm radius-12 d-flex align-items-center gap-2 mb-20" role="alert" style="background-color: #ecfdf5; color: #065f46;">
        <i class="ri-checkbox-circle-fill fs-5 text-success"></i>
        <div class="fw-medium text-sm">{{ session('success') }}</div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm radius-12 d-flex align-items-center gap-2 mb-20" role="alert">
        <i class="ri-information-fill fs-5 text-info"></i>
        <div class="fw-medium text-sm">{{ session('info') }}</div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm radius-12 d-flex align-items-center gap-2 mb-20" role="alert">
        <i class="ri-error-warning-fill fs-5 text-danger"></i>
        <div class="fw-medium text-sm">{{ session('error') }}</div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- ================================================= -->
<!-- CONTINUE WHERE YOU STOPPED LEARNING (ONLY SESSION) -->
<!-- ================================================= -->
@php
    $activeEnrollment = $enrollments->first(fn($e) => $e->status !== 'completed') ?? $enrollments->first();
    $activeCourse = $activeEnrollment?->course;
    $nextLesson = $activeCourse 
        ? ($activeCourse->lessons->first(fn($l) => !$activeEnrollment->isLessonCompleted($l->id)) ?? $activeCourse->lessons->first()) 
        : null;
    $activeProgress = $activeEnrollment ? $activeEnrollment->progress_percentage : 0;
@endphp

@push('styles')
<style>
    .continue-learning-card {
        padding: 16px !important;
    }
    @media (min-width: 768px) {
        .continue-learning-card {
            padding: 24px !important;
        }
    }
    .continue-learning-icon {
        width: 44px;
        height: 44px;
        font-size: 1.25rem;
    }
    @media (min-width: 576px) {
        .continue-learning-icon {
            width: 56px;
            height: 56px;
            font-size: 1.75rem;
        }
    }
    .continue-learning-btn-wrap {
        width: 100%;
    }
    @media (min-width: 992px) {
        .continue-learning-btn-wrap {
            width: auto;
        }
    }
</style>
@endpush

@if($nextLesson && $activeCourse)
    <div class="card border-0 shadow-1 radius-16 bg-white continue-learning-card mb-24 overflow-hidden">
        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3 gap-lg-4">
            <div class="d-flex align-items-start gap-2 gap-sm-3 flex-grow-1 w-100 min-w-0" style="min-width: 0;">
                <div class="continue-learning-icon rounded-3 bg-primary-600 text-white d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm">
                    <i class="ri-play-circle-fill"></i>
                </div>
                <div class="flex-grow-1 min-w-0" style="min-width: 0;">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <span class="badge bg-warning text-dark text-xs fw-bold px-10 py-4 rounded-pill text-nowrap">
                            <i class="ri-history-line me-1"></i> <span class="d-none d-sm-inline">CONTINUE WHERE YOU STOPPED </span>CONTINUE LEARNING
                        </span>
                        <span class="badge bg-primary-subtle text-primary text-xs text-nowrap">Lesson {{ $nextLesson->sort_order }} of {{ $activeCourse->lessons->count() }}</span>
                    </div>
                    <h5 class="fw-bold text-primary-light mb-2 fs-6 fs-sm-5" style="line-height: 1.35;">{{ $nextLesson->title }}</h5>
                    <div class="text-xs text-secondary-light d-flex flex-wrap align-items-center gap-2 gap-sm-3 mb-3">
                        <span class="d-inline-flex align-items-center text-truncate" style="max-width: 100%;">
                            <i class="ri-book-open-line text-primary-600 me-1"></i> {{ $activeCourse->title }}
                        </span>
                        <span class="d-none d-sm-inline text-muted">&bull;</span>
                        <span class="d-inline-flex align-items-center text-nowrap">
                            <i class="ri-time-line me-1"></i> {{ $nextLesson->video_duration_minutes }} mins
                        </span>
                        <span class="d-none d-sm-inline text-muted">&bull;</span>
                        <span class="d-inline-flex align-items-center text-nowrap">
                            <i class="ri-lock-line me-1 text-warning"></i> DRM Protected
                        </span>
                    </div>
                    <!-- Progress bar -->
                    <div class="d-flex align-items-center gap-2 gap-sm-3 w-100" style="max-width: 500px;">
                        <div class="progress h-8-px radius-8 bg-neutral-200 flex-grow-1 overflow-hidden" style="min-width: 50px;">
                            <div class="progress-bar bg-primary-600 rounded-pill transition-all" role="progressbar" style="width: {{ $activeProgress }}%" aria-valuenow="{{ $activeProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="text-xs fw-bold text-primary-600 font-monospace text-nowrap flex-shrink-0">{{ $activeProgress }}% complete</span>
                    </div>
                </div>
            </div>
            <div class="continue-learning-btn-wrap text-lg-end flex-shrink-0 mt-2 mt-lg-0">
                <a href="{{ route('student.lesson.show', [$activeCourse->slug, $nextLesson->slug]) }}" class="btn btn-primary-600 btn-md radius-8 px-20 px-sm-24 py-12 fw-bold d-flex d-lg-inline-flex justify-content-center align-items-center gap-2 shadow-sm w-100">
                    <i class="ri-play-mini-fill fs-4"></i> Resume Lesson
                </a>
            </div>
        </div>
    </div>
@else
     
@endif

<!-- ========================================== -->
<!-- KPI STAT METRICS (EDUDASH GRADIENT CARDS) -->
<!-- ========================================== -->
<div class="row gy-4 mb-24">
    <!-- Enrolled Courses -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card shadow-1 radius-12 gradient-bg-end-1 border-0 h-100 transition-all hover-translate-y">
            <div class="card-body p-20">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                    <div class="w-44-px h-44-px bg-warning-600 rounded-circle d-flex justify-content-center align-items-center shadow-sm">
                        <img src="{{ asset('dash/assets/images/icons/dashboard-icon1.png') }}" alt="Enrolled Icon">
                    </div>
                    <p class="fw-semibold text-primary-light mb-0 text-sm">Enrolled Courses</p>
                </div>
                <h4 class="mb-0 fw-bold text-dark">{{ $enrollments->count() }}</h4>
                <p class="fw-medium text-xs text-secondary-light mt-12 mb-0 d-flex align-items-center gap-2">
                    <span class="d-inline-flex align-items-center gap-1 text-primary-600 text-xs fw-semibold">
                        <i class="ri-book-open-line"></i> Masterclasses
                    </span>
                    Active curriculum
                </p>
            </div>
        </div>
    </div>

    <!-- In Progress -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card shadow-1 radius-12 gradient-bg-end-2 border-0 h-100 transition-all hover-translate-y">
            <div class="card-body p-20">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                    <div class="w-44-px h-44-px bg-blue-600 rounded-circle d-flex justify-content-center align-items-center shadow-sm">
                        <img src="{{ asset('dash/assets/images/icons/dashboard-icon2.png') }}" alt="In Progress Icon">
                    </div>
                    <p class="fw-semibold text-primary-light mb-0 text-sm">In Progress</p>
                </div>
                <h4 class="mb-0 fw-bold text-dark">{{ $inProgressCount }}</h4>
                <p class="fw-medium text-xs text-secondary-light mt-12 mb-0 d-flex align-items-center gap-2">
                    <span class="d-inline-flex align-items-center gap-1 text-blue-600 text-xs fw-semibold">
                        <i class="ri-play-circle-line"></i> Video Stream
                    </span>
                    Continuous study
                </p>
            </div>
        </div>
    </div>

    <!-- Completed -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card shadow-1 radius-12 gradient-bg-end-3 border-0 h-100 transition-all hover-translate-y">
            <div class="card-body p-20">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                    <div class="w-44-px h-44-px bg-purple-600 rounded-circle d-flex justify-content-center align-items-center shadow-sm">
                        <img src="{{ asset('dash/assets/images/icons/dashboard-icon3.png') }}" alt="Completed Icon">
                    </div>
                    <p class="fw-semibold text-primary-light mb-0 text-sm">Completed</p>
                </div>
                <h4 class="mb-0 fw-bold text-dark">{{ $completedCount }}</h4>
                <p class="fw-medium text-xs text-secondary-light mt-12 mb-0 d-flex align-items-center gap-2">
                    <span class="d-inline-flex align-items-center gap-1 text-purple-600 text-xs fw-semibold">
                        <i class="ri-checkbox-circle-line"></i> Exam Passed
                    </span>
                    100% finished
                </p>
            </div>
        </div>
    </div>

    <!-- Verified Badges & Certs -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card shadow-1 radius-12 gradient-bg-end-4 border-0 h-100 transition-all hover-translate-y">
            <div class="card-body p-20">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                    <div class="w-44-px h-44-px bg-primary-600 rounded-circle d-flex justify-content-center align-items-center shadow-sm">
                        <img src="{{ asset('dash/assets/images/icons/dashboard-icon4.png') }}" alt="Badges Icon">
                    </div>
                    <p class="fw-semibold text-primary-light mb-0 text-sm">Verified Badges</p>
                </div>
                <h4 class="mb-0 fw-bold text-dark">
                    {{ $milestoneProgress['badge_count'] ?? $certificates->count() }}
                    <span class="text-xs text-secondary-light fw-normal">/ 10 Milestone</span>
                </h4>
                <p class="fw-medium text-xs text-secondary-light mt-12 mb-0 d-flex align-items-center gap-2">
                    <span class="d-inline-flex align-items-center gap-1 text-success-600 text-xs fw-semibold">
                        <i class="ri-award-fill"></i> QR Verifiable
                    </span>
                    Digital credentials
                </p>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- 10-BADGE MILESTONE: 1 MONTH FREE DATA REWARD -->
<!-- ========================================== -->
@php
    $mReward = $milestoneProgress['reward'] ?? null;
    $badgeCount = $milestoneProgress['badge_count'] ?? $certificates->count();
    $targetGoal = $milestoneProgress['target'] ?? 10;
    $progressPct = $milestoneProgress['percentage'] ?? min(100, round(($badgeCount / 10) * 100));
    $remainingBadges = $milestoneProgress['remaining'] ?? max(0, 10 - $badgeCount);
@endphp

<div class="card border-0 shadow-1 radius-16 mb-32 overflow-hidden position-relative" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #334155 100%); color: #fff;">
    <div class="position-absolute end-0 top-0 bottom-0 d-none d-lg-flex align-items-center pe-4 opacity-25" style="pointer-events: none;">
        <i class="ri-wifi-line text-white" style="font-size: 11rem; line-height: 1; transform: rotate(15deg);"></i>
    </div>
    <div class="card-body p-24 position-relative" style="z-index: 2;">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-12">
                    <span class="badge px-12 py-6 rounded-pill text-xs fw-bold text-uppercase d-inline-flex align-items-center gap-1"
                          style="background: rgba(251, 191, 36, 0.2); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.4);">
                        <i class="ri-medal-fill"></i> Milestone Challenge
                    </span>
                    @if($mReward && $mReward->isFulfilled())
                        <span class="badge bg-success text-white px-12 py-6 rounded-pill text-xs fw-semibold">
                            <i class="ri-check-double-line"></i> Rewarded &amp; Active
                        </span>
                    @elseif($mReward && $mReward->isClaimed())
                        <span class="badge bg-primary text-white px-12 py-6 rounded-pill text-xs fw-semibold">
                            <i class="ri-time-line"></i> Claim Received &bull; Crediting In Progress
                        </span>
                    @elseif($badgeCount >= $targetGoal)
                        <span class="badge bg-warning text-dark px-12 py-6 rounded-pill text-xs fw-bold">
                            <i class="ri-gift-fill"></i> Unlocked! Claim Now
                        </span>
                    @else
                        <span class="badge bg-white bg-opacity-25 text-white px-12 py-6 rounded-pill text-xs">
                            {{ $remainingBadges }} {{ Str::plural('Badge', $remainingBadges) }} to Unlock
                        </span>
                    @endif
                </div>

                <h4 class="fw-bold text-white mb-8 fs-5">
                    Complete 10 Courses &amp; Earn 10 Badges &rarr; Get 1 Month Free Data Subscription 📶⚡
                </h4>
                <p class="text-white-50 text-xs mb-16" style="max-width: 600px;">
                    Boost your digital journey! When you complete 10 courses and earn 10 verified digital badges, we celebrate your learning achievement with <strong>1 Month of Free Internet Data</strong> on MTN, Airtel, Glo, or 9mobile.
                </p>

                <!-- Milestone Progress Bar -->
                <div class="mb-12" style="max-width: 520px;">
                    <div class="d-flex justify-content-between align-items-center text-xs mb-6">
                        <span class="text-white-50">Milestone Progress:</span>
                        <span class="fw-bold text-warning font-monospace">{{ $badgeCount }} / {{ $targetGoal }} Badges ({{ $progressPct }}%)</span>
                    </div>
                    <div class="progress" style="height: 10px; background-color: rgba(255, 255, 255, 0.15); border-radius: 999px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                             role="progressbar"
                             style="width: {{ $progressPct }}%; border-radius: 999px;"
                             aria-valuenow="{{ $progressPct }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>

                @if($mReward && $mReward->isFulfilled())
                    <div class="d-inline-flex align-items-center gap-2 p-12 radius-10 bg-success bg-opacity-25 border border-success border-opacity-50 text-xs text-white">
                        <i class="ri-checkbox-circle-fill text-success fs-5"></i>
                        <div>
                            <strong>Free Data Credited:</strong> 1-Month bundle sent to <strong>{{ $mReward->network_provider }}</strong> ({{ $mReward->phone_number }}).
                            @if($mReward->admin_notes)<div class="text-xxs text-white-50 mt-1">Ref: {{ $mReward->admin_notes }}</div>@endif
                        </div>
                    </div>
                @elseif($mReward && $mReward->isClaimed())
                    <div class="d-inline-flex align-items-center gap-2 p-12 radius-10 bg-primary bg-opacity-25 border border-primary border-opacity-50 text-xs text-white">
                        <i class="ri-time-fill text-primary-light fs-5"></i>
                        <div>
                            <strong>Claim Queued:</strong> Submitted for <strong>{{ $mReward->network_provider }}</strong> ({{ $mReward->phone_number }}). Admin is processing your data credit!
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4 text-lg-end">
                @if($badgeCount >= $targetGoal)
                    @if(!$mReward || $mReward->isUnlocked())
                        <button type="button" class="btn btn-warning text-dark fw-bold px-24 py-12 radius-12 shadow-lg d-inline-flex align-items-center gap-2"
                                data-bs-toggle="modal" data-bs-target="#claimDataRewardModal">
                            <i class="ri-gift-fill fs-5"></i> Claim Your 1-Month Free Data
                        </button>
                        <p class="text-white-50 text-xxs mt-2 mb-0">Select your network &amp; mobile number</p>
                    @elseif($mReward->isClaimed())
                        <div class="p-16 radius-12 bg-white bg-opacity-10 text-start d-inline-block">
                            <div class="text-xs text-white-50 mb-1">Beneficiary Number:</div>
                            <div class="fw-bold text-white fs-6 mb-2">{{ $mReward->network_provider }} &bull; {{ $mReward->phone_number }}</div>
                            <span class="badge bg-primary text-white text-xxs px-8 py-4 rounded-pill">
                                <i class="ri-refresh-line me-1"></i> Awaiting Crediting
                            </span>
                        </div>
                    @elseif($mReward->isFulfilled())
                        <div class="p-16 radius-12 bg-success bg-opacity-20 text-start d-inline-block border border-success border-opacity-30">
                            <div class="text-xs text-success-light mb-1">Status:</div>
                            <div class="fw-bold text-white fs-6 mb-2">1 Month Active</div>
                            <span class="badge bg-success text-white text-xxs px-8 py-4 rounded-pill">
                                <i class="ri-check-line me-1"></i> Credited by Admin
                            </span>
                        </div>
                    @endif
                @else
                    <div class="text-center text-lg-end">
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-light px-20 py-10 radius-10 text-xs fw-semibold d-inline-flex align-items-center gap-2">
                            <i class="ri-compass-line"></i> Browse Courses to Reach Goal
                        </a>
                        <p class="text-white-50 text-xxs mt-2 mb-0">{{ $remainingBadges }} more masterclasses needed</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Claim Modal -->
@if($mReward && $mReward->isUnlocked())
    <div class="modal fade" id="claimDataRewardModal" tabindex="-1" aria-labelledby="claimDataRewardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 border-0 shadow-lg">
                <form method="POST" action="{{ route('student.rewards.claim', $mReward->id) }}">
                    @csrf
                    <div class="modal-header border-0 pb-0 pt-24 px-24">
                        <div class="d-flex align-items-center gap-3">
                            <div class="w-48-px h-48-px rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center fs-4 flex-shrink-0">
                                <i class="ri-wifi-line"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="claimDataRewardModalLabel">Claim 1-Month Free Data</h5>
                                <span class="text-xs text-muted">10-Badge Milestone Celebration Reward</span>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-24">
                        <div class="p-16 radius-12 mb-20" style="background-color: #fffbeb; border: 1px solid #fef3c7;">
                            <div class="d-flex gap-2">
                                <i class="ri-sparkling-fill text-warning fs-5 flex-shrink-0"></i>
                                <p class="text-xs text-dark mb-0 leading-relaxed">
                                    Congratulations on completing 10 courses &amp; earning 10 badges! Choose your network and enter your phone number to receive your <strong>1 Month Free Data Subscription</strong>.
                                </p>
                            </div>
                        </div>

                        <!-- Mobile Network Provider -->
                        <div class="mb-20">
                            <label class="form-label text-xs fw-bold text-dark text-uppercase mb-8">
                                Select Mobile Network Provider <span class="text-danger">*</span>
                            </label>
                            <div class="row g-2">
                                @foreach(['MTN', 'Airtel', 'Glo', '9mobile'] as $network)
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="network_provider" id="net_{{ $network }}" value="{{ $network }}" required {{ $loop->first ? 'checked' : '' }}>
                                        <label class="btn btn-outline-light border text-dark w-100 py-12 px-12 text-center text-xs fw-bold radius-8 d-flex align-items-center justify-content-center gap-2" for="net_{{ $network }}">
                                            <span class="w-12-px h-12-px rounded-circle d-inline-block"
                                                  style="background-color: {{ $network === 'MTN' ? '#eab308' : ($network === 'Airtel' ? '#ef4444' : ($network === 'Glo' ? '#22c55e' : '#047857')) }};"></span>
                                            {{ $network }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Target Phone Number -->
                        <div class="mb-12">
                            <label class="form-label text-xs fw-bold text-dark text-uppercase mb-8">
                                Mobile Phone Number to Credit <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border text-xs text-muted"><i class="ri-phone-fill"></i></span>
                                <input type="text" name="phone_number" class="form-control text-sm"
                                       placeholder="e.g. 08012345678"
                                       value="{{ old('phone_number', auth()->user()->phone) }}"
                                       required>
                            </div>
                            <span class="text-xxs text-muted mt-1 d-block">Ensure this phone number is registered and active on the selected network.</span>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0 px-24 pb-24">
                        <button type="button" class="btn btn-light rounded-pill px-20 py-8 text-xs fw-semibold" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning text-dark rounded-pill px-24 py-8 text-xs fw-bold d-inline-flex align-items-center gap-2">
                            <i class="ri-send-plane-fill"></i> Submit &amp; Claim Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- ========================================== -->
<!-- 1. COURSE ACTIVITY & PERFORMANCE STATISTICS -->
<!-- ========================================== -->
<div class="row g-4 mb-32" id="course-activity-analytics">
    <!-- Activity Trend Chart (7-Day Learning Velocity) -->
    <div class="col-xxl-8 col-lg-8">
        <div class="card border-0 shadow-1 radius-16 bg-white p-24 h-100">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-20 pb-16 border-bottom">
                <div>
                    <h5 class="fw-bold text-primary-light mb-4">Course Activity & Learning Velocity</h5>
                    <p class="text-secondary-light text-xs mb-0">Daily video lesson completions, study frequency, and continuous knowledge retention over the last 7 days.</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary-50 text-primary-600 text-xs px-12 py-6 rounded-pill fw-semibold border border-primary-100">
                        <i class="ri-pulse-line me-1"></i> {{ $activityDays->sum('count') }} Lessons this week
                    </span>
                </div>
            </div>

            <!-- Mini Summary Metric Badges -->
            <div class="row g-3 mb-20">
                <div class="col-sm-4">
                    <div class="p-16 radius-12 bg-neutral-50 border d-flex align-items-center gap-12">
                        <div class="w-40-px h-40-px rounded-circle bg-primary-100 text-primary-600 d-flex align-items-center justify-content-center fs-5 flex-shrink-0">
                            <i class="ri-play-circle-line"></i>
                        </div>
                        <div>
                            <span class="text-xs text-secondary-light d-block">Lessons Watched</span>
                            <h6 class="fw-bold text-primary-light mb-0">{{ $completedLessons }} <span class="text-xs text-secondary-light fw-normal">/ {{ $totalLessons }}</span></h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="p-16 radius-12 bg-neutral-50 border d-flex align-items-center gap-12">
                        <div class="w-40-px h-40-px rounded-circle bg-success-100 text-success-600 d-flex align-items-center justify-content-center fs-5 flex-shrink-0">
                            <i class="ri-file-list-check-line"></i>
                        </div>
                        <div>
                            <span class="text-xs text-secondary-light d-block">Quiz Average</span>
                            <h6 class="fw-bold text-primary-light mb-0">{{ $averageQuizScore }}% <span class="text-xs text-success fw-medium">({{ $passedQuizzesCount }} Passed)</span></h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="p-16 radius-12 bg-neutral-50 border d-flex align-items-center gap-12">
                        <div class="w-40-px h-40-px rounded-circle bg-warning-100 text-warning-700 d-flex align-items-center justify-content-center fs-5 flex-shrink-0">
                            <i class="ri-fire-line"></i>
                        </div>
                        <div>
                            <span class="text-xs text-secondary-light d-block">Mastery Velocity</span>
                            <h6 class="fw-bold text-primary-light mb-0">{{ $overallProgress }}% <span class="text-xs text-secondary-light fw-normal">Completed</span></h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ApexChart: 7-Day Activity Trend -->
            <div id="courseActivityChart" class="w-100" style="min-height: 250px;"></div>
        </div>
    </div>

    <!-- Curriculum Mastery Breakdown (Donut Distribution) -->
    <div class="col-xxl-4 col-lg-4">
        <div class="card border-0 shadow-1 radius-16 bg-white p-24 h-100 d-flex flex-column">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-20 pb-16 border-bottom">
                <div>
                    <h5 class="fw-bold text-primary-light mb-4">Curriculum Breakdown</h5>
                    <p class="text-secondary-light text-xs mb-0">Masterclass distribution & completion ratio.</p>
                </div>
                <span class="badge bg-neutral-100 text-neutral-700 text-xs px-10 py-4 rounded-pill fw-semibold font-monospace">
                    {{ $overallProgress }}% Overall
                </span>
            </div>

            <div class="my-auto py-12 d-flex justify-content-center">
                <div id="courseProgressDonutChart"></div>
            </div>

            <div class="border-top pt-16 mt-auto">
                <div class="d-flex flex-column gap-10">
                    <div class="d-flex align-items-center justify-content-between text-xs">
                        <span class="d-flex align-items-center gap-2 text-secondary-light">
                            <span class="w-8-px h-8-px rounded-circle bg-success-600"></span> Completed Masterclasses
                        </span>
                        <span class="fw-bold text-primary-light">{{ $completedCount }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between text-xs">
                        <span class="d-flex align-items-center gap-2 text-secondary-light">
                            <span class="w-8-px h-8-px rounded-circle bg-primary-600"></span> In Progress
                        </span>
                        <span class="fw-bold text-primary-light">{{ $inProgressCount }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between text-xs">
                        <span class="d-flex align-items-center gap-2 text-secondary-light">
                            <span class="w-8-px h-8-px rounded-circle bg-neutral-300"></span> Available to Enroll
                        </span>
                        <span class="fw-bold text-primary-light">{{ $availableCourses->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- 2. COURSE PERFORMANCE & ANALYSIS TABLE -->
<!-- ========================================== -->
<div class="row g-4 mb-32" id="course-performance-table">
    <div class="col-12">
        <div class="card border-0 shadow-1 radius-16 bg-white p-24">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-20 pb-16 border-bottom">
                <div>
                    <h5 class="fw-bold text-primary-light mb-4">Course Performance & Credential Analysis</h5>
                    <p class="text-secondary-light text-xs mb-0">Detailed status of lessons streamed, quiz scores, Verified Certificates & Digital Badges, and continuation actions.</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-neutral-100 text-neutral-700 text-xs px-12 py-6 rounded-pill fw-semibold">
                        {{ $enrollments->count() }} Registered Courses
                    </span>
                    <a href="{{ route('courses.index') }}" class="btn btn-outline-primary btn-sm radius-8 px-12 py-6 text-xs fw-semibold">
                        <i class="ri-add-line me-1"></i> Add Course
                    </a>
                </div>
            </div>

            @if($enrollments->isNotEmpty())
                <div class="table-responsive">
                    <table class="table bordered-table mb-0 align-middle">
                        <thead>
                            <tr class="bg-neutral-50 text-xs text-secondary-light text-uppercase fw-semibold">
                                <th scope="col" class="py-14 px-16">Course & Level</th>
                                <th scope="col" class="py-14 px-16">Watch Progress</th>
                                <th scope="col" class="py-14 px-16">Knowledge Checks</th>
                                <th scope="col" class="py-14 px-16">Certificate & Badge</th>
                                <th scope="col" class="py-14 px-16">Target Deadline</th>
                                <th scope="col" class="py-14 px-16 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrollments as $enrollment)
                                @php
                                    $course = $enrollment->course;
                                    $completedLessons = $enrollment->completedLessonsCount();
                                    $totalLessons = $course->lessons->count();
                                    $progress = $enrollment->progressPercentage();
                                    $firstIncomplete = $course->lessons->first(fn($l) => !$enrollment->isLessonCompleted($l->id))
                                        ?? $course->lessons->first();
                                    $exam = $course->quizzes->where('is_final_exam', true)->first();
                                    $attempts = $enrollment->quizAttempts;
                                    $courseAvgQuiz = $attempts->isNotEmpty() ? (int) round($attempts->avg('score_percentage')) : null;
                                @endphp
                                <tr>
                                    <!-- Course & Level -->
                                    <td class="py-16 px-16">
                                        <div class="d-flex align-items-center gap-12">
                                            <div class="w-44-px h-44-px rounded-3 bg-primary-50 text-primary-600 d-flex align-items-center justify-content-center fs-4 flex-shrink-0 border border-primary-100">
                                                <i class="ri-video-line"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-sm fw-bold text-primary-light mb-4">{{ $course->title }}</h6>
                                                <div class="d-flex align-items-center gap-2 text-xs text-secondary-light">
                                                    <span class="badge bg-primary-subtle text-primary text-xs">{{ $course->level ?? 'All Levels' }}</span>
                                                    <span><i class="ri-time-line me-1"></i>{{ $course->duration_hours }}h</span>
                                                    <span>&bull;</span>
                                                    <span><i class="ri-file-list-line me-1"></i>{{ $totalLessons }} lessons</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Watch Progress -->
                                    <td class="py-16 px-16" style="min-width: 180px;">
                                        <div class="d-flex justify-content-between align-items-center mb-6 text-xs">
                                            <span class="fw-semibold text-primary-light font-monospace">{{ $progress }}%</span>
                                            <span class="text-secondary-light">{{ $completedLessons }}/{{ $totalLessons }} done</span>
                                        </div>
                                        <div class="progress h-6-px radius-8 bg-neutral-200 overflow-hidden">
                                            <div class="progress-bar {{ $progress >= 100 ? 'bg-success-600' : 'bg-primary-600' }} rounded-pill" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>

                                    <!-- Knowledge Checks -->
                                    <td class="py-16 px-16">
                                        @if(!is_null($courseAvgQuiz))
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge {{ $courseAvgQuiz >= 70 ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} text-xs px-8 py-4 rounded-pill fw-bold">
                                                    {{ $courseAvgQuiz }}% Avg
                                                </span>
                                                <span class="text-xs text-secondary-light">
                                                    {{ $attempts->where('is_passed', true)->count() }} passed
                                                </span>
                                            </div>
                                        @else
                                            <span class="badge bg-neutral-100 text-neutral-500 text-xs px-8 py-4 rounded-pill">
                                                Pending Quizzes
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Certificate & Badge -->
                                    <td class="py-16 px-16">
                                        @if($enrollment->certificate)
                                            <div class="d-flex flex-column gap-1">
                                                <a href="{{ route('certificates.verify', $enrollment->certificate->share_token) }}" target="_blank" class="badge bg-success-subtle text-success text-xs px-10 py-6 rounded-pill fw-bold text-decoration-none d-inline-flex align-items-center gap-1 w-fit">
                                                    <i class="ri-shield-check-fill"></i> Verified Badge
                                                </a>
                                                <span class="text-xxs text-secondary-light font-monospace">#{{ $enrollment->certificate->certificate_number }}</span>
                                            </div>
                                        @elseif($progress >= 100 && $exam)
                                            <span class="badge bg-warning-subtle text-warning text-xs px-10 py-6 rounded-pill fw-bold d-inline-flex align-items-center gap-1">
                                                <i class="ri-award-line"></i> Exam Ready
                                            </span>
                                        @else
                                            <span class="badge bg-neutral-100 text-neutral-600 text-xs px-10 py-6 rounded-pill">
                                                <i class="ri-loader-4-line me-1"></i> In Progress
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Target Deadline -->
                                    <td class="py-16 px-16">
                                        @if($enrollment->deadline_at)
                                            <div class="text-xs {{ $enrollment->deadline_at->isPast() ? 'text-danger-600 fw-bold' : 'text-secondary-light' }}">
                                                <i class="ri-calendar-event-line me-1"></i>
                                                {{ $enrollment->deadline_at->format('M d, Y') }}
                                                @if($enrollment->deadline_at->isPast())
                                                    <span class="badge bg-danger-subtle text-danger text-xxs ms-1">Overdue</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-xs text-secondary-light">
                                                <i class="ri-infinite-line me-1"></i> Self-Paced
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Action Button -->
                                    <td class="py-16 px-16 text-end">
                                        @if($enrollment->certificate)
                                            <div class="d-inline-flex align-items-center gap-2">
                                                <a href="{{ route('certificates.verify', $enrollment->certificate->share_token) }}" target="_blank" class="btn btn-success-subtle text-success btn-sm radius-8 px-12 py-6 fw-semibold text-xs d-inline-flex align-items-center gap-1" title="View Public Badge">
                                                    <i class="ri-award-fill"></i> Badge
                                                </a>
                                                <a href="{{ route('certificates.pdf', $enrollment->certificate->id) }}" class="btn btn-outline-secondary btn-sm radius-8 px-8 py-6 text-xs" title="Download PDF Certificate">
                                                    <i class="ri-download-2-line"></i>
                                                </a>
                                            </div>
                                        @elseif($progress >= 100 && $exam)
                                            <a href="{{ route('student.quiz.show', [$course->slug, $exam->id]) }}" class="btn btn-warning text-dark btn-sm radius-8 px-14 py-6 fw-bold shadow-sm text-xs d-inline-flex align-items-center gap-1">
                                                <i class="ri-file-edit-line"></i> Take Exam
                                            </a>
                                        @elseif($firstIncomplete)
                                            <a href="{{ route('student.lesson.show', [$course->slug, $firstIncomplete->slug]) }}" class="btn btn-primary-600 btn-sm radius-8 px-14 py-6 fw-semibold shadow-sm text-xs d-inline-flex align-items-center gap-1">
                                                <i class="ri-play-mini-fill fs-6"></i> Resume (L{{ $firstIncomplete->sort_order }})
                                            </a>
                                        @else
                                            <a href="{{ route('student.dashboard') }}" class="btn btn-secondary btn-sm radius-8 px-12 py-6 text-xs">
                                                Review
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-48 bg-neutral-50 radius-12">
                    <div class="w-64-px h-64-px rounded-circle bg-primary-subtle text-primary mx-auto d-flex align-items-center justify-content-center fs-2 mb-16 shadow-sm">
                        <i class="ri-book-open-line"></i>
                    </div>
                    <h6 class="fw-bold text-primary-light mb-8">No Enrolled Masterclasses Yet</h6>
                    <p class="text-secondary-light text-sm mb-20 max-w-400-px mx-auto">Enroll in our free Authority to Buy masterclasses to begin streaming protected video lessons and generating verifiable certificates.</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-primary-600 btn-sm radius-8 px-20 py-10 fw-semibold">
                        <i class="ri-compass-3-line me-1"></i> Browse Course Catalog
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- RECOMMENDED COURSES -->
<!-- ========================================== -->
@if(isset($availableCourses) && $availableCourses->isNotEmpty())
<div class="row g-4 mb-32">
    <div class="col-12">
        <div class="card border-0 shadow-1 radius-16 bg-white p-24">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-20 pb-16 border-bottom">
                <div>
                    <h5 class="fw-bold text-primary-light mb-4">Recommended Authority Masterclasses</h5>
                    <p class="text-secondary-light text-xs mb-0">Enroll in 1 click for free and start streaming protected video lessons immediately.</p>
                </div>
                <a href="{{ route('courses.index') }}" class="text-primary-600 fw-semibold text-xs hover-underline">
                    View Full Catalog <i class="ri-arrow-right-line"></i>
                </a>
            </div>

            <div class="row g-3">
                @foreach($availableCourses as $course)
                    <div class="col-md-4">
                        <div class="card border radius-12 p-20 h-100 bg-neutral-50 d-flex flex-column transition-all hover-bg-white shadow-xs">
                            <div class="d-flex align-items-center justify-content-between mb-8">
                                <span class="badge bg-primary-subtle text-primary text-xs">{{ $course->level ?? 'Beginner' }}</span>
                                <span class="badge bg-success-subtle text-success text-xs fw-bold">FREE</span>
                            </div>
                            <h6 class="fw-bold text-primary-light mb-8">{{ $course->title }}</h6>
                            <p class="text-secondary-light text-xs mb-16 flex-grow-1 lh-base">{{ Str::limit($course->description, 95) }}</p>
                            
                            <div class="d-flex align-items-center justify-content-between text-xs text-secondary-light mb-16 border-top pt-12">
                                <span><i class="ri-time-line me-1"></i> {{ $course->duration_hours }} Hours</span>
                                <span><i class="ri-file-list-3-line me-1"></i> {{ $course->lessons->count() }} Lessons</span>
                            </div>

                            <form method="POST" action="{{ route('student.enroll', $course->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary-600 btn-sm radius-8 w-100 fw-semibold">
                                    <i class="ri-user-add-line me-1"></i> Enroll for Free
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

 
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Course Activity 7-Day Trend Chart
        const activityChartEl = document.querySelector("#courseActivityChart");
        if (activityChartEl && typeof ApexCharts !== 'undefined') {
            const activityOptions = {
                series: [{
                    name: 'Lessons Completed',
                    data: {!! json_encode($activityDays->pluck('count')->toArray()) !!}
                }],
                chart: {
                    type: 'area',
                    height: 250,
                    toolbar: { show: false },
                    zoom: { enabled: false },
                    fontFamily: 'inherit'
                },
                colors: ['#487fff'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        type: 'vertical',
                        colorStops: [
                            { offset: 0, color: '#487fff', opacity: 0.35 },
                            { offset: 100, color: '#487fff', opacity: 0.02 }
                        ]
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3,
                    colors: ['#487fff']
                },
                markers: {
                    size: 4,
                    colors: ['#487fff'],
                    strokeColors: '#ffffff',
                    strokeWidth: 2,
                    hover: { size: 6 }
                },
                grid: {
                    borderColor: '#E4E7EC',
                    strokeDashArray: 3,
                    xaxis: { lines: { show: false } },
                    yaxis: { lines: { show: true } },
                    padding: { top: 0, right: 10, bottom: 0, left: 10 }
                },
                xaxis: {
                    categories: {!! json_encode($activityDays->pluck('day')->toArray()) !!},
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontSize: '12px',
                            fontWeight: 500
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    forceNiceScale: true,
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontSize: '12px'
                        },
                        formatter: function (val) {
                            return Math.floor(val);
                        }
                    }
                },
                dataLabels: { enabled: false },
                tooltip: {
                    theme: 'light',
                    y: {
                        formatter: function (val) {
                            return val + (val === 1 ? ' lesson' : ' lessons');
                        }
                    }
                }
            };
            const activityChart = new ApexCharts(activityChartEl, activityOptions);
            activityChart.render();
        }

        // 2. Curriculum Mastery Donut Chart
        const donutChartEl = document.querySelector("#courseProgressDonutChart");
        if (donutChartEl && typeof ApexCharts !== 'undefined') {
            const completed = {{ (int) $completedCount }};
            const inProgress = {{ (int) $inProgressCount }};
            const available = {{ (int) $availableCourses->count() }};
            const hasData = (completed + inProgress + available) > 0;

            const donutOptions = {
                series: hasData ? [completed, inProgress, available] : [0, 0, 1],
                labels: ['Completed', 'In Progress', 'Available'],
                colors: ['#16a34a', '#487fff', '#E2E8F0'],
                chart: {
                    type: 'donut',
                    height: 240,
                    fontFamily: 'inherit'
                },
                stroke: {
                    width: 2,
                    colors: ['#ffffff']
                },
                dataLabels: { enabled: false },
                legend: { show: false },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '72%',
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: '12px',
                                    color: '#64748B',
                                    offsetY: -4
                                },
                                value: {
                                    show: true,
                                    fontSize: '22px',
                                    fontWeight: '700',
                                    color: '#0F172A',
                                    offsetY: 4,
                                    formatter: function () {
                                        return '{{ $overallProgress }}%';
                                    }
                                },
                                total: {
                                    show: true,
                                    label: 'Mastery',
                                    fontSize: '11px',
                                    color: '#64748B',
                                    formatter: function () {
                                        return '{{ $overallProgress }}%';
                                    }
                                }
                            }
                        }
                    }
                },
                tooltip: {
                    theme: 'light',
                    y: {
                        formatter: function (val, opts) {
                            if (!hasData) return 'No courses';
                            return val + ' Masterclasses';
                        }
                    }
                }
            };
            const donutChart = new ApexCharts(donutChartEl, donutOptions);
            donutChart.render();
        }
    });
</script>
@endpush

