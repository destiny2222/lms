<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal Login — RACAi Discipleship</title>
    <link rel="icon" type="image/png" href="{{ asset('dash/assets/images/favicon.png') }}" sizes="16x16">
    <link rel="stylesheet" href="{{ asset('dash/assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/assets/css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/assets/css/style.css') }}">
</head>
<body style="background-color: #0f172a;">

    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-40 px-16">
        <!-- Logo & Title -->
        <div class="text-center mb-28">
            <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none">
                <img src="{{ asset('assets/images/racai-white.png') }}" alt="RACAi" style="max-height: 52px; width: auto; object-fit: contain;">
                <span class="badge bg-warning text-dark fw-bold px-2 py-1" style="font-size: 0.72rem; letter-spacing: 1.5px;">ADMIN PORTAL</span>
            </a>
            <p class="text-slate-400 text-sm mt-2 mb-0" style="color: #94a3b8;">
                Administrative &amp; Course Management Console
            </p>
        </div>

        <!-- Auth Card -->
        <div class="card border-0 radius-16 bg-white w-100 max-w-540-px shadow-lg mx-auto overflow-hidden">
            <div class="card-header bg-slate-900 border-0 p-24 text-center" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                <div class="w-48-px h-48-px rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center mb-2">
                    <i class="ri-shield-keyhole-line fs-3"></i>
                </div>
                <h5 class="fw-bold text-white mb-1">Admin Sign In</h5>
                <p class="text-xs mb-0" style="color: #cbd5e1;">Enter your credentials to receive an authentication code</p>
            </div>

            <div class="card-body p-24 p-sm-40">
                @if(session('status'))
                    <div class="alert alert-success border-0 rounded-3 mb-4 text-sm d-flex align-items-center gap-2">
                        <i class="ri-checkbox-circle-fill fs-5"></i>
                        <div>{{ session('status') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger border-0 rounded-3 mb-4 text-sm d-flex align-items-center gap-2">
                        <i class="ri-error-warning-fill fs-5"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}" class="d-flex flex-column gap-24 submit-form">
                    @csrf

                    <div class="d-flex flex-column gap-16">
                        <!-- Email -->
                        <div>
                            <label for="email" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                Admin Email Address <span class="text-danger-600">*</span>
                            </label>
                            <div class="position-relative">
                                <input type="email" id="email" name="email" value="{{ old('email', app()->environment('local') ? 'admin@gmail.com' : '') }}" class="form-control @error('email') is-invalid @enderror" placeholder="admin@domain.com" required autofocus>
                            </div>
                            @error('email')
                                <div class="text-danger-600 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                Password <span class="text-danger-600">*</span>
                            </label>
                            <div class="position-relative">
                                <input type="password" id="password" name="password" value="{{ app()->environment('local') ? 'password' : '' }}" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" required>
                                <button type="button"
                                    class="toggle-password btn p-0 border-0 bg-transparent position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light cursor-pointer ri-eye-line"
                                    data-toggle="#password" aria-label="Toggle password visibility">
                                </button>
                            </div>
                            @if(app()->environment('local'))
                                <div class="text-xs text-muted mt-2">
                                    <i class="ri-information-line"></i> Local Default: <code>admin@gmail.com</code> / <code>password</code>
                                </div>
                            @endif
                            @error('password')
                                <div class="text-danger-600 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-check style-check d-flex align-items-center">
                            <input class="form-check-input border border-neutral-400" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-sm text-secondary-light" for="remember">Keep me signed in</label>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary-600 text-sm px-12 py-16 w-100 radius-8 fw-semibold text-uppercase d-flex align-items-center justify-content-center gap-2" style="background-color: #0067da; letter-spacing: 0.5px;">
                            <i class="ri-shield-check-line"></i> Verify Credentials &amp; Request OTP
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-28">
            <a href="{{ route('home') }}" class="text-slate-400 hover-text-white text-sm fw-medium d-inline-flex align-items-center gap-2 text-decoration-none mb-12" style="color: #94a3b8;">
                <i class="ri-arrow-left-line"></i> Back to Main Site
            </a>
            <p class="text-xs mb-0" style="color: #64748b;">&copy; {{ date('Y') }} RACAi Discipleship. All rights reserved.</p>
        </div>
    </div>

    <script src="{{ asset('dash/assets/js/lib/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('dash/assets/js/lib/bootstrap.bundle.min.js') }}"></script>
    <script>
        $('.toggle-password').on('click', function() {
            $(this).toggleClass('ri-eye-line ri-eye-off-line');
            var input = $($(this).attr('data-toggle'));
            if (input.attr('type') == 'password') {
                input.attr('type', 'text');
            } else {
                input.attr('type', 'password');
            }
        });

        // Submit Button Spinner Loader
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (form.tagName === 'FORM') {
                if (form.checkValidity && !form.checkValidity()) return;
                const submitButtons = form.querySelectorAll('button[type="submit"]');
                submitButtons.forEach(button => {
                    button.disabled = true;
                    const spinner = document.createElement('span');
                    spinner.className = 'spinner-border spinner-border-sm me-2';
                    spinner.setAttribute('role', 'status');
                    button.prepend(spinner);
                });
            }
        });
    </script>
</body>
</html>
