{{-- Google Font: Plus Jakarta Sans --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

<style>
    /* =========================================================
       STANDARD PROFESSIONAL FILAMENT THEME OVERRIDES
       ========================================================= */

    :root {
        --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    body,
    .fi-body,
    .fi-sidebar,
    .fi-topbar,
    .fi-main,
    .fi-modal {
        font-family: var(--font-sans) !important;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        letter-spacing: -0.011em;
    }

    /* Topbar Modernization with Backdrop Blur */
    .fi-topbar {
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8) !important;
        background-color: rgba(255, 255, 255, 0.9) !important;
    }

    .dark .fi-topbar {
        border-bottom: 1px solid rgba(51, 65, 85, 0.6) !important;
        background-color: rgba(15, 23, 42, 0.85) !important;
    }

    /* Sidebar Refinements */
    .fi-sidebar-header {
        padding-top: 1.25rem !important;
        padding-bottom: 1.25rem !important;
        border-bottom: 1px solid rgba(226, 232, 240, 0.7) !important;
    }

    .dark .fi-sidebar-header {
        border-bottom: 1px solid rgba(51, 65, 85, 0.5) !important;
    }

    .fi-sidebar-nav {
        padding-top: 0.85rem !important;
    }

    .fi-sidebar-group-label {
        font-size: 0.7rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.06em !important;
        color: #64748b !important;
    }

    .dark .fi-sidebar-group-label {
        color: #94a3b8 !important;
    }

    .fi-sidebar-item-button {
        border-radius: 0.625rem !important;
        font-weight: 500 !important;
        transition: all 0.15s ease-in-out !important;
    }

    .fi-sidebar-item-button:hover {
        transform: translateX(2px);
    }

    .fi-sidebar-item-active .fi-sidebar-item-button {
        font-weight: 600 !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08), 0 1px 2px -1px rgba(0, 0, 0, 0.08) !important;
    }

    /* Standard Card & Widget Containers */
    .fi-section,
    .fi-widget,
    .fi-ta-ctn {
        border-radius: 1rem !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px -1px rgba(0, 0, 0, 0.03) !important;
        border: 1px solid rgba(226, 232, 240, 0.85) !important;
        transition: box-shadow 0.2s ease-in-out !important;
    }

    .dark .fi-section,
    .dark .fi-widget,
    .dark .fi-ta-ctn {
        border: 1px solid rgba(51, 65, 85, 0.6) !important;
        background-color: #0f172a !important;
    }

    /* Tables Enhancement */
    .fi-ta-header-cell {
        font-size: 0.725rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        padding-top: 0.875rem !important;
        padding-bottom: 0.875rem !important;
    }

    .fi-ta-row {
        transition: background-color 0.12s ease-in-out !important;
    }

    .fi-ta-row:hover {
        background-color: rgba(248, 250, 252, 0.85) !important;
    }

    .dark .fi-ta-row:hover {
        background-color: rgba(30, 41, 59, 0.5) !important;
    }

    /* Buttons & Form Controls */
    .fi-btn {
        border-radius: 0.625rem !important;
        font-weight: 600 !important;
        letter-spacing: -0.01em !important;
        transition: all 0.15s ease-in-out !important;
    }

    .fi-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08), 0 2px 4px -2px rgba(0, 0, 0, 0.08) !important;
    }

    .fi-input,
    .fi-select-input {
        border-radius: 0.625rem !important;
        font-family: var(--font-sans) !important;
    }

    /* Badges */
    .fi-badge {
        border-radius: 9999px !important;
        font-weight: 600 !important;
        letter-spacing: 0.01em !important;
        padding: 0.25rem 0.625rem !important;
    }

    /* Stats Widget Cards */
    .fi-wi-stats-overview-stat {
        border-radius: 0.875rem !important;
        padding: 1.25rem !important;
        transition: all 0.2s ease-in-out !important;
    }

    .fi-wi-stats-overview-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.07), 0 4px 6px -4px rgba(0, 0, 0, 0.07) !important;
    }

    /* Scrollbars */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.4);
        border-radius: 9999px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(148, 163, 184, 0.7);
    }
</style>
