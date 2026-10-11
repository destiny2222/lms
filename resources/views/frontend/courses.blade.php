@extends('layouts.app')

@section('title', 'Authority Courses & Certification Programs')

@section('content')
<div class="container py-4">

    <!-- Hero Section -->
    <div class="card border-0 rounded-4 p-5 mb-5 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0F172A 0%, #1E3A8A 100%);">
        <div class="row align-items-center position-relative" style="z-index: 2;">
            <div class="col-lg-8">
                <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill text-xs text-uppercase mb-3">
                    <i class="ri-award-fill me-1"></i> Authority Certification Series
                </span>
                <h1 class="display-5 fw-extrabold text-white mb-3">
                    The Authority to Buy Masterclass & Learning Suite
                </h1>
                <p class="lead text-light opacity-75 mb-4">
                    Onboard, stream interactive online video lessons, take quizzes along the way, pass the final exam, and earn your verifiable digital certification badge to share on LinkedIn, Twitter, and Facebook.
                </p>
                <div class="d-flex flex-wrap gap-4 text-sm text-light">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ri-play-circle-fill text-warning fs-4"></i>
                        <span>Online-Only Video Delivery</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="ri-whatsapp-fill text-success fs-4"></i>
                        <span>WhatsApp Daily Follow-Up Bot</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="ri-shield-star-fill text-warning fs-4"></i>
                        <span>Verifiable Social Badges</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                <div class="p-4 rounded-4 d-inline-block text-center border border-warning" style="background: rgba(255,255,255,0.06); backdrop-filter: blur(8px);">
                    <div class="display-4 fw-bold text-warning mb-1">100%</div>
                    <div class="text-xs text-uppercase text-light opacity-75 tracking-wider">Free Enrollment</div>
                    <hr class="border-secondary my-3">
                    <div class="text-xs text-light">Includes WhatsApp accountability coach</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Catalog Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Available Courses</h3>
            <p class="text-muted text-sm mb-0">Select a course to view syllabus, lessons, and certification requirements</p>
        </div>
        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill text-sm">
            {{ $courses->total() }} Course(s) Available
        </span>
    </div>

    <!-- Courses Grid -->
    <div class="row g-4">
        @forelse($courses as $course)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden course-card bg-white d-flex flex-column">
                    <div class="position-relative bg-dark" style="height: 190px;">
                        <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('dash/assets/images/courses/courses-img1.jpg') }}" class="w-100 h-100 object-fit-cover opacity-75" alt="{{ $course->title }}" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=600'">
                        <span class="position-absolute top-0 start-0 m-3 badge bg-primary text-white text-xs text-uppercase px-3 py-2 rounded-pill">
                            {{ ucfirst($course->level) }}
                        </span>
                        <span class="position-absolute top-0 end-0 m-3 badge bg-dark bg-opacity-75 text-white text-xs px-2 py-1 rounded-pill">
                            <i class="ri-time-line me-1"></i> {{ $course->duration_hours }} Hours
                        </span>
                    </div>

                    <div class="card-body p-4 d-flex flex-column flex-grow-1">
                        <div class="text-muted text-xs mb-2 d-flex align-items-center gap-2">
                            <i class="ri-user-voice-line text-primary"></i>
                            <span>{{ $course->tutor->name ?? 'Course Faculty' }}</span>
                        </div>

                        <h5 class="fw-bold text-dark mb-2">
                            <a href="{{ route('courses.show', $course->slug) }}" class="text-dark text-decoration-none text-hover-primary">
                                {{ $course->title }}
                            </a>
                        </h5>

                        <p class="text-muted text-sm line-clamp-2 mb-4 flex-grow-1">
                            {{ $course->subtitle ?? Str::limit($course->description, 110) }}
                        </p>

                        <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-1 text-muted text-xs">
                                <i class="ri-video-line text-warning"></i>
                                <span>{{ $course->lessons->count() }} Lessons</span>
                            </div>

                            @auth
                                @php
                                    $isEnrolled = Auth::user()->enrollments()->where('course_id', $course->id)->exists();
                                @endphp
                                @if($isEnrolled)
                                    <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                                        <i class="ri-play-circle-line me-1"></i> Continue
                                    </a>
                                @else
                                    <form action="{{ route('student.enroll', $course->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3 fw-semibold">
                                            Enroll Free
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-semibold">
                                    View Syllabus
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">No published courses found. Sign into admin to publish a course!</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $courses->links() }}
    </div>

</div>
@endsection
