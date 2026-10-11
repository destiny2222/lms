@extends('layouts.app')

@section('title', 'Student Registration — Authority LMS')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <div class="text-center mb-4">
                    <div class="w-64-px h-64-px rounded-circle bg-success-50 text-success d-inline-flex align-items-center justify-content-center mb-3">
                        <i class="ri-user-add-line fs-2 text-success"></i>
                    </div>
                    <h3 class="fw-bold text-dark">Student Onboarding</h3>
                    <p class="text-muted text-sm">Join the platform, watch online video lessons, pass exams, and receive WhatsApp automated learning reminders.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-sm">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="ri-user-line"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe">
                        </div>
                        @error('name')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-sm">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="ri-mail-line"></i></span>
                            <input type="email" class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com">
                        </div>
                        @error('email')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold text-sm">
                            <i class="ri-whatsapp-line text-success me-1"></i> WhatsApp Phone Number
                            <span class="badge bg-success-subtle text-success ms-1">For Automated Bot Reminders</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="ri-phone-line"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+12345678901 or 08012345678">
                        </div>
                        <div class="form-text text-xs text-muted">Include your country code. The bot will send you personalized lesson reminders and deadline alerts.</div>
                        @error('phone')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-semibold text-sm">Password</label>
                            <input type="password" class="form-control bg-light @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Minimum 8 characters">
                            @error('password')
                                <div class="text-danger text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold text-sm">Confirm Password</label>
                            <input type="password" class="form-control bg-light" id="password_confirmation" name="password_confirmation" required placeholder="Confirm password">
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-4 text-xs text-muted d-flex align-items-start gap-2">
                        <i class="ri-information-line text-primary fs-6 mt-1"></i>
                        <div>
                            By registering, you will receive free access to the <strong>Authority to Buy</strong> course series and automatic WhatsApp study accountability alerts.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3 shadow-sm">
                        <i class="ri-user-shared-line me-1"></i> Complete Free Registration
                    </button>
                </form>

                <div class="text-center mt-4 text-sm text-muted">
                    Already registered? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Sign in here</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
