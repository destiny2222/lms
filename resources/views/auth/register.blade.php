<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description"
    content="Modern Education Admin Dashboard for schools, colleges, universities, and eLearning platforms. Includes student and course management, attendance, exams, payments, analytics, and a fully responsive clean UI—ideal for LMS, coaching centers, and academic admin systems.">
  <meta name="keywords"
    content="Education Admin Dashboard, School Admin Panel, College Dashboard, University Dashboard, LMS Dashboard, eLearning Admin Template, Student Management System, Course Management, Education Template, Study Dashboard, Online Learning Dashboard, Academic Admin Panel, Bootstrap Dashboard, React Education Dashboard, Next.js Education Template">
  <meta name="robots" content="INDEX,FOLLOW">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Title -->
  <title>Edudash - Create Student Account | Authority LMS</title>
  <link rel="icon" type="image/png" href="{{ asset('dash/assets/images/favicon.png') }}" sizes="16x16">
  <!-- remix icon font css  -->
  <link rel="stylesheet" href="{{ asset('dash/assets/css/remixicon.css') }}">
  <!-- BootStrap css -->
  <link rel="stylesheet" href="{{ asset('dash/assets/css/lib/bootstrap.min.css') }}">
  <!-- Apex Chart css -->
  <link rel="stylesheet" href="{{ asset('dash/assets/css/lib/apexcharts.css') }}">
  <!-- Data Table css -->
  <link rel="stylesheet" href="{{ asset('dash/assets/css/lib/dataTables.min.css') }}">
  <!-- Date picker css -->
  <link rel="stylesheet" href="{{ asset('dash/assets/css/lib/flatpickr.min.css') }}">
  <!-- Calendar css -->
  <link rel="stylesheet" href="{{ asset('dash/assets/css/lib/full-calendar.css') }}">
  <!-- calendar -->
  <link rel="stylesheet" href="{{ asset('dash/assets/css/lib/calendar.css') }}">
  <!-- main css -->
  <link rel="stylesheet" href="{{ asset('dash/assets/css/style.css') }}">
</head>

<body>

  <!-- Theme Customization Structure Start -->
<div class="body-overlay"></div>

 
  <div class="overlay bg-black bg-opacity-50 w-100 h-100 position-fixed z-9 visibility-hidden opacity-0 duration-300">
  </div>

<div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-40 px-16" style="background-color: #f4f6fa;">
    <!-- Logo -->
    <div class="text-center mb-28">
        <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none">
            <img src="{{ asset('assets/images/racai-blue.png') }}" alt="RACAi" style="max-height: 52px; width: auto; object-fit: contain;">
            <span class="badge bg-primary text-white fw-bold px-2 py-1" style="font-size: 0.72rem; letter-spacing: 1.5px;">Discipleship</span>
        </a>
    </div>

    <!-- Auth Card -->
    <div class="card border border-neutral-200 radius-16 bg-white w-100 max-w-540-px shadow-sm mx-auto">
        <div class="card-body p-24 p-sm-40">
            <!-- Navigation Tabs -->
            <div class="d-flex align-items-center justify-content-center gap-40 border-bottom border-neutral-200 pb-16 mb-28">
                
                <a href="{{ route('register') }}" class="text-sm fw-bold text-uppercase text-primary-600 text-decoration-none position-relative pb-16 mb-n16 ">
                    Register
                </a>
            </div>

            @if(session('error'))
                <div class="alert alert-danger border-0 rounded-3 mb-4 text-sm d-flex align-items-center gap-2">
                    <i class="ri-error-warning-fill fs-5"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="d-flex flex-column gap-20 submit-form">
                @csrf

                <!-- Full Name -->
                <div>
                    <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                        Full Name <span class="text-danger-600">*</span>
                    </label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter your full name" required autofocus>
                    @error('name')
                        <div class="text-danger-600 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                        Email Address <span class="text-danger-600">*</span>
                    </label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter your email" required>
                    @error('email')
                        <div class="text-danger-600 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- WhatsApp Phone Number -->
                <div>
                    <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8 d-flex align-items-center justify-content-between">
                        <span><i class="ri-whatsapp-line text-success me-1"></i> WhatsApp Phone Number</span> 
                    </label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+12345678901 or 08012345678">
                     
                    @error('phone')
                        <div class="text-danger-600 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                        Password <span class="text-danger-600">*</span>
                    </label>
                    <div class="position-relative">
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password (min 8 chars)" required>
                        <button type="button"
                            class="toggle-password btn p-0 border-0 bg-transparent position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light cursor-pointer ri-eye-line"
                            data-toggle="#password" aria-label="Toggle password visibility">
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger-600 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                        Confirm Password <span class="text-danger-600">*</span>
                    </label>
                    <div class="position-relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Re-enter password" required>
                        <button type="button"
                            class="toggle-password btn p-0 border-0 bg-transparent position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light cursor-pointer ri-eye-line"
                            data-toggle="#password_confirmation" aria-label="Toggle confirm password visibility">
                        </button>
                    </div>
                </div>

                <!-- Terms -->
                <div class="form-check style-check d-flex align-items-center">
                    <input class="form-check-input border border-neutral-400" type="checkbox" name="terms" id="terms" checked required>
                    <label class="form-check-label text-sm text-secondary-light" for="terms">
                        I agree to the <a href="{{ route('terms') }}" target="_blank" class="text-primary-600 text-decoration-underline">Terms & Conditions</a> and WhatsApp notifications
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary-600 w-100 py-16 radius-8 text-sm fw-semibold text-uppercase" style="letter-spacing: 0.5px;">
                    <i class="ri-user-add-line me-1"></i> Create Free Account
                </button>

            </form>

            <!-- Login Link -->
            <div class="mt-28 text-center text-sm text-secondary-light">
                Already have an account?
                <a href="{{ route('login') }}" class="text-primary-600 fw-semibold text-decoration-underline ms-1">
                    Sign In
                </a>
            </div>

        </div>
    </div>

    <!-- Footer Links -->
    <div class="text-center mt-28">
        <a href="{{ route('home') }}" class="text-secondary-light hover-text-primary text-sm fw-medium d-inline-flex align-items-center gap-2 text-decoration-none mb-12">
            <i class="ri-arrow-left-line"></i> Back to Home
        </a>
        <p class="text-xs text-secondary-light mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
    </div>
