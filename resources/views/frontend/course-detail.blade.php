@extends('layouts.app')

@section('title', $course->title . ' — Authority LMS')

@section('content')
<div class="container py-4">

    <!-- Course Header Banner -->
    <div class="card border-0 rounded-4 p-4 p-md-5 mb-4 text-white" style="background: linear-gradient(135deg, #0B132B 0%, #1E3A8A 100%);">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-warning text-dark text-uppercase px-3 py-2 rounded-pill text-xs fw-bold">
                        {{ ucfirst($course->level) }} Level
                    </span>
                    <span class="badge bg-white bg-opacity-10 text-light px-3 py-2 rounded-pill text-xs">
                        <i class="ri-time-line me-1"></i> {{ $course->duration_hours }} Hours Total
                    </span>
                </div>

                <h1 class="fw-extrabold text-white mb-3">{{ $course->title }}</h1>
                <p class="lead text-light opacity-75 mb-4">{{ $course->subtitle }}</p>

                <div class="d-flex align-items-center gap-3 text-sm text-light">
                    <div class="d-flex align-items-center gap-2">
                        <div class="w-32-px h-32-px rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center fw-bold">
                            {{ substr($course->tutor->name ?? 'T', 0, 1) }}
                        </div>
                        <span>Taught by <strong>{{ $course->tutor->name ?? 'Course Faculty' }}</strong></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 text-center mt-4 mt-lg-0">
                <div class="card border-0 rounded-4 p-4 bg-white text-dark shadow">
                    <div class="badge-authority p-3 rounded-3 text-center mb-3">
                        <i class="ri-shield-star-fill text-warning fs-1"></i>
                        <div class="fw-bold text-sm text-white mt-1">Official Certification Badge</div>
                        <div class="text-xs text-warning">Verified & Social Shareable</div>
                    </div>

                    <div class="mb-3 text-start text-xs text-muted">
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span><i class="ri-play-circle-line me-1 text-primary"></i> Streaming Video:</span>
                            <strong class="text-dark">Online Only</strong>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span><i class="ri-questionnaire-line me-1 text-primary"></i> Quizzes:</span>
                            <strong class="text-dark">Along the way</strong>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span><i class="ri-whatsapp-line me-1 text-success"></i> WhatsApp Reminders:</span>
                            <strong class="text-success">Included</strong>
                        </div>
                        <div class="d-flex justify-content-between py-1">
                            <span><i class="ri-award-line me-1 text-warning"></i> Certificate:</span>
                            <strong class="text-dark">Verifiable ID & PDF</strong>
                        </div>
                    </div>

                    @auth
                        @if($enrollment)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between text-xs text-muted mb-1">
                                    <span>Your Progress</span>
                                    <span class="fw-bold text-dark">{{ $enrollment->progress_percentage }}%</span>
                                </div>
                                <div class="progress progress-bar-custom bg-light">
                                    <div class="progress-bar bg-primary" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                </div>
                            </div>

                            @php
                                $firstIncomplete = $course->lessons->first(fn($l) => !$enrollment->isLessonCompleted($l->id))
                                    ?? $course->lessons->first();
                            @endphp

                            <a href="{{ route('student.lesson.show', [$course->slug, $firstIncomplete->slug]) }}" class="btn btn-primary w-100 py-2 rounded-pill fw-bold">
                                <i class="ri-play-fill me-1"></i> Continue Learning
                            </a>
                        @else
                            <form action="{{ route('student.enroll', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-bold shadow-sm">
                                    <i class="ri-check-line me-1"></i> Enroll Free Now
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary w-100 py-2 rounded-pill fw-bold shadow-sm">
                            <i class="ri-user-add-line me-1"></i> Register to Enroll Free
                        </a>
                        <div class="mt-2 text-xs text-muted">Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold">Sign In</a></div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Course Content & Syllabus -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <h4 class="fw-bold text-dark mb-3">About This Masterclass</h4>
                <div class="text-muted text-sm lh-lg">
                    {!! nl2br(e($course->description)) !!}
                </div>
            </div>

            <!-- Curriculum -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold text-dark mb-0">Course Curriculum & Syllabus</h4>
                    <span class="badge bg-light text-dark border text-xs px-3 py-2 rounded-pill">
                        {{ $course->lessons->count() }} Lessons & Quizzes
                    </span>
                </div>

                <div class="list-group list-group-flush border-top">
                    @foreach($course->lessons as $lesson)
                        <div class="list-group-item py-3 px-0 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-start gap-3">
                                <div class="w-36-px h-36-px rounded-circle bg-light text-primary d-flex align-items-center justify-content-center fw-bold fs-6 flex-shrink-0">
                                    {{ $lesson->sort_order }}
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark">{{ $lesson->title }}</div>
                                    <p class="text-muted text-xs mb-0">{{ Str::limit($lesson->description, 90) }}</p>
                                    @if($lesson->quiz)
                                        <span class="badge bg-warning-subtle text-warning-emphasis text-xs mt-1">
                                            <i class="ri-questionnaire-line me-1"></i> Includes Lesson Knowledge Check
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-light text-muted border text-xs px-2 py-1 rounded-pill">
                                    <i class="ri-time-line me-1"></i> {{ $lesson->video_duration_minutes }} mins
                                </span>
                            </div>
                        </div>
                    @endforeach

                    <!-- Final Exam Node -->
                    @if($course->finalExam())
                        <div class="list-group-item py-3 px-0 bg-warning bg-opacity-10 rounded-3 mt-2 p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-36-px h-36-px rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center fw-bold fs-5 flex-shrink-0">
                                    <i class="ri-award-fill"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $course->finalExam()->title }}</div>
                                    <span class="text-xs text-muted">Pass with ≥{{ $course->finalExam()->pass_percentage }}% to unlock official Certificate & Badge</span>
                                </div>
                            </div>
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill text-xs fw-bold">
                                Certification Exam
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Side: Tutor & WhatsApp Details -->
        <div class="col-lg-4">
            <!-- WhatsApp Follow-up Highlights -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="w-48-px h-48-px rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center fs-3">
                        <i class="ri-whatsapp-fill text-success"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Automated WhatsApp Follow-Up</h6>
                        <span class="text-xs text-muted">Daily accountability reminders</span>
                    </div>
                </div>
                <p class="text-muted text-xs mb-3">
                    Once enrolled, our dedicated WhatsApp bot tracks your progress:
                </p>
                <ul class="list-unstyled text-xs text-muted d-flex flex-column gap-2 mb-0">
                    <li class="d-flex align-items-center gap-2">
                        <i class="ri-checkbox-circle-fill text-success fs-6"></i>
                        <span>Reminds you if you haven't started within 24 hours</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="ri-checkbox-circle-fill text-success fs-6"></i>
                        <span>Follows up if you missed your scheduled video watch</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="ri-checkbox-circle-fill text-success fs-6"></i>
                        <span>Alerts you before course deadlines approach</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="ri-checkbox-circle-fill text-success fs-6"></i>
                        <span>Instant congratulatory badge delivery upon graduation</span>
                    </li>
                </ul>
            </div>

            <!-- Instructor Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h6 class="fw-bold text-dark mb-3">Course Instructor</h6>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="w-48-px h-48-px rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-5">
                        {{ substr($course->tutor->name ?? 'T', 0, 1) }}
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0">{{ $course->tutor->name ?? 'Course Faculty' }}</h6>
                        <span class="text-xs text-muted">{{ $course->tutor->bio ?? 'Senior Lead Faculty' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
