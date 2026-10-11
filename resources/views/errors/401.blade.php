@extends('errors.layout')

@section('title', '401 Unauthorized')

@section('status_pulse', 'pulse-warning')
@section('status_label', 'Authentication Required')

@section('content')
<div class="error-card">
    <div class="error-icon-wrapper" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.12) 0%, rgba(99, 102, 241, 0.22) 100%); color: #4f46e5;">
        <i class="ri-lock-password-line"></i>
    </div>

    <div class="error-code" style="background: linear-gradient(135deg, #4f46e5 0%, #312e81 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        401
    </div>

    <h1 class="error-title">Authentication Required</h1>

    <p class="error-description">
        You must be signed in with a valid account to access this lesson or resource. Please log in with your credentials or register for an account.
    </p>

    <div class="error-actions">
        <a href="{{ Route::has('login') ? route('login') : url('/login') }}" class="btn-action btn-action-primary">
            <i class="ri-login-box-line"></i> Sign In to Continue
        </a>
        <a href="{{ Route::has('home') ? route('home') : url('/') }}" class="btn-action btn-action-secondary">
            <i class="ri-home-4-line"></i> Return to Homepage
        </a>
    </div>

    <div class="error-quicklinks">
        <span class="text-secondary fw-semibold">Quick Links:</span>
        <a href="{{ Route::has('courses.index') ? route('courses.index') : url('/courses') }}">
            <i class="ri-graduation-cap-line"></i> Browse Courses
        </a>
        <span class="separator">&bull;</span>
        <a href="{{ Route::has('contact') ? route('contact') : url('/contact') }}">
            <i class="ri-customer-service-2-line"></i> Support
        </a>
    </div>
</div>
@endsection