</div>

  <!-- jQuery library js -->
  <script src="{{ asset('dash/assets/js/lib/jquery-3.7.1.min.js') }}"></script>
  <!-- Bootstrap js -->
  <script src="{{ asset('dash/assets/js/lib/bootstrap.bundle.min.js') }}"></script>
  <!-- Apex Chart js -->
  <script src="{{ asset('dash/assets/js/lib/apexcharts.min.js') }}"></script>
  <!-- Iconify Font js -->
  <script src="{{ asset('dash/assets/js/lib/iconify-icon.min.js') }}"></script>
  <!-- Data Table js -->
  <script src="{{ asset('dash/assets/js/lib/dataTables.min.js') }}"></script>
  <!-- jQuery UI js -->
  <script src="{{ asset('dash/assets/js/lib/jquery-ui.min.js') }}"></script>
  <!-- main js -->
  <script src="{{ asset('dash/assets/js/app.js') }}"></script>

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
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        var pinEl = document.getElementById('pinSetupModal');
        if (pinEl) {
            var pinSetupModal = new bootstrap.Modal(pinEl);
            pinSetupModal.show();
        }
    });

            // Global Submit Button Spinner Loader
            document.addEventListener('submit', function (e) {
                const form = e.target;
                if (form.tagName === 'FORM') {
                    if (form.classList.contains('no-spinner')) return;
                    if (form.checkValidity && !form.checkValidity()) return;

                    const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
                    submitButtons.forEach(button => {
                        // Store original value
                        button.setAttribute('data-original-disabled', button.disabled);
                        button.disabled = true;

                        if (button.tagName === 'BUTTON') {
                            if (button.querySelector('.spinner-border')) return;
                            const spinner = document.createElement('span');
                            spinner.className = 'spinner-border spinner-border-sm me-2';
                            spinner.setAttribute('role', 'status');
                            spinner.setAttribute('aria-hidden', 'true');
                            button.prepend(spinner);
                        } else if (button.tagName === 'INPUT') {
                            button.setAttribute('data-original-value', button.value);
                            button.value = 'Processing...';
                        }
                    });

                    // Safety fallback: re-enable buttons after 8 seconds in case of downloads or interceptors
                    setTimeout(() => {
                        submitButtons.forEach(button => {
                            button.disabled = button.getAttribute('data-original-disabled') === 'true';
                            const spinner = button.querySelector('.spinner-border');
                            if (spinner) spinner.remove();
                            if (button.tagName === 'INPUT' && button.hasAttribute('data-original-value')) {
                                button.value = button.getAttribute('data-original-value');
                            }
                        });
                    }, 8000);
                }
            });
        </script>
</body>

</html>
