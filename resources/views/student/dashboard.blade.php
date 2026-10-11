@extends('layouts.app')

@section('title', 'My Learning Dashboard — Authority LMS')

@section('content')
<div class="container py-4">

    <!-- Welcome Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Welcome back, {{ $user->name }}!</h2>
            <p class="text-muted text-sm mb-0">Track your courses, video progress, and verified certification badges.</p>
        </div>
        <div>
            <a href="{{ route('courses.index') }}" class="btn btn-outline-primary rounded-pill px-4 fw-semibold">
                <i class="ri-search-line me-1"></i> Browse More Courses
            </a>
        </div>
    </div>

    <!-- Stats Counter Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="w-48-px h-48-px rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center fs-4">
                        <i class="ri-book-open-line"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold text-dark">{{ $enrollments->count() }}</div>
                        <div class="text-xs text-muted">Enrolled Courses</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="w-48-px h-48-px rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center fs-4">
                        <i class="ri-time-line"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold text-dark">{{ $inProgressCount }}</div>
                        <div class="text-xs text-muted">In Progress</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="w-48-px h-48-px rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center fs-4">
                        <i class="ri-checkbox-circle-line"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold text-dark">{{ $completedCount }}</div>
                        <div class="text-xs text-muted">Completed</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="w-48-px h-48-px rounded-3 bg-danger-subtle text-danger d-flex align-items-center justify-content-center fs-4">
                        <i class="ri-award-line"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold text-dark">{{ $certificates->count() }}</div>
                        <div class="text-xs text-muted">Certificates & Badges</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Courses Section -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h4 class="fw-bold text-dark mb-3">Enrolled Courses</h4>

                @forelse($enrollments as $enrollment)
                    @php
                        $course = $enrollment->course;
                        $firstIncomplete = $course->lessons->first(fn($l) => !$enrollment->isLessonCompleted($l->id))
                            ?? $course->lessons->first();
                    @endphp
                    <div class="p-3 mb-3 border rounded-3 bg-light d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="w-56-px h-56-px rounded-3 bg-primary text-white d-flex align-items-center justify-content-center fs-3 flex-shrink-0">
                                <i class="ri-book-2-line"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">{{ $course->title }}</h6>
                                <div class="text-xs text-muted d-flex align-items-center gap-3 mb-2">
                                    <span><i class="ri-time-line me-1"></i> {{ $course->duration_hours }} hrs</span>
                                    <span>•</span>
                                    <span>{{ $course->lessons->count() }} Lessons</span>
                                    @if($enrollment->deadline_at)
                                        <span>•</span>
                                        <span class="text-danger"><i class="ri-calendar-line me-1"></i> Target: {{ $enrollment->deadline_at->format('M d, Y') }}</span>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center gap-2" style="width: 240px; max-width: 100%;">
                                    <div class="progress progress-bar-custom bg-white w-100 border">
                                        <div class="progress-bar bg-success" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                    </div>
                                    <span class="text-xs fw-bold text-muted">{{ $enrollment->progress_percentage }}%</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                            @if($enrollment->status === 'completed')
                                @if($enrollment->certificate)
                                    <a href="{{ route('certificates.verify', $enrollment->certificate->share_token) }}" class="btn btn-warning text-dark btn-sm rounded-pill px-3 fw-bold">
                                        <i class="ri-award-fill me-1"></i> View Badge
                                    </a>
                                @endif
                            @else
                                @if($firstIncomplete)
                                    <a href="{{ route('student.lesson.show', [$course->slug, $firstIncomplete->slug]) }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                                        <i class="ri-play-circle-fill me-1"></i> Continue
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="ri-book-read-line text-muted fs-1 mb-2"></i>
                        <h6 class="text-muted">You have not enrolled in any courses yet.</h6>
                        <a href="{{ route('courses.index') }}" class="btn btn-primary btn-sm rounded-pill px-4 mt-2">Explore Catalog</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right Side: Earned Badges & Certificates -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0">Certificates & Badges</h5>
                    <span class="badge bg-warning text-dark text-xs px-2 py-1 rounded-pill">{{ $certificates->count() }}</span>
                </div>

                @forelse($certificates as $cert)
                    <div class="p-3 border rounded-3 mb-3 text-center bg-light">
                        <div class="mb-2">
                            <i class="ri-shield-star-fill text-warning fs-1"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1 text-sm">{{ $cert->enrollment->course->title }}</h6>
                        <p class="text-muted text-xs mb-2">Certificate ID: <code>{{ $cert->certificate_number }}</code></p>
                        
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('certificates.verify', $cert->share_token) }}" class="btn btn-primary btn-sm rounded-pill px-3 text-xs fw-semibold">
                                <i class="ri-share-line me-1"></i> View & Share
                            </a>
                            <a href="{{ route('certificates.pdf', $cert->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 text-xs fw-semibold">
                                <i class="ri-download-line me-1"></i> PDF
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="ri-medal-line fs-2 opacity-50 mb-2"></i>
                        <p class="text-xs mb-0">Complete a course and pass the final exam to earn your verifiable badge!</p>
                    </div>
                @endforelse
            </div>

            <!-- WhatsApp Study Bot Status Box -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mt-4 bg-success bg-opacity-10 border-success border">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="ri-whatsapp-fill text-success fs-4"></i>
                    <h6 class="fw-bold text-dark mb-0">WhatsApp Study Assistant</h6>
                </div>
                <p class="text-xs text-muted mb-2">
                    Phone registered: <strong>{{ $user->phone ?? 'Not provided' }}</strong>
                </p>
                <div class="text-xs text-muted">
                    Reply <code>PROGRESS</code> or <code>NEXT</code> to our WhatsApp bot anytime to check your study goals!
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
