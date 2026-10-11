@extends('errors.layout')

@section('title', '429 Too Many Requests')

@section('status_pulse', 'pulse-warning')
@section('status_label', 'Rate Limit Exceeded')

@section('content')
<div class="error-card">
    <div class="error-icon-wrapper" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.12) 0%, rgba(217, 119, 6, 0.22) 100%); color: #d97706;">
        <i class="ri-speed-up-line"></i>
    </div>

    <div class="error-code" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        429
    </div>

    <h1 class="error-title">Too Many Requests</h1>

    <p class="error-description">
        You have sent too many requests in a short period of time. Please wait a moment before trying again to allow our servers to catch up.
    </p>

    <div class="error-actions">
        <a href="javascript:void(0)" onclick="window.location.reload();" class="btn-action btn-action-primary">
            <i class="ri-refresh-line"></i> Try Again
        </a>
        <a href="{{ Route::has('home') ? route('home') : url('/') }}" class="btn-action btn-action-secondary">
            <i class="ri-home-4-line"></i> Return to Homepage
        </a>
    </div>

    <div class="error-quicklinks">
        <span class="text-secondary fw-semibold">Quick Links:</span>
        <a href="{{ Route::has('home') ? route('home') : url('/') }}">
            <i class="ri-home-line"></i> Home
        </a>
        <span class="separator">&bull;</span>
        <a href="{{ Route::has('contact') ? route('contact') : url('/contact') }}">
            <i class="ri-customer-service-2-line"></i> Support
        </a>
    </div>
</div>
@endsection
