@extends('errors.layout')

@section('title', '403 Access Restricted')

@section('status_pulse', 'pulse-warning')
@section('status_label', 'Authorization Restricted')

@section('content')
<div class="error-card">
    <div class="error-icon-wrapper" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.12) 0%, rgba(220, 38, 38, 0.22) 100%); color: #dc2626;">
        <i class="ri-shield-keyhole-line"></i>
    </div>

    <div class="error-code" style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        403
    </div>

    <h1 class="error-title">Access Restricted</h1>

    <p class="error-description">
        You do not have permission to view this protected area or administrative resource. If you are an instructor or student, please verify that you are logged into the correct authorized account.
    </p>

    <div class="error-actions">
        @auth
            <a href="{{ Route::has('student.dashboard') ? route('student.dashboard') : url('/') }}" class="btn-action btn-action-primary">
                <i class="ri-dashboard-line"></i> Student Dashboard
            </a>
        @else
            <a href="{{ Route::has('login') ? route('login') : url('/login') }}" class="btn-action btn-action-primary">
                <i class="ri-login-box-line"></i> Sign In to Authorized Account
            </a>
        @endauth
        <a href="{{ Route::has('home') ? route('home') : url('/') }}" class="btn-action btn-action-secondary">
            <i class="ri-home-4-line"></i> Return to Homepage
        </a>
        <a href="{{ Route::has('contact') ? route('contact') : url('/contact') }}" class="btn-action btn-action-secondary">
            <i class="ri-questionnaire-line"></i> Request Access
        </a>
    </div>

    <div class="error-quicklinks">
        <span class="text-secondary fw-semibold">Quick Navigation:</span>
        <a href="{{ Route::has('home') ? route('home') : url('/') }}">
            <i class="ri-home-line"></i> Home
        </a>
        <span class="separator">&bull;</span>
        <a href="{{ Route::has('courses.index') ? route('courses.index') : url('/courses') }}">
            <i class="ri-graduation-cap-line"></i> Course Catalog
        </a>
        <span class="separator">&bull;</span>
        <a href="{{ Route::has('contact') ? route('contact') : url('/contact') }}">
            <i class="ri-customer-service-2-line"></i> Support Desk
        </a>
    </div>
</div>
@endsection
