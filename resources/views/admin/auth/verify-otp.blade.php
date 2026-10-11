<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Verification — RACAi Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('dash/assets/images/favicon.png') }}" sizes="16x16">
    <link rel="stylesheet" href="{{ asset('dash/assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/assets/css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/assets/css/style.css') }}">
</head>
<body style="background-color: #0f172a;">

    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-40 px-16">
        <!-- Logo -->
        <div class="text-center mb-28">
            <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none">
                <img src="{{ asset('assets/images/racai-white.png') }}" alt="RACAi" style="max-height: 52px; width: auto; object-fit: contain;">
                <span class="badge bg-warning text-dark fw-bold px-2 py-1" style="font-size: 0.72rem; letter-spacing: 1.5px;">2FA SECURITY</span>
            </a>
        </div>

        <!-- Verification Card -->
        <div class="card border-0 radius-16 bg-white w-100 max-w-540-px shadow-lg mx-auto overflow-hidden">
            <div class="card-header bg-slate-900 border-0 p-24 text-center" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                <div class="w-48-px h-48-px rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center mb-2">
                    <i class="ri-mail-lock-line fs-3"></i>
                </div>
                <h5 class="fw-bold text-white mb-1">Enter Verification Code</h5>
                <p class="text-xs mb-0" style="color: #cbd5e1;">A 6-digit code has been sent to your administrator email</p>
            </div>

            <div class="card-body p-24 p-sm-40">
                @if(session('status'))
                    <div class="alert alert-success border-0 rounded-3 mb-4 text-sm d-flex align-items-center gap-2">
                        <i class="ri-checkbox-circle-fill fs-5"></i>
                        <div>{{ session('status') }}</div>
                    </div>
                @endif

                @if(session('local_otp'))
                    <div class="alert alert-info border-0 rounded-3 mb-4 text-sm d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ri-key-2-line fs-5 text-primary"></i>
                            <div><strong>Test Code:</strong> <span class="badge bg-primary text-white font-monospace" style="letter-spacing: 2px;">{{ session('local_otp') }}</span></div>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary py-1 px-2 text-xs" onclick="document.getElementById('otp').value='{{ session('local_otp') }}'">
                            Insert Code
                        </button>
                    </div>
                @endif

                @if($errors->has('otp'))
                    <div class="alert alert-danger border-0 rounded-3 mb-4 text-sm d-flex align-items-center gap-2">
                        <i class="ri-error-warning-fill fs-5"></i>
                        <div>{{ $errors->first('otp') }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.otp.verify') }}" class="d-flex flex-column gap-24 submit-form">
                    @csrf

                    <div>
                        <label for="otp" class="text-sm fw-semibold text-primary-light d-block text-center mb-12">
                            6-Digit Security Code
                        </label>
                        <input type="text"
                               id="otp"
                               name="otp"
                               maxlength="6"
                               pattern="\d{6}"
                               inputmode="numeric"
                               autocomplete="one-time-code"
                               class="form-control text-center fw-bold fs-3 letter-spacing-4 @error('otp') is-invalid @enderror"
                               style="letter-spacing: 10px; font-family: monospace; height: 60px;"
                               placeholder="------"
                               required
                               autofocus>
                        <p class="text-xs text-muted text-center mt-2 mb-0">Code expires in 10 minutes</p>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary-600 text-sm px-12 py-16 w-100 radius-8 fw-semibold text-uppercase d-flex align-items-center justify-content-center gap-2" style="background-color: #0067da; letter-spacing: 0.5px;">
                            <i class="ri-check-double-line"></i> Verify Code &amp; Access Dashboard
                        </button>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center mt-28 pt-20 border-top">
                    <!-- Resend OTP -->
                    <form method="POST" action="{{ route('admin.otp.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 text-sm text-decoration-none fw-semibold" style="color: #0067da;">
                            <i class="ri-refresh-line"></i> Resend Code
                        </button>
                    </form>

                    <!-- Back to Login -->
                    <a href="{{ route('admin.login') }}" class="text-secondary-light hover-text-primary text-sm text-decoration-none">
                        <i class="ri-arrow-left-line"></i> Back to Sign In
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-28">
            <p class="text-xs mb-0" style="color: #64748b;">&copy; {{ date('Y') }} RACAi Discipleship. All rights reserved.</p>
        </div>
    </div>

    <script src="{{ asset('dash/assets/js/lib/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('dash/assets/js/lib/bootstrap.bundle.min.js') }}"></script>
    <script>
        // Submit Button Spinner
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (form.tagName === 'FORM' && form.classList.contains('submit-form')) {
                if (form.checkValidity && !form.checkValidity()) return;
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    const spinner = document.createElement('span');
                    spinner.className = 'spinner-border spinner-border-sm me-2';
                    spinner.setAttribute('role', 'status');
                    submitButton.prepend(spinner);
                }
            }
        });
    </script>
</body>
</html>
