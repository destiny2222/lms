@extends('layouts.student-dash')

@section('title', 'My Enrolled Courses — Authority LMS')

@section('content')
<!-- ========================================== -->
<!-- BREADCRUMB & HEADER -->
<!-- ========================================== -->
<div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <div>
        <h1 class="fw-semibold mb-4 h5 text-primary-light">My Enrolled Courses</h1>
        <div class="text-xs">
            <a href="{{ route('student.dashboard') }}" class="text-secondary-light hover-text-primary hover-underline">Dashboard</a>
            <span class="text-secondary-light">/ My Courses</span>
        </div>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('courses.index') }}" class="btn btn-primary-600 btn-sm radius-8 d-flex align-items-center gap-6 px-16 py-8 fw-semibold shadow-sm">
            <i class="ri-compass-3-line"></i> Browse Course Catalog
        </a>
    </div>
</div>

<!-- ========================================== -->
<!-- KPI STAT METRICS -->
<!-- ========================================== -->
<div class="row gy-4 mb-24">
    <!-- Total Enrolled -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card shadow-1 radius-12 gradient-bg-end-1 border-0 h-100 transition-all hover-translate-y">
            <div class="card-body p-20">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-12">
                    <div class="w-44-px h-44-px bg-warning-600 rounded-circle d-flex justify-content-center align-items-center shadow-sm text-white fs-5">
                        <i class="ri-book-open-line"></i>
                    </div>
                    <div>
                        <span class="text-secondary-light text-xs fw-medium d-block">Enrolled Tracks</span>
                        <h4 class="mb-0 fw-bold text-primary-light">{{ $totalCount }}</h4>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between text-xs text-secondary-light pt-8 border-top border-neutral-200">
                    <span>Active curriculum</span>
                    <span class="fw-bold text-warning-main">100% Free Access</span>
                </div>
            </div>
        </div>
    </div>

    <!-- In Progress -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card shadow-1 radius-12 gradient-bg-end-2 border-0 h-100 transition-all hover-translate-y">
            <div class="card-body p-20">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-12">
                    <div class="w-44-px h-44-px bg-info-600 rounded-circle d-flex justify-content-center align-items-center shadow-sm text-white fs-5">
                        <i class="ri-loader-4-line"></i>
                    </div>
                    <div>
                        <span class="text-secondary-light text-xs fw-medium d-block">In Progress</span>
                        <h4 class="mb-0 fw-bold text-primary-light">{{ $inProgressCount }}</h4>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between text-xs text-secondary-light pt-8 border-top border-neutral-200">
                    <span>Current learning</span>
                    <span class="fw-bold text-info-main">Keep going!</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Completed Courses -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card shadow-1 radius-12 gradient-bg-end-3 border-0 h-100 transition-all hover-translate-y">
            <div class="card-body p-20">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-12">
                    <div class="w-44-px h-44-px bg-success-600 rounded-circle d-flex justify-content-center align-items-center shadow-sm text-white fs-5">
                        <i class="ri-checkbox-circle-line"></i>
                    </div>
                    <div>
                        <span class="text-secondary-light text-xs fw-medium d-block">Completed</span>
                        <h4 class="mb-0 fw-bold text-primary-light">{{ $completedCount }}</h4>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between text-xs text-secondary-light pt-8 border-top border-neutral-200">
                    <span>Full curriculum completed</span>
                    <span class="fw-bold text-success-main">{{ $completedCount > 0 ? 'Verified' : 'Pending' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Earned Certificates -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card shadow-1 radius-12 gradient-bg-end-4 border-0 h-100 transition-all hover-translate-y">
            <div class="card-body p-20">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-12">
                    <div class="w-44-px h-44-px bg-primary-600 rounded-circle d-flex justify-content-center align-items-center shadow-sm text-white fs-5">
                        <i class="ri-award-line"></i>
                    </div>
                    <div>
                        <span class="text-secondary-light text-xs fw-medium d-block">Certificates</span>
                        <h4 class="mb-0 fw-bold text-primary-light">{{ $totalCertificates }}</h4>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between text-xs text-secondary-light pt-8 border-top border-neutral-200">
                    <a href="{{ route('student.certificates') }}" class="text-primary-600 hover-underline fw-semibold">View credentials &rarr;</a>
                    <span class="fw-bold text-primary-600">Issued</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- TOOLBAR & FILTERS -->
<!-- ========================================== -->
<div class="card border-0 shadow-1 radius-16 bg-white p-20 mb-24">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <!-- Filter Tabs -->
        <div class="nav nav-pills gap-2" role="tablist">
            <a href="{{ route('student.courses', ['filter' => 'all', 'search' => request('search')]) }}" 
               class="nav-link text-xs fw-semibold px-16 py-8 radius-8 {{ $filter === 'all' ? 'active bg-primary-600 text-white' : 'bg-neutral-100 text-secondary-light' }}">
                All Courses ({{ $totalCount }})
            </a>
            <a href="{{ route('student.courses', ['filter' => 'in_progress', 'search' => request('search')]) }}" 
               class="nav-link text-xs fw-semibold px-16 py-8 radius-8 {{ $filter === 'in_progress' ? 'active bg-info-600 text-white' : 'bg-neutral-100 text-secondary-light' }}">
                In Progress ({{ $inProgressCount }})
            </a>
            <a href="{{ route('student.courses', ['filter' => 'completed', 'search' => request('search')]) }}" 
               class="nav-link text-xs fw-semibold px-16 py-8 radius-8 {{ $filter === 'completed' ? 'active bg-success-600 text-white' : 'bg-neutral-100 text-secondary-light' }}">
                Completed ({{ $completedCount }})
            </a>
        </div>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('student.courses') }}" class="d-flex align-items-center gap-2 m-0" style="min-width: 280px;">
            <input type="hidden" name="filter" value="{{ $filter }}">
            <div class="input-group">
                <span class="input-group-text bg-neutral-100 border-0 text-secondary-light">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-neutral-100 border-0 text-xs radius-end-8" placeholder="Search my courses...">
                @if(request('search'))
                    <a href="{{ route('student.courses', ['filter' => $filter]) }}" class="input-group-text bg-neutral-100 border-0 text-secondary-light hover-text-danger" title="Clear search">
                        <i class="ri-close-line"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- ENROLLED COURSES GRID -->
