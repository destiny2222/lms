@extends('errors.layout')

@section('title', '404 Page Not Found')

@section('content')
<div class="error-card">
    <div class="error-icon-wrapper" style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.12) 0%, rgba(79, 70, 229, 0.22) 100%); color: #4f46e5;">
        <i class="ri-compass-3-line"></i>
    </div>

    <div class="error-code" style="background: linear-gradient(135deg, #4f46e5 0%, #312e81 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        404
    </div>

    <h1 class="error-title">Page Not Found</h1>

    <p class="error-description">
        The page you are looking for might have been moved, renamed, or never existed in the first place. Please check the address or explore our academy courses below.
    </p>

    <div class="error-actions">
        <a href="{{ Route::has('home') ? route('home') : url('/') }}" class="btn-action btn-action-primary">
            <i class="ri-home-4-line"></i> Return to Homepage
        </a>
        <a href="javascript:void(0)" onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ url('/') }}';" class="btn-action btn-action-secondary">
            <i class="ri-arrow-left-line"></i> Go Back
        </a>
        <a href="{{ Route::has('courses.index') ? route('courses.index') : url('/courses') }}" class="btn-action btn-action-secondary">
            <i class="ri-book-open-line"></i> Browse Courses
        </a>
    </div>

    <div class="error-quicklinks">
        <span class="text-secondary fw-semibold">Popular Links:</span>
        <a href="{{ Route::has('courses.index') ? route('courses.index') : url('/courses') }}">
            <i class="ri-graduation-cap-line"></i> Courses
        </a>
        <span class="separator">&bull;</span>
        <a href="{{ Route::has('student.dashboard') ? route('student.dashboard') : url('/student/dashboard') }}">
            <i class="ri-dashboard-line"></i> Student Portal
        </a>
        <span class="separator">&bull;</span>
        <a href="{{ Route::has('contact') ? route('contact') : url('/contact') }}">
            <i class="ri-customer-service-2-line"></i> Support Desk
        </a>
    </div>
</div>
@endsection
