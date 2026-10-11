@extends('errors.layout')

@section('title', '419 Page Expired')

@section('status_pulse', 'pulse-warning')
@section('status_label', 'Session Timed Out')

@section('content')
<div class="error-card">
    <div class="error-icon-wrapper" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.12) 0%, rgba(217, 119, 6, 0.22) 100%); color: #d97706;">
        <i class="ri-history-line"></i>
    </div>

    <div class="error-code" style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        419
    </div>

    <h1 class="error-title">Session Expired</h1>

    <p class="error-description">
        Your security token has expired due to a period of inactivity. This protects your account and enrolled courses from unauthorized actions. Please reload or sign back in to continue.
    </p>

    <div class="error-actions">
        <a href="javascript:void(0)" onclick="window.location.reload();" class="btn-action btn-action-primary">
            <i class="ri-refresh-line"></i> Reload Page
        </a>
        <a href="{{ Route::has('login') ? route('login') : url('/login') }}" class="btn-action btn-action-secondary">
            <i class="ri-login-box-line"></i> Sign In Again
        </a>
        <a href="{{ Route::has('home') ? route('home') : url('/') }}" class="btn-action btn-action-secondary">
            <i class="ri-home-4-line"></i> Return to Homepage
        </a>
    </div>

    <div class="error-quicklinks">
        <span class="text-secondary fw-semibold">Quick Links:</span>
        <a href="{{ Route::has('login') ? route('login') : url('/login') }}">
            <i class="ri-user-follow-line"></i> Login Portal
        </a>
        <span class="separator">&bull;</span>
        <a href="{{ Route::has('courses.index') ? route('courses.index') : url('/courses') }}">
            <i class="ri-graduation-cap-line"></i> Explore Courses
        </a>
        <span class="separator">&bull;</span>
        <a href="{{ Route::has('contact') ? route('contact') : url('/contact') }}">
            <i class="ri-customer-service-2-line"></i> Help Center
        </a>
    </div>
</div>
@endsection