<!-- ========================================== -->
@if($enrollments->isNotEmpty())
    <div class="row gy-4 mb-24">
        @foreach($enrollments as $enrollment)
            @php
                $course = $enrollment->course;
                $nextLesson = $enrollment->getNextLesson();
                $progress = $enrollment->progress_percentage;
                $isCompleted = $enrollment->status === 'completed' || $progress === 100;
                $totalLessons = $course->lessons->count();
                $completedLessons = $enrollment->completedLessonsCount();
            @endphp
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-1 radius-16 bg-white overflow-hidden d-flex flex-column transition-all hover-translate-y">
                    <!-- Course Image Banner -->
                    <div class="position-relative" style="height: 180px; overflow: hidden; background: linear-gradient(135deg, #1e293b, #0f172a);">
                        @if($course->thumbnail)
                            <img src="{{ Str::startsWith($course->thumbnail, 'http') ? $course->thumbnail : asset($course->thumbnail) }}" 
                                 alt="{{ $course->title }}" 
                                 class="w-100 h-100 object-fit-cover">
                        @else
                            <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-white p-20 text-center" 
                                 style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                                <i class="ri-book-open-fill fs-1 opacity-75 mb-2"></i>
                                <span class="fw-bold text-sm">{{ Str::limit($course->title, 40) }}</span>
                            </div>
                        @endif

                        <!-- Top Badges Overlay -->
                        <div class="position-absolute top-0 start-0 w-100 p-12 d-flex justify-content-between align-items-center">
                            <span class="badge {{ $isCompleted ? 'bg-success text-white' : 'bg-primary text-white' }} px-10 py-6 rounded-pill text-xs fw-semibold shadow-sm">
                                <i class="{{ $isCompleted ? 'ri-checkbox-circle-fill' : 'ri-time-fill' }} me-1"></i>
                                {{ $isCompleted ? 'Completed' : 'In Progress' }}
                            </span>
                            <span class="badge bg-dark bg-opacity-75 text-white px-10 py-6 rounded-pill text-xs fw-medium shadow-sm">
                                <i class="ri-time-line me-1"></i> {{ $course->duration_hours }} hrs
                            </span>
                        </div>

                        <!-- Level Indicator -->
                        <div class="position-absolute bottom-0 start-0 p-12">
                            <span class="badge bg-white text-dark shadow-sm px-10 py-4 rounded-pill text-xs text-capitalize fw-semibold">
                                <i class="ri-bar-chart-fill text-warning me-1"></i> {{ $course->level }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-20 d-flex flex-column flex-grow-1">
                        <!-- Instructor Info -->
                        <div class="d-flex align-items-center gap-2 mb-10 text-xs text-secondary-light">
                            <i class="ri-user-star-line text-primary-600"></i>
                            <span>{{ $course->tutor->name ?? 'Authority LMS Faculty' }}</span>
                        </div>

                        <!-- Course Title -->
                        <h6 class="fw-bold text-dark mb-8 text-truncate-2">
                            <a href="{{ $nextLesson ? route('student.lesson.show', [$course->slug, $nextLesson->slug]) : route('courses.show', $course->slug) }}" 
                               class="text-dark hover-text-primary">
                                {{ $course->title }}
                            </a>
                        </h6>

                        <!-- Course Excerpt -->
                        <p class="text-xs text-secondary-light mb-16 flex-grow-1 text-truncate-2">
                            {{ $course->subtitle ?? Str::limit(strip_tags($course->description ?? 'Comprehensive practical curriculum with video walkthroughs and interactive assessments.'), 90) }}
                        </p>

                        <!-- Progress Section -->
                        <div class="bg-neutral-50 radius-12 p-12 mb-16 border border-neutral-200">
                            <div class="d-flex align-items-center justify-content-between text-xs mb-6">
                                <span class="text-secondary-light fw-medium">
                                    <i class="ri-video-line me-1 text-primary-600"></i> {{ $completedLessons }} of {{ $totalLessons }} Lessons
                                </span>
                                <span class="fw-bold {{ $isCompleted ? 'text-success' : 'text-primary-600' }}">{{ $progress }}%</span>
                            </div>
                            <div class="progress h-6-px radius-8 bg-neutral-200 overflow-hidden">
                                <div class="progress-bar {{ $isCompleted ? 'bg-success' : 'bg-primary-600' }} rounded-pill transition-all" 
                                     role="progressbar" 
                                     style="width: {{ $progress }}%" 
                                     aria-valuenow="{{ $progress }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex align-items-center gap-2 mt-auto">
                            @if($isCompleted)
                                @if($enrollment->certificate)
                                    <a href="{{ route('certificates.verify', $enrollment->certificate->share_token) }}" 
                                       class="btn btn-outline-success btn-sm radius-8 fw-semibold flex-grow-1 d-flex align-items-center justify-content-center gap-1">
                                        <i class="ri-award-line"></i> Certificate
                                    </a>
                                @else
                                    <a href="{{ route('student.certificates') }}" 
                                       class="btn btn-outline-success btn-sm radius-8 fw-semibold flex-grow-1 d-flex align-items-center justify-content-center gap-1">
                                        <i class="ri-award-line"></i> Certificate
                                    </a>
                                @endif
                                @if($course->lessons->first())
                                    <a href="{{ route('student.lesson.show', [$course->slug, $course->lessons->first()->slug]) }}" 
                                       class="btn btn-neutral-100 text-secondary-light btn-sm radius-8 px-12 fw-medium hover-text-primary" 
                                       title="Review Curriculum">
                                        <i class="ri-replay-10-line fs-6"></i>
                                    </a>
                                @endif
                            @else
                                @if($nextLesson)
                                    <a href="{{ route('student.lesson.show', [$course->slug, $nextLesson->slug]) }}" 
                                       class="btn btn-primary-600 btn-sm radius-8 fw-semibold flex-grow-1 d-flex align-items-center justify-content-center gap-1 shadow-sm">
                                        <i class="ri-play-circle-line"></i>
                                        <span>{{ $progress > 0 ? 'Continue Lesson' : 'Start Learning' }}</span>
                                    </a>
                                @endif
                                <a href="{{ route('courses.show', $course->slug) }}" 
                                   class="btn btn-neutral-100 text-secondary-light btn-sm radius-8 px-12 fw-medium hover-text-primary" 
                                   title="Course Syllabus">
                                    <i class="ri-information-line fs-6"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($enrollments->hasPages())
        <div class="d-flex justify-content-center mt-20">
            {{ $enrollments->links() }}
        </div>
    @endif

@else
    <!-- Empty State -->
    <div class="card border-0 shadow-1 radius-16 bg-white p-48 text-center">
        <div class="d-flex flex-column align-items-center justify-content-center max-w-500 mx-auto">
            <div class="w-80-px h-80-px rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fs-1 mb-20 shadow-sm">
                <i class="ri-book-read-line"></i>
            </div>
            
            @if(request('search'))
                <h5 class="fw-bold text-dark mb-8">No matching courses found</h5>
                <p class="text-secondary-light text-sm mb-24">We couldn't find any enrolled courses matching "<strong>{{ request('search') }}</strong>".</p>
                <a href="{{ route('student.courses', ['filter' => $filter]) }}" class="btn btn-neutral-100 text-dark btn-sm radius-8 px-20 py-8 fw-semibold">
                    <i class="ri-refresh-line me-1"></i> Clear Search Filter
                </a>
            @elseif($filter === 'completed')
                <h5 class="fw-bold text-dark mb-8">No completed courses yet</h5>
                <p class="text-secondary-light text-sm mb-24">Complete all sequential video lessons and quizzes in a course to earn your verified credential.</p>
                <a href="{{ route('student.courses') }}" class="btn btn-primary-600 btn-sm radius-8 px-20 py-8 fw-semibold">
                    View In-Progress Courses
                </a>
            @else
                <h5 class="fw-bold text-dark mb-8">No enrolled courses yet</h5>
                <p class="text-secondary-light text-sm mb-24">Explore our catalog of 100% free video masterclasses, unlock DRM streaming, and earn verifiable industry certificates.</p>
                <a href="{{ route('courses.index') }}" class="btn btn-primary-600 btn-md radius-8 px-24 py-12 fw-bold d-inline-flex align-items-center gap-2 shadow-sm">
                    <i class="ri-compass-3-line fs-5"></i> Browse Course Catalog
                </a>
            @endif
        </div>
    </div>
@endif

@endsection
