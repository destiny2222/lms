<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Error') — Authority LMS</title>
    <meta name="description" content="Authority LMS — Automated Learning & Certification Platform">
    <link rel="icon" type="image/png" href="{{ asset('dash/assets/images/favicon.png') }}" sizes="16x16">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/lib/bootstrap.min.css') }}">
    <!-- Remix Icon CSS -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/remixicon.css') }}">

    <style>
        :root {
            --brand-primary: #4f46e5;
            --brand-primary-hover: #4338ca;
            --brand-primary-light: #eef2ff;
            --brand-dark: #0f172a;
            --brand-slate: #1e293b;
            --brand-muted: #64748b;
            --brand-border: #e2e8f0;
            --brand-bg: #f8fafc;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--brand-bg);
            color: var(--brand-dark);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            background-image: 
                radial-gradient(at 15% 15%, rgba(99, 102, 241, 0.08) 0px, transparent 50%),
                radial-gradient(at 85% 85%, rgba(244, 63, 94, 0.05) 0px, transparent 50%),
                radial-gradient(#cbd5e1 1.1px, transparent 1.1px);
            background-size: 100% 100%, 100% 100%, 28px 28px;
        }

        /* Error Header */
        .error-header {
            padding: 20px 0;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            position: relative;
            z-index: 20;
        }

        .error-brand img {
            max-height: 40px;
            width: auto;
            display: block;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            font-size: 0.82rem;
            font-weight: 600;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--brand-border);
            color: var(--brand-slate);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }

        .status-pulse {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            position: relative;
        }

        .pulse-operational {
            background-color: #10b981;
            box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
            animation: pulse-green 2s infinite;
        }

        .pulse-warning {
            background-color: #f59e0b;
            box-shadow: 0 0 0 rgba(245, 158, 11, 0.4);
            animation: pulse-amber 2s infinite;
        }

        .pulse-danger {
            background-color: #ef4444;
            box-shadow: 0 0 0 rgba(239, 68, 68, 0.4);
            animation: pulse-red 2s infinite;
        }

        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        @keyframes pulse-amber {
            0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
            70% { box-shadow: 0 0 0 8px rgba(245, 158, 11, 0); }
            100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }

        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        /* Error Content Stage */
        .error-page-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            position: relative;
            z-index: 10;
        }

        .error-card {
            max-width: 680px;
            width: 100%;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 28px;
            padding: 56px 48px;
            text-align: center;
            box-shadow: 
                0 25px 60px -15px rgba(15, 23, 42, 0.08),
                0 0 0 1px rgba(15, 23, 42, 0.02);
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease;
        }

        @media (max-width: 576px) {
            .error-card {
                padding: 40px 24px;
                border-radius: 20px;
            }
        }

        /* Icon Container */
        .error-icon-wrapper {
            width: 110px;
            height: 110px;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 52px;
            margin-bottom: 24px;
            position: relative;
            box-shadow: 0 12px 32px -4px rgba(0, 0, 0, 0.08);
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        /* Error Status Number */
        .error-code {
            font-size: clamp(3.75rem, 9vw, 5.5rem);
            font-weight: 800;
            letter-spacing: -0.05em;
            line-height: 1;
            margin: 0 0 8px 0;
        }

        .error-title {
            font-size: clamp(1.4rem, 4vw, 1.85rem);
            font-weight: 700;
            color: var(--brand-dark);
            letter-spacing: -0.02em;
            margin-bottom: 12px;
        }

        .error-description {
            font-size: 1.05rem;
            line-height: 1.65;
            color: var(--brand-muted);
            max-width: 520px;
            margin: 0 auto 32px auto;
        }

        /* Action Buttons */
        .error-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            margin-bottom: 32px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 26px;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: 14px;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            border: 1px solid transparent;
        }

        .btn-action-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        }

        .btn-action-primary:hover {
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.45);
        }

        .btn-action-secondary {
            background: #ffffff;
            color: var(--brand-slate);
            border-color: var(--brand-border);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        .btn-action-secondary:hover {
            background: #f8fafc;
            color: var(--brand-dark);
            border-color: #cbd5e1;
            transform: translateY(-2px);
        }

        .btn-action-dark {
            background: #0f172a;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
        }

        .btn-action-dark:hover {
            background: #1e293b;
            color: #ffffff;
            transform: translateY(-2px);
        }

        /* Helpful Suggestions Navigation */
        .error-quicklinks {
            padding-top: 24px;
            border-top: 1px solid rgba(226, 232, 240, 0.8);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 16px;
            font-size: 0.88rem;
            color: var(--brand-muted);
        }

        .error-quicklinks a {
            color: var(--brand-muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .error-quicklinks a:hover {
            color: var(--brand-primary);
        }

        .error-quicklinks .separator {
            color: #cbd5e1;
        }

        /* Diagnostics & Reference Tag */
        .error-diagnostic {
            margin-top: 24px;
            padding: 12px 16px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            font-size: 0.82rem;
            color: var(--brand-muted);
            display: inline-block;
        }

        /* Error Footer */
        .error-footer {
            padding: 24px 0;
            background: #ffffff;
            border-top: 1px solid rgba(226, 232, 240, 0.8);
            font-size: 0.85rem;
            color: var(--brand-muted);
        }

        .error-footer a {
            color: var(--brand-muted);
            text-decoration: none;
            transition: color 0.15s;
        }

        .error-footer a:hover {
            color: var(--brand-primary);
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Minimal Standard Header -->
 
    <!-- Centered Error Canvas -->
    <main class="error-page-section">
        <div class="container d-flex justify-content-center">
            @yield('content')
        </div>
    </main>

 
    @yield('scripts')
</body>
</html>
