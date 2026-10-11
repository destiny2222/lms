<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'LMS — Authority Learning & Certification Platform')</title>
    
    @yield('meta_tags')

    <link rel="icon" type="image/png" href="{{ asset('dash/assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('dash/assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/assets/css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/assets/css/style.css') }}">

    <style>
        .navbar-brand { font-weight: 800; letter-spacing: -0.5px; font-size: 1.4rem; color: #1E3A8A; }
        .navbar-brand span { color: #F59E0B; }
        .course-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .course-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.08); }
        .badge-authority { background: linear-gradient(135deg, #1E3A8A 0%, #0F172A 100%); color: #F59E0B; border: 1px solid #F59E0B; }
        .progress-bar-custom { height: 8px; border-radius: 4px; }
        .video-wrapper { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; background: #000; }
        .video-wrapper iframe, .video-wrapper video { position: absolute; top:0; left: 0; width: 100%; height: 100%; }
    </style>
</head>
<body class="bg-light">

    <!-- Global Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <i class="ri-shield-check-fill text-warning fs-2"></i>
                <span>AUTHORITY</span>LMS
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-2">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('courses.*') || request()->routeIs('home') ? 'text-primary' : '' }}" href="{{ route('courses.index') }}">
                            <i class="ri-book-open-line me-1"></i> Courses
                        </a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link fw-semibold {{ request()->routeIs('student.dashboard') ? 'text-primary' : '' }}" href="{{ route('student.dashboard') }}">
                                <i class="ri-dashboard-line me-1"></i> My Learning
                            </a>
                        </li>
                    @endauth
                </ul>

                <div class="d-flex align-items-center gap-3">
                    @auth
                        @if(Auth::user()->isAdmin() || Auth::user()->isTutor())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                <i class="ri-admin-line me-1"></i> Admin Panel
                            </a>
                        @endif

                        <div class="dropdown">
                            <button class="btn btn-light rounded-pill border dropdown-toggle d-flex align-items-center gap-2 px-3 py-2" type="button" data-bs-toggle="dropdown">
                                <div class="w-28-px h-28-px rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-6">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="fw-semibold text-sm">{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li><a class="dropdown-item" href="{{ route('student.dashboard') }}"><i class="ri-user-line me-2"></i>Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="ri-logout-box-r-line me-2"></i>Sign Out</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light text-dark fw-semibold px-4 rounded-pill">Sign In</a>
                        <a href="{{ route('register') }}" class="btn btn-primary fw-semibold px-4 rounded-pill">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Alerts -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-2" role="alert">
                <i class="ri-checkbox-circle-fill fs-5 text-success"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-2" role="alert">
                <i class="ri-error-warning-fill fs-5 text-danger"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-2" role="alert">
                <i class="ri-alert-fill fs-5 text-warning"></i>
                <div>{{ session('warning') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-2" role="alert">
                <i class="ri-information-fill fs-5 text-info"></i>
                <div>{{ session('info') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-top py-4 mt-5">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <i class="ri-shield-check-fill text-warning fs-3"></i>
                <span class="fw-bold text-dark">Authority LMS & Certification Engine</span>
            </div>
            <p class="mb-0 text-muted text-sm">&copy; {{ date('Y') }} All rights reserved. Automated WhatsApp follow-up enabled.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
