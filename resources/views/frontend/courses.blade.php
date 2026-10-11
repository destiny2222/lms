@extends('layouts.main')

@section('title', 'Courses — RACAi Discipleship')

@section('content')
<!-- breadcrumb -->
@include('layouts.breadcrumb', ['pageTitle' => 'Course Catalog'])

<!-- course-section -->
<section class="course-section py-5 bg-light-subtle">
    <div class="container py-4">
        <!-- Filter and Search Bar -->
        <div class="bg-white p-4 rounded-4 shadow-sm border mb-5 animate-on-scroll" data-animation="animate__fadeInDown">
            <form method="GET" action="{{ route('courses.index') }}" class="row g-3 align-items-center">
                <div class="col-12 col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="flaticon-search"></i></span>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               class="form-control border-start-0 ps-0" 
                               placeholder="Search courses by keyword, topic, or scripture...">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <select name="level" class="form-select" onchange="this.form.submit()">
                        <option value="all">All Difficulty Levels</option>
                        <option value="beginner" {{ request('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ request('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="advanced" {{ request('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary fw-semibold px-4 flex-grow-1">
                        Filter <i class="flaticon-search ms-1"></i>
                    </button>
                    @if(request('search') || (request('level') && request('level') !== 'all'))
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary" title="Reset Filters">
                            <i class="flaticon-refresh"></i>
                        </a>
                    @endif
                </div>
            </form>
            
            <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top small text-muted">
                <div>
                    We found <strong class="text-primary">{{ $courses->total() }}</strong> {{ Str::plural('course', $courses->total()) }} available for you
                </div>
                @if(request('level') && request('level') !== 'all')
                    <div>
                        Filtering by: <span class="badge bg-primary-soft text-primary px-2 py-1 rounded-pill">{{ ucfirst(request('level')) }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Course Grid -->
        <div class="row g-4 stagger-group">
            @forelse($courses as $course)
                <div class="col-12 col-md-6 col-lg-4 animate-on-scroll" data-animation="animate__fadeInUp" data-delay="{{ ($loop->index % 3) * 0.15 }}s">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden course-racai-card course-card">
                        <div class="position-relative course-thumb-wrap">
                            <a href="{{ route('courses.show', $course->slug) }}">
                                <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/courses/course-image-' . (($loop->index % 16) + 1) . '.jpg') }}" 
                                     alt="{{ $course->title }}" 
                                     class="w-100 course-thumb-img" 
                                     onerror="this.src='{{ asset('assets/images/courses/course-image-1.jpg') }}'">
                            </a>
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-gold text-dark fw-bold px-3 py-2 rounded-pill shadow-sm">
                                    {{ ucfirst($course->level ?? 'All Levels') }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center gap-3 text-muted small mb-2">
                                <span><i class="flaticon-online-learning-1 me-1 text-primary"></i> {{ $course->lessons->count() }} Lessons</span>
                                <span><i class="flaticon-reading me-1 text-primary"></i> {{ $course->enrollments->count() }} Enrolled</span>
                                @if($course->duration_hours)
                                    <span><i class="flaticon-time me-1 text-primary"></i> {{ $course->duration_hours }}h</span>
                                @endif
                            </div>
                            
                            <h4 class="h5 fw-bold text-dark mb-2">
                                <a href="{{ route('courses.show', $course->slug) }}" class="text-decoration-none text-dark hover-primary">
                                    {{ $course->title }}
                                </a>
                            </h4>

                            <p class="text-secondary small mb-4 flex-grow-1" style="line-height: 1.6;">
                                {{ Str::limit($course->subtitle ?? $course->description, 110) }}
                            </p>

                            <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-auto">
                                <span class="badge bg-success-soft text-success px-2 py-1 fw-semibold">Free Enrollment</span>
                                
                                @auth
                                    @php
                                        $isEnrolled = Auth::user()->enrollments()->where('course_id', $course->id)->exists();
                                    @endphp
                                    @if($isEnrolled)
                                        <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-primary btn-sm px-3 fw-semibold">
                                            Continue <i class="flaticon-right-arrow ms-1"></i>
                                        </a>
                                    @else
                                        <form action="{{ route('student.enroll', $course->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm px-3 fw-semibold">
                                                Enroll Free <i class="flaticon-edit ms-1"></i>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-primary btn-sm px-3 fw-semibold">
                                        Enroll Free <i class="flaticon-right-arrow ms-1"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 animate-on-scroll" data-animation="animate__fadeInUp">
                    <div class="p-5 bg-white rounded-4 shadow-sm border">
                        <i class="flaticon-open-book display-4 text-primary mb-3 d-block"></i>
                        <h3 class="mb-2 fw-bold text-dark">No Courses Found</h3>
                        <p class="text-muted mb-4">There are no courses matching your search or filter criteria at this time.</p>
                        <a href="{{ route('courses.index') }}" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold">
                            Reset Filters <i class="flaticon-refresh ms-1"></i>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        @if($courses->hasPages())
            <div class="d-flex justify-content-center mt-5 pt-3 animate-on-scroll" data-animation="animate__fadeIn">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<style>
.course-racai-card {
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease;
    border: 1px solid #edf2f7;
    background-color: #ffffff;
}
.course-racai-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 20px 35px rgba(0, 103, 218, 0.12) !important;
    border-color: rgba(0, 103, 218, 0.25);
}
.course-thumb-wrap {
    overflow: hidden;
}
.course-thumb-img {
    height: 220px;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
.course-racai-card:hover .course-thumb-img {
    transform: scale(1.06);
}
.bg-gold {
    background-color: #f59e0b;
}
.bg-success-soft {
    background-color: rgba(22, 163, 74, 0.1);
}
.bg-primary-soft {
    background-color: rgba(0, 103, 218, 0.1);
}
.hover-primary {
    transition: color 0.2s ease;
}
.hover-primary:hover {
    color: #0067da !important;
}
</style>
@endpush
