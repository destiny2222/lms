<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Authority LMS Student Dashboard — Learn, complete tests, earn verified badges.">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Student Dashboard') — Edudash | Authority LMS</title>
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
  @stack('styles')
</head>

<body>

  <!-- Theme Customization Structure Start -->
  <div class="body-overlay"></div>
 
  <div class="overlay bg-black bg-opacity-50 w-100 h-100 position-fixed z-9 visibility-hidden opacity-0 duration-300"></div>

  <!-- Sidebar Start -->
  <aside class="sidebar">
    <button type="button" class="sidebar-close-btn" aria-label="Close Sidebar">
      <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
      <div class="sidebar-logo d-flex align-items-center justify-content-between">
        <a href="{{ route('student.dashboard') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none">
          <img src="{{ asset('assets/images/racai-blue.png') }}" alt="RACAi" class="light-logo" style="max-height: 44px; width: auto; object-fit: contain;">
          <img src="{{ asset('assets/images/racai-white.png') }}" alt="RACAi" class="dark-logo" style="max-height: 44px; width: auto; object-fit: contain;">
          <img src="{{ asset('assets/images/racai-blue.png') }}" alt="RACAi" class="logo-icon" style="max-height: 38px; width: auto; object-fit: contain;">
        </a>
        <button type="button" class="text-xxl d-xl-flex d-none line-height-1 sidebar-toggle text-neutral-500 border-0 bg-transparent"
          aria-label="Collapse Sidebar">
          <i class="ri-contract-left-line"></i>
        </button>
      </div>
    </div>

    <!-- User Info Profile Card -->
    <div class="mx-16 py-12">
      <div class="dropdown profile-dropdown">
        {{-- <button type="button"
          class="profile-dropdown__button d-flex align-items-center justify-content-between p-10 w-100 overflow-hidden bg-neutral-50 radius-12 border-0 text-start"
          data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
          <span class="d-flex align-items-center gap-10">
            @if(auth()->user()->avatar_url)
                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-40-px h-40-px rounded-circle object-fit-cover border border-2 border-primary-200 flex-shrink-0">
            @else
                <span class="w-40-px h-40-px rounded-circle bg-primary-600 text-white d-flex align-items-center justify-content-center fw-bold fs-6 flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
            @endif
            <span class="profile-dropdown__contents text-truncate">
              <span class="h6 mb-0 text-sm d-block text-primary-light text-truncate">{{ auth()->user()->name }}</span>
              <span class="text-secondary-light text-xs mb-0 d-block">
                @if(auth()->user()->hasRole('admin')) Admin
                @elseif(auth()->user()->hasRole('tutor')) Tutor
                @else Student
                @endif
              </span>
            </span>
          </span>
          <span class="profile-dropdown__icon pe-8 text-xl d-flex line-height-1">
            <i class="ri-arrow-right-s-line"></i>
          </span>
        </button> --}}
        <ul class="dropdown-menu dropdown-menu-lg-end border p-12">
          <li>
            <a href="{{ route('student.dashboard') }}" 
              class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-2 py-6">
              <i class="ri-user-3-line"></i>
              My Dashboard
            </a>
          </li>
          <li>
            <a href="{{ route('student.profile') }}" 
              class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-2 py-6">
              <i class="ri-user-settings-line"></i>
              Edit Profile
            </a>
          </li> 
          <li>
            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                @csrf
                <button type="submit" class="dropdown-item rounded text-danger bg-hover-danger-50 d-flex align-items-center gap-2 py-6 border-0 w-100 text-start">
                  <i class="ri-shut-down-line"></i>
                  Sign Out
                </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
    <!-- User Info end -->

    <!-- Sidebar Menu Navigation -->
    <div class="sidebar-menu-area">
      <ul class="sidebar-menu" id="sidebar-menu">
        <li class="{{ request()->routeIs('student.dashboard') ? 'active-page' : '' }}">
          <a href="{{ route('student.dashboard') }}">
            <i class="ri-dashboard-3-line"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <li class="{{ request()->routeIs('student.courses*') || request()->routeIs('student.my-courses') ? 'active-page' : '' }}">
          <a href="{{ route('student.courses') }}">
            <i class="ri-book-read-line"></i> 
            <span>My Courses</span>
          </a>
        </li>

        <li>
          <a href="{{ route('courses.index') }}">
            <i class="ri-compass-3-line"></i>
            <span>Browse Courses</span>
          </a>
        </li>

        <li class="{{ request()->routeIs('student.certificates*') || request()->routeIs('certificates.index') ? 'active-page' : '' }}">
          <a href="{{ route('student.certificates') }}">
            <i class="ri-award-line"></i>
            <span>Certificates & Badges</span>
          </a>
        </li>

        <li class="{{ request()->routeIs('student.profile*') ? 'active-page' : '' }}">
          <a href="{{ route('student.profile') }}">
            <i class="ri-user-settings-line"></i>
            <span>My Profile</span>
          </a>
        </li>

        @if(auth()->user()->hasAnyRole(['admin', 'super-admin', 'tutor']))
        <li class="sidebar-menu-divider mt-16 pt-16 border-top"></li>
        <li>
          <a href="{{ route('admin.dashboard') }}" target="_blank" class="text-primary-600 fw-semibold">
            <i class="ri-shield-keyhole-line text-warning"></i>
            <span>Admin Console</span>
          </a>
        </li>
        @endif

        <li class="sidebar-menu-divider mt-16 pt-16 border-top"></li>

        <li>
          <a href="{{ route('home') }}" target="_blank">
            <i class="ri-external-link-line"></i>
            <span>Website Home</span>
          </a>
        </li>

        <li>
          <a href="javascript:void(0)" onclick="document.getElementById('logout-form-sidebar').submit();" class="text-danger">
            <i class="ri-logout-box-r-line"></i>
            <span>Log Out</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
  <!-- Sidebar End -->

  <!-- Main Content Layout -->
  <main class="dashboard-main">
    <!-- Navbar Header -->
    <div class="navbar-header shadow-1">
      <div class="row align-items-center justify-content-between">
        <div class="col-auto">
          <div class="d-flex flex-wrap align-items-center gap-4">
            <button type="button" class="sidebar-mobile-toggle border-0 bg-transparent" aria-label="Sidebar Mobile Toggler Button">
              <iconify-icon icon="heroicons:bars-3-solid" class="icon fs-4"></iconify-icon>
            </button>
          </div>
        </div>
        <div class="col-auto">
          <div class="d-flex flex-wrap align-items-center gap-3">
            <!-- Theme Toggle Button -->
            <button type="button" data-theme-toggle
              class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center border-0 cursor-pointer"
              aria-label="Dark & Light Mode Button">
            </button>

            <!-- User Dropdown Header -->
            <div class="dropdown d-inline-block">
              <button class="d-flex align-items-center gap-2 bg-transparent border-0 cursor-pointer p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                @if(auth()->user()->avatar_url)
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-40-px h-40-px rounded-circle object-fit-cover border border-2 border-primary-200">
                @else
                    <span class="w-40-px h-40-px rounded-circle bg-primary-600 text-white d-flex align-items-center justify-content-center fw-bold fs-6">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                @endif
                <span class="d-none d-md-block text-start">
                    <span class="d-block text-sm fw-bold text-primary-light line-height-1">{{ auth()->user()->name }}</span>
                    <span class="text-xs text-secondary-light">
                        @if(auth()->user()->hasRole('admin')) Admin
                        @elseif(auth()->user()->hasRole('tutor')) Tutor
                        @else Learner
                        @endif
                    </span>
                </span>
                <i class="ri-arrow-down-s-line text-secondary-light"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end border shadow-sm p-12 mt-2 radius-12">
                <li class="px-12 py-8 border-bottom mb-8">
                    <div class="fw-bold text-primary-light text-sm">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-secondary-light text-truncate">{{ auth()->user()->email }}</div>
                </li>
                <li>
                  <a class="dropdown-item rounded py-8 d-flex align-items-center gap-2 text-sm text-secondary-light" href="{{ route('student.dashboard') }}">
                    <i class="ri-dashboard-line"></i> Dashboard
                  </a>
                </li>
                <li>
                  <a class="dropdown-item rounded py-8 d-flex align-items-center gap-2 text-sm text-secondary-light" href="{{ route('student.profile') }}">
                    <i class="ri-user-settings-line"></i> Edit Profile
                  </a>
                </li>
                <li>
                  <a class="dropdown-item rounded py-8 d-flex align-items-center gap-2 text-sm text-secondary-light" href="{{ route('student.courses') }}">
                    <i class="ri-book-read-line"></i> My Courses
                  </a>
                </li> 
                @if(auth()->user()->hasAnyRole(['admin', 'super-admin', 'tutor']))
                <li>
                  <a class="dropdown-item rounded py-8 d-flex align-items-center gap-2 text-sm text-primary fw-semibold" href="{{ route('admin.dashboard') }}" target="_blank">
                    <i class="ri-shield-user-line"></i> Admin Console
                  </a>
                </li>
                @endif
                <li class="border-top mt-8 pt-8">
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item rounded py-8 d-flex align-items-center gap-2 text-sm text-danger border-0 w-100 text-start">
                        <i class="ri-logout-box-r-line"></i> Sign Out
                    </button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Navbar Header End -->

    <!-- Main Body Container -->
    <div class="dashboard-main-body">
      @if(session('success'))
          <div class="alert alert-success border-0 rounded-3 mb-24 d-flex align-items-center gap-2 shadow-sm text-sm">
              <i class="ri-checkbox-circle-fill fs-5 text-success"></i>
              <div>{{ session('success') }}</div>
          </div>
      @endif

      @if(session('error'))
          <div class="alert alert-danger border-0 rounded-3 mb-24 d-flex align-items-center gap-2 shadow-sm text-sm">
              <i class="ri-error-warning-fill fs-5 text-danger"></i>
              <div>{{ session('error') }}</div>
          </div>
      @endif

      @yield('content')
    </div>

    <!-- Footer -->
    <footer class="d-footer">
      <div class="row align-items-center justify-content-between">
        <div class="col-auto">
          <p class="mb-0 text-sm text-secondary-light">&copy; {{ date('Y') }} Authority LMS. All rights reserved.</p>
        </div>
        <div class="col-auto">
          <p class="mb-0 text-xs text-secondary-light">
            <span class="badge bg-success-subtle text-success me-2"><i class="ri-shield-check-line me-1"></i> Verified Badges</span>
            <span class="badge bg-primary-subtle text-primary"><i class="ri-lock-2-line me-1"></i> Video DRM Protected</span>
          </p>
        </div>
      </div>
    </footer>
  </main>

   

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
            document.addEventListener('DOMContentLoaded', function() {
                var pinSetupModal = new bootstrap.Modal(document.getElementById('pinSetupModal'));
                pinSetupModal.show();
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
  @stack('scripts')
</body>
</html>
