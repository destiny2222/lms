@extends('errors.layout')

@section('title', '500 Server Error')

@section('status_pulse', 'pulse-danger')
@section('status_label', 'System Advisory Under Review')

@section('content')
<div class="error-card">
    <div class="error-icon-wrapper" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.12) 0%, rgba(109, 40, 217, 0.22) 100%); color: #7c3aed;">
        <i class="ri-server-line"></i>
    </div>

    <div class="error-code" style="background: linear-gradient(135deg, #7c3aed 0%, #4338ca 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        500
    </div>

    <h1 class="error-title">Something Went Wrong</h1>

    <p class="error-description">
        Our servers encountered an unexpected error while fulfilling your request. Our automated logging system has recorded this event, and our engineering team has been alerted.
    </p>

    <div class="error-actions">
        <a href="javascript:void(0)" onclick="window.location.reload();" class="btn-action btn-action-primary">
            <i class="ri-refresh-line"></i> Try Again
        </a>
        <a href="{{ Route::has('home') ? route('home') : url('/') }}" class="btn-action btn-action-secondary">
            <i class="ri-home-4-line"></i> Return to Homepage
        </a>
        <a href="{{ Route::has('contact') ? route('contact') : url('/contact') }}" class="btn-action btn-action-secondary">
            <i class="ri-customer-service-2-line"></i> Contact Support
        </a>
    </div>

    <div class="error-diagnostic">
        <i class="ri-information-line me-1"></i>
        <span>Incident Code: <strong>LMS-ERR-{{ strtoupper(substr(md5(now()->format('Y-m-d H:i')), 0, 8)) }}</strong></span>
        <span class="mx-2 text-muted">&bull;</span>
        <span>Timestamp: {{ now()->toFormattedDateString() }}</span>
    </div>

    <div class="error-quicklinks mt-4">
        <span class="text-secondary fw-semibold">Quick Access:</span>
        <a href="{{ Route::has('home') ? route('home') : url('/') }}">
            <i class="ri-home-line"></i> Homepage
        </a>
        <span class="separator">&bull;</span>
        <a href="{{ Route::has('courses.index') ? route('courses.index') : url('/courses') }}">
            <i class="ri-graduation-cap-line"></i> All Courses
        </a>
        <span class="separator">&bull;</span>
        <a href="{{ Route::has('contact') ? route('contact') : url('/contact') }}">
            <i class="ri-mail-send-line"></i> Contact Team
        </a>
    </div>
</div>
@endsection
