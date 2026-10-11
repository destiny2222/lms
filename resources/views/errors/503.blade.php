@extends('errors.layout')

@section('title', '503 Scheduled Maintenance')

@section('status_pulse', 'pulse-warning')
@section('status_label', 'Maintenance In Progress')

@section('content')
<div class="error-card">
    <div class="error-icon-wrapper" style="background: linear-gradient(135deg, rgba(2, 132, 199, 0.12) 0%, rgba(14, 165, 233, 0.22) 100%); color: #0284c7;">
        <i class="ri-tools-line"></i>
    </div>

    <div class="error-code" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        503
    </div>

    <h1 class="error-title">Scheduled Maintenance</h1>

    <p class="error-description">
        Authority LMS is currently undergoing scheduled platform upgrades and performance improvements. We will be back online shortly. Thank you for your patience and dedication to continuous learning!
    </p>

    <div class="error-actions">
        <a href="javascript:void(0)" onclick="window.location.reload();" class="btn-action btn-action-primary">
            <i class="ri-refresh-line"></i> Check Status Again
        </a>
        <a href="{{ Route::has('contact') ? route('contact') : url('/contact') }}" class="btn-action btn-action-secondary">
            <i class="ri-customer-service-2-line"></i> Contact Support
        </a>
    </div>

    <div class="error-quicklinks">
        <span class="text-secondary fw-semibold">Platform Updates:</span> 
        <span class="separator">&bull;</span>
        <a href="javascript:void(0)" onclick="window.location.reload();">
            <i class="ri-time-line"></i> Retry now
        </a>
    </div>
</div>
@endsection
