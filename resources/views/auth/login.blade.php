@extends('layouts.app')

@section('title', 'Sign In — Authority LMS')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <div class="text-center mb-4">
                    <div class="w-64-px h-64-px rounded-circle bg-primary-50 text-primary d-inline-flex align-items-center justify-content-center mb-3">
                        <i class="ri-lock-line fs-2 text-primary"></i>
                    </div>
                    <h3 class="fw-bold text-dark">Welcome Back</h3>
                    <p class="text-muted text-sm">Sign in to your learning dashboard and continue your progress</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-sm">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="ri-mail-line"></i></span>
                            <input type="email" class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', 'student@lms.test') }}" required autofocus placeholder="name@example.com">
                        </div>
                        @error('email')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label fw-semibold text-sm mb-0">Password</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="ri-lock-2-line"></i></span>
                            <input type="password" class="form-control bg-light border-start-0 @error('password') is-invalid @enderror" id="password" name="password" value="password" required placeholder="••••••••">
                        </div>
                        @error('password')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label text-sm text-muted" for="remember">Keep me logged in</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3 shadow-sm">
                        <i class="ri-login-box-line me-1"></i> Sign In
                    </button>
                </form>

                <!-- 1-Click Quick Demo Switcher -->
                <div class="mt-4 pt-3 border-top">
                    <p class="text-xs text-muted text-center mb-2 fw-semibold text-uppercase tracking-wider">Quick Demo Login (1-Click)</p>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill text-start px-3 py-2 d-flex justify-content-between align-items-center" onclick="fillCredentials('student@lms.test', 'password')">
                            <span>🎓 <strong>Student:</strong> Alex Johnson</span>
                            <span class="badge bg-light text-dark border">Fill</span>
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill text-start px-3 py-2 d-flex justify-content-between align-items-center" onclick="fillCredentials('admin@lms.test', 'password')">
                            <span>🛡️ <strong>Admin:</strong> System Administrator</span>
                            <span class="badge bg-light text-dark border">Fill</span>
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill text-start px-3 py-2 d-flex justify-content-between align-items-center" onclick="fillCredentials('tutor@lms.test', 'password')">
                            <span>👨‍🏫 <strong>Tutor:</strong> Dr. Jane Mitchell</span>
                            <span class="badge bg-light text-dark border">Fill</span>
                        </button>
                    </div>
                </div>

                <div class="text-center mt-4 text-sm text-muted">
                    New student? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Create free account</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function fillCredentials(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endsection
