<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') — RACAi Discipleship</title>
    <link rel="icon" type="image/png" href="{{ asset('dash/assets/images/favicon.png') }}" sizes="16x16">

    <!-- Modern Typography: Plus Jakarta Sans from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Remix Icon font css -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/remixicon.css') }}">
    <!-- BootStrap 5 css -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/lib/bootstrap.min.css') }}">
    <!-- Apex Chart css -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/lib/apexcharts.css') }}">

    <style>
        :root {
            --font-family-base: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --bg-body: #f8fafc;
            --bg-surface: #ffffff;
            --sidebar-width: 260px;
            --header-height: 72px;

            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-subtle: #eff6ff;
            --primary-border: #bfdbfe;

            --text-main: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;

            --border-light: #f1f5f9;
            --border-card: #eef2f6;

            --radius-xs: 6px;
            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 18px;
            --radius-xl: 22px;
            --radius-full: 9999px;

            --shadow-xs: 0 1px 2px rgba(15, 23, 42, 0.04);
            --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.04), 0 4px 12px rgba(15, 23, 42, 0.02);
            --shadow-card: 0 1px 3px rgba(15, 23, 42, 0.03), 0 10px 24px -4px rgba(15, 23, 42, 0.04);
            --shadow-hover: 0 16px 32px -4px rgba(15, 23, 42, 0.08);
            --shadow-dropdown: 0 20px 40px -8px rgba(15, 23, 42, 0.12);
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family-base);
            background-color: var(--bg-body);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Accessibility focus state */
        :focus-visible {
            outline: 2px solid var(--primary) !important;
            outline-offset: 2px !important;
        }

        /* -------------------------------------------------------------
           SIDEBAR DESIGN (Shopeers / Modern SaaS White Style)
        ------------------------------------------------------------- */
        .admin-sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            background-color: var(--bg-surface);
            border-right: 1px solid var(--border-light);
            display: flex;
            flex-direction: column;
            z-index: 1040;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .sidebar-brand {
            height: var(--header-height);
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-light);
            flex-shrink: 0;
        }

        .brand-logo-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .brand-title {
            font-weight: 800;
            font-size: 1.15rem;
            color: var(--text-main);
            letter-spacing: -0.5px;
            margin: 0;
            line-height: 1;
        }

        .brand-pill {
            background: var(--primary-subtle);
            color: var(--primary);
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: var(--radius-full);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .sidebar-close-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            font-size: 1.25rem;
            display: none;
            cursor: pointer;
            padding: 4px;
        }

        .sidebar-nav-container {
            flex: 1;
            overflow-y: auto;
            padding: 20px 16px;
        }

        .nav-section-label {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 1.1px;
            color: var(--text-muted);
            text-transform: uppercase;
            padding: 12px 12px 6px;
            margin: 0;
        }

        .sidebar-nav-list {
            list-style: none;
            padding: 0;
            margin: 0 0 12px 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-nav-item .nav-link-custom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            border-radius: var(--radius-md);
            color: var(--text-secondary);
            font-size: 0.86rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .sidebar-nav-item .nav-link-custom:hover {
            background-color: #f8fafc;
            color: var(--text-main);
        }

        .sidebar-nav-item.active .nav-link-custom {
            background-color: var(--primary-subtle);
            color: var(--primary);
            font-weight: 700;
        }

        .nav-link-custom .nav-link-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-link-custom i {
            font-size: 1.15rem;
            color: var(--text-muted);
            transition: color 0.2s ease;
        }

        .sidebar-nav-item.active .nav-link-custom i {
            color: var(--primary);
        }

        .sidebar-nav-item .nav-link-custom:hover i {
            color: var(--text-main);
        }

        .nav-badge-count {
            background: #f1f5f9;
            color: var(--text-secondary);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: var(--radius-full);
        }

        .sidebar-nav-item.active .nav-badge-count {
            background: #dbeafe;
            color: var(--primary);
        }

        /* Sidebar Bottom Profile Card */
        .sidebar-footer-profile {
            padding: 16px;
            border-top: 1px solid var(--border-light);
            background: #ffffff;
            flex-shrink: 0;
        }

        .sidebar-user-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: var(--radius-md);
            background: #f8fafc;
            border: 1px solid var(--border-light);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .sidebar-user-pill:hover {
            background: #f1f5f9;
            border-color: #e2e8f0;
        }

        .user-avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-full);
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            font-size: 0.85rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .user-info-text {
            min-width: 0;
            flex-grow: 1;
        }

        .user-name-title {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role-label {
            font-size: 0.7rem;
            font-weight: 500;
            color: var(--text-muted);
            margin: 0;
        }

        /* -------------------------------------------------------------
           MAIN CONTENT WRAPPER & TOP HEADER
        ------------------------------------------------------------- */
        .admin-main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--bg-body);
            transition: margin-left 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .admin-top-header {
            height: var(--header-height);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-light);
            position: sticky;
            top: 0;
            z-index: 1020;
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-search-box {
            position: relative;
            width: 340px;
        }

        .header-search-input {
            width: 100%;
            height: 42px;
            background-color: #f1f5f9;
            border: 1px solid transparent;
            border-radius: var(--radius-full);
            padding: 0 46px 0 42px;
            font-size: 0.84rem;
            color: var(--text-main);
            transition: all 0.2s ease;
        }

        .header-search-input:focus {
            background-color: #ffffff;
            border-color: var(--primary-border);
            outline: none;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .header-search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.05rem;
            pointer-events: none;
        }

        .header-kbd-shortcut {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: #e2e8f0;
            color: var(--text-secondary);
            font-size: 0.68rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 6px;
            pointer-events: none;
        }

        .header-actions-group {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .date-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: #f8fafc;
            border: 1px solid var(--border-card);
            border-radius: var(--radius-full);
            padding: 6px 14px;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .portal-quick-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            background: #ffffff;
            border: 1px solid var(--border-card);
            border-radius: var(--radius-full);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .portal-quick-link:hover {
            color: var(--primary);
            border-color: var(--primary-border);
            background: var(--primary-subtle);
        }

        .header-user-dropdown-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            border: none;
            padding: 4px;
            cursor: pointer;
            text-align: left;
        }

        .sidebar-toggle-mobile-btn {
            display: none;
            background: transparent;
            border: none;
            font-size: 1.4rem;
            color: var(--text-main);
            padding: 4px;
            cursor: pointer;
        }

        /* Dropdown Menu Modern Styling */
        .dropdown-menu-modern {
            border: 1px solid var(--border-card);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-dropdown);
            padding: 8px;
            min-width: 230px;
            margin-top: 10px !important;
        }

        .dropdown-menu-modern .dropdown-item {
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.15s ease;
        }

        .dropdown-menu-modern .dropdown-item:hover {
            background-color: #f8fafc;
            color: var(--text-main);
        }

        .dropdown-menu-modern .dropdown-item.text-danger:hover {
            background-color: #fef2f2;
            color: #dc2626 !important;
        }

        /* -------------------------------------------------------------
           PAGE BODY CONTENT & GENERAL CARDS
        ------------------------------------------------------------- */
        .admin-page-content {
            flex: 1;
            padding: 32px;
        }

        .card-modern {
            background-color: var(--bg-surface);
            border: 1px solid var(--border-card);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-card);
            transition: box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1), transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .card-modern-header {
            padding: 22px 26px;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-modern-body {
            padding: 24px 26px;
        }

        /* KPI Stat Cards (Shopeers Style) */
        .stat-card-shopeers {
            background: #ffffff;
            border: 1px solid var(--border-card);
            border-radius: var(--radius-xl);
            padding: 24px;
            box-shadow: var(--shadow-card);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card-shopeers:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
        }

        .stat-icon-squircle {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .stat-number-display {
            font-size: 2.15rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -1px;
            line-height: 1;
            margin: 0;
        }

        .stat-badge-trend {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: var(--radius-full);
            display: inline-flex;
            align-items: center;
            gap: 2px;
            line-height: 1.3;
        }

        /* Dribbble Style Modern Data Table */
        .table-dribbble {
            margin: 0;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-dribbble th {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: var(--text-muted);
            background-color: #f8fafc;
            padding: 14px 24px;
            border-bottom: 1px solid #e2e8f0;
            border-top: none;
        }

        .table-dribbble td {
            padding: 18px 24px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-light);
            color: var(--text-main);
            font-size: 0.86rem;
            background-color: #ffffff;
            transition: background-color 0.15s ease;
        }

        .table-dribbble tr:hover td {
            background-color: #fbfcfe;
        }

        .table-dribbble tr:last-child td {
            border-bottom: none;
        }

        /* Status Pills */
        .pill-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: var(--radius-full);
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .pill-status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .pill-in-progress {
            background-color: #eff6ff;
            color: #2563eb;
            border: 1px solid #dbeafe;
        }
        .pill-in-progress .pill-status-dot {
            background-color: #2563eb;
        }

        .pill-completed {
            background-color: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }
        .pill-completed .pill-status-dot {
            background-color: #10b981;
        }

        .pill-enrolled {
            background-color: #f8fafc;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }
        .pill-enrolled .pill-status-dot {
            background-color: #94a3b8;
        }

        /* Mobile Backdrop Overlay */
        .sidebar-mobile-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 1030;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-mobile-backdrop.show {
            display: block;
            opacity: 1;
        }

        /* Responsive Breakpoints */
        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .sidebar-close-btn {
                display: block;
            }
            .admin-main-wrapper {
                margin-left: 0;
            }
            .sidebar-toggle-mobile-btn {
                display: block;
            }
            .admin-top-header {
                padding: 0 16px;
            }
            .admin-page-content {
                padding: 20px 16px;
            }
            .header-search-box {
                width: 220px;
            }
        }

        @media (max-width: 575.98px) {
            .header-search-box {
                display: none;
            }
            .date-badge-pill {
                display: none;
            }
        }

        /* -------------------------------------------------------------
           LARKON & ACTION BUTTONS
        ------------------------------------------------------------- */
        .btn-larkon-add {
            background-color: var(--primary, #2563eb) !important;
            border: 1px solid var(--primary, #2563eb) !important;
            color: #ffffff !important;
            font-weight: 600;
            font-size: 13.5px;
            padding: 8px 18px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.18);
        }
        .btn-larkon-add:hover {
            background-color: var(--primary-hover, #1d4ed8) !important;
            border-color: var(--primary-hover, #1d4ed8) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
            transform: translateY(-1px);
        }

        .btn-larkon-action,
        .quiz-action-btn {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid transparent;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            padding: 0;
            line-height: 1;
            background: #f8fafc;
            outline: none;
            flex-shrink: 0;
        }
        .btn-larkon-action:hover,
        .quiz-action-btn:hover {
            transform: translateY(-2px);
        }

        /* 1. View / Preview / Attempts / Verify */
        .btn-larkon-view,
        .quiz-action-attempts {
            background-color: #f5f3ff;
            border-color: #ede9fe;
            color: #7c3aed;
        }
        .btn-larkon-view:hover,
        .quiz-action-attempts:hover {
            background-color: #7c3aed;
            border-color: #7c3aed;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.28);
        }

        /* 2. Edit / Setup Questions / Builder */
        .btn-larkon-edit,
        .quiz-action-builder,
        .quiz-action-edit {
            background-color: #eff6ff;
            border-color: #dbeafe;
            color: #2563eb;
        }
        .btn-larkon-edit:hover,
        .quiz-action-builder:hover,
        .quiz-action-edit:hover {
            background-color: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.28);
        }

        /* 3. Curriculum / Video / WhatsApp */
        .btn-larkon-lessons {
            background-color: #f0fdf4;
            border-color: #dcfce7;
            color: #16a34a;
        }
        .btn-larkon-lessons:hover {
            background-color: #16a34a;
            border-color: #16a34a;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.28);
        }

        /* 4. Delete / Revoke */
        .btn-larkon-delete,
        .quiz-action-delete {
            background-color: #fef2f2;
            border-color: #fee2e2;
            color: #dc2626;
        }
        .btn-larkon-delete:hover,
        .quiz-action-delete:hover {
            background-color: #dc2626;
            border-color: #dc2626;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.28);
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Mobile Backdrop -->
    <div class="sidebar-mobile-backdrop" id="sidebarBackdrop"></div>

    <!-- -------------------------------------------------------------
         ADMIN SIDEBAR
    -------------------------------------------------------------- -->
    <aside class="admin-sidebar" id="adminSidebar">
        <!-- Brand Header -->
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}" class="brand-logo-wrap">
                <img src="{{ asset('assets/images/racai-blue.png') }}" alt="RACAi" style="height: 36px; width: auto; object-fit: contain;">
                <div>
                    <h1 class="brand-title">RACAi</h1>
                </div>
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="brand-pill">ADMIN</span>
                <button type="button" class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Close Sidebar">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        </div>

        <!-- Navigation Links Container -->
        <div class="sidebar-nav-container">
            <!-- Section 1: Main Menu -->
            <p class="nav-section-label">MAIN MENU</p>
            <ul class="sidebar-nav-list">
                <li class="sidebar-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link-custom">
                        <div class="nav-link-content">
                            <i class="ri-dashboard-3-line"></i>
                            <span>Dashboard</span>
                        </div>
                    </a>
                </li>
            </ul>

            <!-- Section 2: Academy & Students -->
            <p class="nav-section-label">ACADEMY &amp; CURRICULUM</p>
            <ul class="sidebar-nav-list">
                <li class="sidebar-nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                    <a href="{{ Route::has('admin.courses.index') ? route('admin.courses.index') : '#' }}" class="nav-link-custom">
                        <div class="nav-link-content">
                            <i class="ri-book-open-line"></i>
                            <span>Courses &amp; Curriculum</span>
                        </div>
                        <span class="nav-badge-count">{{ \App\Models\Course::count() }}</span>
                    </a>
                </li>
                <li class="sidebar-nav-item {{ request()->routeIs('admin.courses.create') ? 'active' : '' }}">
                    <a href="{{ Route::has('admin.courses.create') ? route('admin.courses.create') : '#' }}" class="nav-link-custom">
                        <div class="nav-link-content">
                            <i class="ri-add-circle-line"></i>
                            <span>Create Course</span>
                        </div>
                    </a>
                </li>
                <li class="sidebar-nav-item {{ request()->routeIs('admin.quizzes.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.quizzes.index') }}" class="nav-link-custom">
                        <div class="nav-link-content">
                            <i class="ri-questionnaire-line"></i>
                            <span>Quizzes &amp; Tests</span>
                        </div>
                        <span class="nav-badge-count">{{ \App\Models\Quiz::count() }}</span>
                    </a>
                </li>
                <li class="sidebar-nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.students.index') }}" class="nav-link-custom">
                        <div class="nav-link-content">
                            <i class="ri-group-line"></i>
                            <span>Disciples &amp; Students</span>
                        </div>
                        <span class="nav-badge-count">{{ \App\Models\User::count() }}</span>
                    </a>
                </li>
                <li class="sidebar-nav-item {{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.certificates.index') }}" class="nav-link-custom">
                        <div class="nav-link-content">
                            <i class="ri-award-line"></i>
                            <span>Issued Certificates</span>
                        </div>
                        <span class="nav-badge-count">{{ \App\Models\Certificate::count() }}</span>
                    </a>
                </li>
                <li class="sidebar-nav-item {{ request()->routeIs('admin.rewards.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.rewards.index') }}" class="nav-link-custom">
                        <div class="nav-link-content">
                            <i class="ri-wifi-line"></i>
                            <span>Data Rewards</span>
                        </div>
                        @php $pendingRewardsCount = \App\Models\DataReward::where('status', 'claimed')->count(); @endphp
                        @if($pendingRewardsCount > 0)
                            <span class="badge bg-warning text-dark rounded-pill text-xs px-2 py-0.5 fw-bold">{{ $pendingRewardsCount }} new</span>
                        @else
                            <span class="nav-badge-count">{{ \App\Models\DataReward::count() }}</span>
                        @endif
                    </a>
                </li>
            </ul>

            <!-- Section 3: Website Content & Plugins -->
            <p class="nav-section-label">WEBSITE &amp; PLUGINS</p>
            <ul class="sidebar-nav-list">
                <li class="sidebar-nav-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.pages.index') }}" class="nav-link-custom">
                        <div class="nav-link-content">
                            <i class="ri-pages-line"></i>
                            <span>Pages Setting</span>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill text-xs px-2 py-0.5">CMS</span>
                    </a>
                </li>
                <li class="sidebar-nav-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.testimonials.index') }}" class="nav-link-custom">
                        <div class="nav-link-content">
                            <i class="ri-chat-quote-line"></i>
                            <span>Testimonials</span>
                        </div>
                        <span class="nav-badge-count">{{ \App\Models\Testimonial::count() }}</span>
                    </a>
                </li>
            </ul>

            <!-- Section 3: Communications & Automation -->
            <p class="nav-section-label">AUTOMATION</p>
            <ul class="sidebar-nav-list">
                <li class="sidebar-nav-item {{ request()->routeIs('admin.whatsapp.*') ? 'active' : '' }}">
                    <a href="{{ Route::has('admin.whatsapp.index') ? route('admin.whatsapp.index') : '#' }}" class="nav-link-custom">
                        <div class="nav-link-content">
                            <i class="ri-whatsapp-line" style="color: #22c55e;"></i>
                            <span>WhatsApp Bot</span>
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill text-xs px-2 py-0.5">Live</span>
                    </a>
                </li>
            </ul>

            <!-- Section 4: Portal & Public Links -->
            <p class="nav-section-label">PORTAL NAVIGATION</p>
            <ul class="sidebar-nav-list">
                <li class="sidebar-nav-item">
                    <a href="{{ route('courses.index') }}" target="_blank" class="nav-link-custom">
                        <div class="nav-link-content">
                            <i class="ri-compass-3-line"></i>
                            <span>Browse Student Portal</span>
                        </div>
                        <i class="ri-external-link-line text-xs"></i>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('home') }}" target="_blank" class="nav-link-custom">
                        <div class="nav-link-content">
                            <i class="ri-global-line"></i>
                            <span>Public Website</span>
                        </div>
                        <i class="ri-external-link-line text-xs"></i>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sidebar User Profile Footer -->
        <div class="sidebar-footer-profile">
            <div class="sidebar-user-pill">
                <div class="user-avatar-circle">
                    {{ strtoupper(substr(Auth::guard('admin')->user()?->name ?? 'A', 0, 1)) }}
                </div>
                <div class="user-info-text">
                    <p class="user-name-title">{{ Auth::guard('admin')->user()?->name ?? 'Administrator' }}</p>
                    <p class="user-role-label">{{ Auth::guard('admin')->user()?->role ?? 'Super Admin' }}</p>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-light border-0 p-1 text-danger rounded-circle d-flex align-items-center justify-content-center" title="Sign Out">
                        <i class="ri-logout-box-r-line fs-5"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- -------------------------------------------------------------
         MAIN CONTENT AREA
    -------------------------------------------------------------- -->
    <div class="admin-main-wrapper">
        <!-- Top Navbar Header -->
        <header class="admin-top-header">
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="sidebar-toggle-mobile-btn" id="sidebarToggleBtn" aria-label="Toggle Sidebar">
                    <i class="ri-menu-2-line"></i>
                </button>
                <div class="header-search-box">
                    <i class="ri-search-line header-search-icon"></i>
                    <input type="text" class="header-search-input" placeholder="Search disciples, courses..." aria-label="Search">
                    <span class="header-kbd-shortcut">⌘K</span>
                </div>
            </div>

            <div class="header-actions-group">
               
               

                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="header-user-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar-circle" style="width: 38px; height: 38px;">
                            {{ strtoupper(substr(Auth::guard('admin')->user()?->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="d-none d-md-block">
                            <span class="d-block fw-bold text-dark text-sm line-height-1">
                                {{ Auth::guard('admin')->user()?->name ?? 'Administrator' }}
                            </span>
                            <span class="text-xs text-muted">
                                {{ Auth::guard('admin')->user()?->role ?? 'Super Admin' }}
                            </span>
                        </div>
                        <i class="ri-arrow-down-s-line text-muted"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern">
                        <li class="px-3 py-2 border-bottom mb-2">
                            <div class="fw-bold text-dark text-sm">{{ Auth::guard('admin')->user()?->name }}</div>
                            <div class="text-xs text-muted text-truncate">{{ Auth::guard('admin')->user()?->email }}</div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <i class="ri-dashboard-line"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('courses.index') }}" target="_blank">
                                <i class="ri-compass-3-line"></i> Student Portal
                            </a>
                        </li>
                        <li class="border-top mt-2 pt-2">
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger border-0 w-100 text-start bg-transparent">
                                    <i class="ri-logout-box-r-line"></i> Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="admin-page-content">
            <!-- Flash Notification Messages -->
            @if (session('success'))
                <div class="alert alert-success border-0 rounded-4 mb-4 d-flex align-items-center gap-2 shadow-sm text-sm" role="alert">
                    <i class="ri-checkbox-circle-fill fs-5 text-success"></i>
                    <div class="fw-medium">{{ session('success') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger border-0 rounded-4 mb-4 d-flex align-items-center gap-2 shadow-sm text-sm" role="alert">
                    <i class="ri-error-warning-fill fs-5 text-danger"></i>
                    <div class="fw-medium">{{ session('error') }}</div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Scripts: Bootstrap 5 Bundle & ApexCharts -->
    <script src="{{ asset('dash/assets/js/lib/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dash/assets/js/lib/apexcharts.min.js') }}"></script>

    <!-- Mobile Navigation Drawer Handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const closeBtn = document.getElementById('sidebarCloseBtn');
            const backdrop = document.getElementById('sidebarBackdrop');

            function openSidebar() {
                sidebar.classList.add('open');
                backdrop.classList.add('show');
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                backdrop.classList.remove('show');
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);
        });
    </script>

    @stack('scripts')
</body>

</html>
