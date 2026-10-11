<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LMS Control Center')</title>

    <link rel="icon" type="image/png" href="{{ asset('dash/assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('dash/assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/assets/css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/assets/css/style.css') }}">

    <style>
        .admin-sidebar { width: 260px; min-height: 100vh; background: #0F172A; }
        .admin-sidebar .nav-link { color: #94A3B8; font-weight: 500; padding: 12px 18px; border-radius: 8px; margin: 4px 12px; display: flex; align-items: center; gap: 10px; transition: all 0.2s; }
        .admin-sidebar .nav-link:hover, .admin-sidebar .nav-link.active { color: #FFFFFF; background: #1E293B; }
        .admin-sidebar .nav-link.active { border-left: 3px solid #F59E0B; }
        .admin-content { flex: 1; min-height: 100vh; background: #F8FAFC; }
    </style>
</head>
<body class="d-flex">

    <!-- Admin Sidebar -->
    <aside class="admin-sidebar d-flex flex-column flex-shrink-0 p-3">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 mb-4 px-3 text-white text-decoration-none">
            <i class="ri-shield-check-fill text-warning fs-3"></i>
            <span class="fs-5 fw-bold tracking-wide">LMS ADMIN</span>
        </a>

        <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="ri-dashboard-3-line fs-5"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.courses.index') }}" class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                    <i class="ri-book-open-line fs-5"></i> Courses & Lessons
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.whatsapp.index') }}" class="nav-link {{ request()->routeIs('admin.whatsapp.*') ? 'active' : '' }}">
                    <i class="ri-whatsapp-line fs-5 text-success"></i> WhatsApp Bot & Bulk
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('courses.index') }}" target="_blank" class="nav-link">
                    <i class="ri-external-link-line fs-5"></i> View Student Site
                </a>
            </li>
        </ul>

        <hr class="border-secondary my-3">

        <div class="px-3 text-muted text-xs">
            <div class="d-flex align-items-center gap-2 text-white mb-2">
                <div class="w-32-px h-32-px rounded-circle bg-primary d-flex align-items-center justify-content-center fw-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="fw-semibold text-sm">{{ Auth::user()->name }}</div>
                    <span class="badge bg-warning text-dark text-xs text-uppercase">{{ Auth::user()->roles->first()?->name ?? 'Admin' }}</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm w-100 mt-2 d-flex align-items-center justify-content-center gap-1">
                    <i class="ri-logout-box-r-line"></i> Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Admin Main Content Area -->
    <div class="admin-content d-flex flex-column">
        <!-- Topbar -->
        <header class="bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">@yield('page_title', 'Overview')</h5>

            <div class="d-flex align-items-center gap-3">
                <form action="{{ route('admin.whatsapp.reminders') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-success btn-sm rounded-pill px-3 d-flex align-items-center gap-2">
                        <i class="ri-refresh-line"></i> Run WhatsApp Daily Reminders
                    </button>
                </form>

                <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 d-flex align-items-center gap-2">
                    <i class="ri-add-line"></i> New Course
                </a>
            </div>
        </header>

        <!-- Flash Alerts -->
        <div class="p-4 pb-0">
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
        </div>

        <main class="p-4 flex-grow-1">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
