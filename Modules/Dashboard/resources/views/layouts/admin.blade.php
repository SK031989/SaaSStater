<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — {{ config('settings.project_name', config('app.name', 'SaaSStater')) }}</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
    <meta name="theme-color" content="#6366f1">

    {{-- SEO Meta --}}
    <meta name="description" content="@yield('meta_description', config('app.name', 'SaaSStater') . ' — Admin Panel')">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons via CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- ApexCharts via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <!-- Bootstrap CSS (kept for backward compatibility with nested module pages) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <!-- Tailwind CSS (Vite compiled) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Base Badge Reset */
        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }

        /* Light Mode Default Badge Utilities */
        .badge-emerald, .bg-emerald-50 { background-color: #ecfdf5 !important; color: #047857 !important; border: 1px solid #a7f3d0 !important; }
        .badge-amber,   .bg-amber-50   { background-color: #fffbeb !important; color: #b45309 !important; border: 1px solid #fde68a !important; }
        .badge-rose,    .bg-rose-50    { background-color: #fff1f2 !important; color: #be123c !important; border: 1px solid #fecdd3 !important; }
        .badge-purple,  .bg-purple-50  { background-color: #faf5ff !important; color: #6b21a8 !important; border: 1px solid #e9d5ff !important; }
        .badge-indigo,  .bg-indigo-50  { background-color: #eef2ff !important; color: #3730a3 !important; border: 1px solid #c7d2fe !important; }
        .badge-slate,   .bg-slate-100  { background-color: #f1f5f9 !important; color: #334155 !important; border: 1px solid #e2e8f0 !important; }

        /* Dark Mode Badge Overrides */
        html.dark .badge-emerald, html.dark .bg-emerald-50,
        .dark .badge-emerald, .dark .bg-emerald-50 {
            background-color: rgba(16, 185, 129, 0.22) !important;
            color: #34d399 !important;
            border: 1px solid rgba(16, 185, 129, 0.4) !important;
        }

        html.dark .badge-amber, html.dark .bg-amber-50,
        .dark .badge-amber, .dark .bg-amber-50 {
            background-color: rgba(245, 158, 11, 0.22) !important;
            color: #fbbf24 !important;
            border: 1px solid rgba(245, 158, 11, 0.4) !important;
        }

        html.dark .badge-rose, html.dark .bg-rose-50,
        .dark .badge-rose, .dark .bg-rose-50 {
            background-color: rgba(244, 63, 94, 0.22) !important;
            color: #f87171 !important;
            border: 1px solid rgba(244, 63, 94, 0.4) !important;
        }

        html.dark .badge-purple, html.dark .bg-purple-50,
        .dark .badge-purple, .dark .bg-purple-50 {
            background-color: rgba(168, 85, 247, 0.22) !important;
            color: #c084fc !important;
            border: 1px solid rgba(168, 85, 247, 0.4) !important;
        }

        html.dark .badge-indigo, html.dark .bg-indigo-50,
        .dark .badge-indigo, .dark .bg-indigo-50 {
            background-color: rgba(99, 102, 241, 0.22) !important;
            color: #818cf8 !important;
            border: 1px solid rgba(99, 102, 241, 0.4) !important;
        }

        html.dark .badge-slate, html.dark .bg-slate-100,
        .dark .badge-slate, .dark .bg-slate-100 {
            background-color: rgba(30, 41, 59, 0.85) !important;
            color: #cbd5e1 !important;
            border: 1px solid rgba(51, 65, 85, 0.85) !important;
        }

        .badge.bg-primary, .badge.bg-success, .badge.bg-danger, .badge.bg-dark, .badge.text-white {
            color: #ffffff !important;
        }

        /* Dark Mode Dropdown Menu & 3-Dot Button Fixes */
        html.dark .dropdown-menu, .dark .dropdown-menu {
            background-color: #0f172a !important;
            border: 1px solid #1e293b !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.6) !important;
        }

        html.dark .dropdown-item, .dark .dropdown-item {
            color: #e2e8f0 !important;
        }

        html.dark .dropdown-item:hover, html.dark .dropdown-item:focus,
        .dark .dropdown-item:hover, .dark .dropdown-item:focus {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }

        html.dark .dropdown-divider, .dark .dropdown-divider {
            border-top-color: #1e293b !important;
        }

        html.dark .btn-light, .dark .btn-light {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }

        html.dark .btn-light:hover, .dark .btn-light:hover {
            background-color: #334155 !important;
            color: #ffffff !important;
        }

        /* Prevent Dropdown Clipping in Table Containers */
        .table-responsive {
            overflow: visible !important;
            min-height: 240px;
        }

        .card, .card-body {
            overflow: visible !important;
        }

        /* Dropdown Menu Elevation & Positioning */
        .dropdown-menu {
            z-index: 1050 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        }

        html.dark .dropdown-menu, .dark .dropdown-menu {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.7), 0 8px 10px -6px rgba(0, 0, 0, 0.5) !important;
        }
    </style>
    
    <!-- Inline Theme script to prevent flash -->
    <!-- Inline Theme script to prevent flash -->
    <script>
        window.ACCENT_PALETTES = [
            // ── Cool ──
            { name: 'Purple',    hex: '#a855f7', rgb: '168 85 247',   light: '#f3e8ff', dark: '#7e22ce' },
            { name: 'Violet',    hex: '#8b5cf6', rgb: '139 92 246',   light: '#ede9fe', dark: '#5b21b6' },
            { name: 'Indigo',    hex: '#6366f1', rgb: '99 102 241',   light: '#e0e7ff', dark: '#4338ca' },
            { name: 'Blue',      hex: '#3b82f6', rgb: '59 130 246',   light: '#dbeafe', dark: '#1d4ed8' },
            { name: 'Sky',       hex: '#0ea5e9', rgb: '14 165 233',   light: '#e0f2fe', dark: '#0369a1' },
            { name: 'Cyan',      hex: '#06b6d4', rgb: '6 182 212',    light: '#cffafe', dark: '#0e7490' },
            // ── Nature ──
            { name: 'Teal',      hex: '#14b8a6', rgb: '20 184 166',   light: '#ccfbf1', dark: '#0f766e' },
            { name: 'Emerald',   hex: '#10b981', rgb: '16 185 129',   light: '#d1fae5', dark: '#065f46' },
            { name: 'Green',     hex: '#22c55e', rgb: '34 197 94',    light: '#dcfce7', dark: '#15803d' },
            { name: 'Lime',      hex: '#84cc16', rgb: '132 204 22',   light: '#ecfccb', dark: '#3f6212' },
            // ── Warm ──
            { name: 'Yellow',    hex: '#eab308', rgb: '234 179 8',    light: '#fef9c3', dark: '#854d0e' },
            { name: 'Amber',     hex: '#f59e0b', rgb: '245 158 11',   light: '#fef3c7', dark: '#92400e' },
            { name: 'Orange',    hex: '#f97316', rgb: '249 115 22',   light: '#ffedd5', dark: '#c2410c' },
            { name: 'Red',       hex: '#ef4444', rgb: '239 68 68',    light: '#fee2e2', dark: '#b91c1c' },
            // ── Vibrant ──
            { name: 'Rose',      hex: '#f43f5e', rgb: '244 63 94',    light: '#ffe4e6', dark: '#9f1239' },
            { name: 'Pink',      hex: '#ec4899', rgb: '236 72 153',   light: '#fce7f3', dark: '#9d174d' },
            { name: 'Fuchsia',   hex: '#d946ef', rgb: '217 70 239',   light: '#fae8ff', dark: '#86198f' },
            { name: 'Magenta',   hex: '#c026d3', rgb: '192 38 211',   light: '#fdf4ff', dark: '#701a75' },
            // ── Neutral ──
            { name: 'Slate',     hex: '#64748b', rgb: '100 116 139',  light: '#f1f5f9', dark: '#334155' },
            { name: 'Gray',      hex: '#6b7280', rgb: '107 114 128',  light: '#f3f4f6', dark: '#374151' },
            { name: 'Zinc',      hex: '#71717a', rgb: '113 113 122',  light: '#f4f4f5', dark: '#3f3f46' },
            { name: 'Stone',     hex: '#78716c', rgb: '120 113 108',  light: '#f5f5f4', dark: '#44403c' },
            { name: 'Copper',    hex: '#b45309', rgb: '180 83 9',     light: '#fef3c7', dark: '#92400e' },
            { name: 'Midnight',  hex: '#1e1b4b', rgb: '30 27 75',     light: '#ede9fe', dark: '#0f0c29' },
        ];

        (function() {
            @php
                $settingsPath = config_path('settings.json');
                $serverDefaultMode = 'light';
                if (file_exists($settingsPath)) {
                    $settingsData = json_decode(file_get_contents($settingsPath), true);
                    $serverDefaultMode = $settingsData['default_mode'] ?? 'light';
                }
            @endphp
            const serverDefault = @json($serverDefaultMode);
            const theme = localStorage.getItem('admin-theme') || serverDefault;
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            const savedAccent = localStorage.getItem('admin-accent') || 'Purple';
            const palette = window.ACCENT_PALETTES.find(p => p.name === savedAccent) || window.ACCENT_PALETTES[0];
            
            document.documentElement.style.setProperty('--accent', palette.rgb);
            document.documentElement.style.setProperty('--accent-light', palette.light);
            document.documentElement.style.setProperty('--accent-dark', palette.dark);
            document.documentElement.style.setProperty('--accent-hex', palette.hex);
            document.documentElement.style.setProperty('--accent-hex-light', palette.light);
        })();
    </script>
    
    <style>
        :root {
            --accent: 168 85 247;
            --accent-light: #f3e8ff;
            --accent-dark: #7e22ce;
            --accent-hex: #a855f7;
            --accent-hex-light: #f3e8ff;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
        main {
            padding-top: 5rem !important;
        }
        /* Custom slide-out and transitions for sidebar collapse */
        .sidebar-transition {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        /* Override Bootstrap conflicts */
        a {
            text-decoration: none !important;
        }
        .btn:focus, .form-control:focus, .form-select:focus {
            box-shadow: none !important;
        }
        kbd {
            color: #64748b !important;
            background-color: #f1f5f9 !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,0.05) !important;
            padding: 0.125rem 0.375rem !important;
            font-size: 10px !important;
            font-weight: 700 !important;
            font-family: inherit !important;
            border-radius: 0.25rem !important;
        }
        .dark kbd {
            color: #94a3b8 !important;
            background-color: #1e293b !important;
            border: 1px solid #334155 !important;
        }
        /* Scrollbar styles */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }
        /* Active menu highlight with purple gradient override */
        .active-menu-item {
            background: linear-gradient(135deg, var(--accent-hex) 0%, var(--accent-dark) 100%) !important;
            box-shadow: 0 4px 14px 0 rgba(var(--accent), 0.35) !important;
            color: #ffffff !important;
        }

        /* Dynamic Tailwind background overrides */
        .bg-purple-50, .bg-indigo-50, .dark .bg-purple-950\/10, .dark .bg-indigo-950\/10 {
            background-color: var(--accent-hex-light) !important;
        }
        .bg-purple-100, .bg-indigo-100 {
            background-color: var(--accent-hex-light) !important;
        }
        .bg-purple-500, .bg-indigo-500, .bg-purple-600, .bg-indigo-600 {
            background-color: var(--accent-hex) !important;
        }
        .bg-purple-700, .bg-indigo-700 {
            background-color: var(--accent-dark) !important;
        }
        .hover\:bg-purple-50:hover, .hover\:bg-indigo-50:hover {
            background-color: var(--accent-hex-light) !important;
        }
        .hover\:bg-purple-100:hover, .hover\:bg-indigo-100:hover {
            background-color: var(--accent-hex-light) !important;
        }
        .hover\:bg-purple-600:hover, .hover\:bg-indigo-600:hover {
            background-color: var(--accent-hex) !important;
        }
        .hover\:bg-purple-700:hover, .hover\:bg-indigo-700:hover {
            background-color: var(--accent-dark) !important;
        }

        /* Dynamic Tailwind text overrides */
        .text-purple-500, .text-indigo-500, .text-purple-600, .text-indigo-600, .text-purple-700, .text-indigo-700 {
            color: var(--accent-hex) !important;
        }
        .hover\:text-purple-600:hover, .hover\:text-indigo-600:hover, .hover\:text-purple-700:hover, .hover\:text-indigo-700:hover {
            color: var(--accent-dark) !important;
        }

        /* Dynamic Tailwind border overrides */
        .border-purple-100, .border-indigo-100 {
            border-color: var(--accent-hex-light) !important;
        }
        .border-purple-500, .border-indigo-500, .border-purple-600, .border-indigo-600 {
            border-color: var(--accent-hex) !important;
        }

        /* Dynamic Tailwind ring/focus overrides */
        .ring-purple-500, .ring-indigo-500, .focus\:ring-purple-500:focus, .focus\:ring-indigo-500:focus {
            --tw-ring-color: rgba(var(--accent), 0.5) !important;
            border-color: var(--accent-hex) !important;
        }
        .focus\:border-purple-500:focus, .focus\:border-indigo-500:focus {
            border-color: var(--accent-hex) !important;
        }

        /* Dynamic Tailwind Gradients overrides */
        .from-purple-500, .from-indigo-500, .from-purple-600, .from-indigo-600 {
            --tw-gradient-from: var(--accent-hex) !important;
            --tw-gradient-to: var(--accent-dark) !important;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to) !important;
        }
        .to-purple-600, .to-indigo-600, .to-purple-700, .to-indigo-700 {
            --tw-gradient-to: var(--accent-dark) !important;
        }

        /* Bootstrap Button primary overrides */
        .btn-primary {
            background-color: var(--accent-hex) !important;
            border-color: var(--accent-hex) !important;
            color: #fff !important;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: var(--accent-dark) !important;
            border-color: var(--accent-dark) !important;
            color: #fff !important;
            box-shadow: 0 0 0 0.25rem rgba(var(--accent), 0.25) !important;
        }
        .btn-outline-primary {
            color: var(--accent-hex) !important;
            border-color: var(--accent-hex) !important;
        }
        .btn-outline-primary:hover, .btn-outline-primary:focus, .btn-outline-primary:active {
            background-color: var(--accent-hex) !important;
            border-color: var(--accent-hex) !important;
            color: #fff !important;
        }

        /* Form control focus overrides */
        .form-control:focus, .form-select:focus {
            border-color: var(--accent-hex) !important;
            box-shadow: 0 0 0 0.25rem rgba(var(--accent), 0.15) !important;
        }
        .form-check-input:checked {
            background-color: var(--accent-hex) !important;
            border-color: var(--accent-hex) !important;
        }
        .form-check-input:focus {
            border-color: var(--accent-hex) !important;
            box-shadow: 0 0 0 0.25rem rgba(var(--accent), 0.15) !important;
        }

        /* Custom scrollbar override */
        .custom-scrollbar::-webkit-scrollbar {
            width: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(var(--accent), 0.3);
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(var(--accent), 0.6);
        }
        /* Sidebar light mode nav hover */
        .sidebar-nav-hover:hover {
            background-color: #f1f5f9;
            color: #1e293b;
        }
        .dark .sidebar-nav-hover:hover {
            background-color: rgba(30, 41, 59, 0.4);
            color: #f1f5f9;
        }
        /* Sidebar dark gradient (applied via JS on dark mode) */
        .dark #sidebar {
            background: linear-gradient(to bottom, #0b0f19, #0f172a, #141235) !important;
            border-color: rgb(30 41 59) !important;
            color: rgb(203 213 225) !important;
        }
        .dark #sidebar .logo-container {
            border-bottom-color: rgba(30, 41, 59, 0.6) !important;
        }
        /* Collapsed sidebar structural changes */
        body.sidebar-collapsed #sidebar {
            width: 5rem;
        }
        body.sidebar-collapsed #sidebar .logo-full-text,
        body.sidebar-collapsed #sidebar .nav-label-text,
        body.sidebar-collapsed #sidebar .theme-label-text,
        body.sidebar-collapsed #sidebar .profile-details,
        body.sidebar-collapsed #sidebar .profile-chevron {
            display: none;
        }
        body.sidebar-collapsed #sidebar .logo-container {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        body.sidebar-collapsed #sidebar .sidebar-menu-category {
            text-align: center;
            font-size: 0.65rem;
            padding: 0.5rem 0;
        }
        body.sidebar-collapsed #sidebar .sidebar-menu-category::after {
            content: "⋯";
            display: block;
        }
        body.sidebar-collapsed #sidebar .sidebar-menu-category-text {
            display: none;
        }
        body.sidebar-collapsed #sidebar .nav-link-item {
            justify-content: center;
            padding: 0.75rem 0;
        }
        body.sidebar-collapsed #sidebar .theme-selector-wrapper {
            flex-direction: column;
            gap: 0.5rem;
            padding: 0.5rem 0.25rem;
        }
        body.sidebar-collapsed #sidebar .theme-radio-btn {
            padding: 0.5rem;
        }
        body.sidebar-collapsed #sidebar .profile-wrapper {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        body.sidebar-collapsed #main-content-area {
            margin-left: 5rem;
        }
        /* Floating Dropdown states */
        .dropdown-animate {
            transform-origin: top right;
            transition: opacity 0.15s ease-out, transform 0.15s ease-out;
        }
        .hidden-dropdown {
            opacity: 0;
            transform: scale(0.95);
            pointer-events: none;
        }
        body.sidebar-collapsed header {
            left: 5rem !important;
        }
        #sidebar-profile-dropdown {
            left: 1rem !important;
            right: 1rem !important;
            width: auto !important;
        }
        body.sidebar-collapsed #sidebar-profile-dropdown {
            left: 5.5rem !important;
            right: auto !important;
            width: 14rem !important;
            bottom: 0px !important;
            margin-bottom: 0 !important;
        }
        
        /* Sun/moon icon visibility inside toggle button */
        #theme-toggle-btn .sun-icon {
            display: none;
        }
        #theme-toggle-btn .moon-icon {
            display: block;
        }
        .dark #theme-toggle-btn .sun-icon {
            display: block;
        }
        .dark #theme-toggle-btn .moon-icon {
            display: none;
        }
        
        /* Dark mode overrides for full dashboard sections */
        .dark body {
            background-color: #0b0f19 !important;
            color: #cbd5e1 !important;
        }
        .dark header {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
        }
        .dark #main-content-area {
            background-color: #0b0f19 !important;
        }
        .dark .bg-white {
            background-color: #0f172a !important;
        }
        .dark .bg-slate-50 {
            background-color: #0b0f19 !important;
        }
        .dark .bg-slate-100 {
            background-color: #1e293b !important;
        }
        .dark .bg-slate-100\/70 {
            background-color: rgba(30, 41, 59, 0.7) !important;
        }
        .dark .border-slate-200 {
            border-color: #1e293b !important;
        }
        .dark .text-slate-900 {
            color: #ffffff !important;
        }
        .dark .text-slate-800 {
            color: #e2e8f0 !important;
        }
        .dark .text-slate-700 {
            color: #cbd5e1 !important;
        }
        .dark .text-slate-650 {
            color: #cbd5e1 !important;
        }
        .dark .text-slate-600 {
            color: #94a3b8 !important;
        }
        .dark .text-slate-500 {
            color: #94a3b8 !important;
        }
        .dark .border-slate-100 {
            border-color: #1e293b !important;
        }
        .dark .hover\:bg-slate-50:hover {
            background-color: #1e293b !important;
        }
        .dark .bg-slate-50:hover {
            background-color: #1e293b !important;
        }
        .dark input {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #ffffff !important;
        }
        .dark select {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #ffffff !important;
        }
        .dark hr {
            border-color: #1e293b !important;
        }
        .dark .dropdown-animate {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
        }
        .dark .dropdown-animate a {
            color: #cbd5e1 !important;
        }
        .dark .dropdown-animate a:hover {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }
        .dark .search-result-item {
            color: #cbd5e1 !important;
        }
        .dark .search-result-item:hover {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }
        .dark #search-modal > div {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
        }
        
        /* Bootstrap dark mode overrides for Module Builder components */
        .dark .card {
            background-color: #0f172a !important;
            color: #ffffff !important;
            border-color: #1e293b !important;
        }
        .dark .card-body {
            color: #e2e8f0 !important;
        }
        .dark .text-muted {
            color: #94a3b8 !important;
        }
        .dark .table {
            --bs-table-color: #cbd5e1 !important;
            --bs-table-bg: transparent !important;
            --bs-table-border-color: #1e293b !important;
            --bs-table-hover-color: #ffffff !important;
            --bs-table-hover-bg: #1e293b !important;
            color: #cbd5e1 !important;
        }
        .dark .table th, .dark .table td {
            background-color: transparent !important;
            color: #cbd5e1 !important;
            border-color: #1e293b !important;
        }
        .dark .table-hover tbody tr:hover td {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }
        .dark .list-group-item {
            background-color: #0f172a !important;
            color: #cbd5e1 !important;
            border-color: #1e293b !important;
        }
        .dark .form-control, .dark .form-select {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #ffffff !important;
        }
        .dark .form-control::placeholder {
            color: #64748b !important;
        }
        .dark .form-control:focus, .dark .form-select:focus {
            background-color: #1e293b !important;
            color: #ffffff !important;
            border-color: #a855f7 !important;
            box-shadow: 0 0 0 0.25rem rgba(168, 85, 247, 0.25) !important;
        }
        .dark .btn-close {
            filter: invert(1) grayscale(1) brightness(2) !important;
        }
        .dark .alert {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #e2e8f0 !important;
        }
        .dark .modal-content {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
            color: #ffffff !important;
        }
        .dark .modal-header, .dark .modal-footer {
            border-color: #1e293b !important;
        }
        
        /* Dark mode overrides for card icon badges in Module Builder */
        .dark .bg-primary.bg-opacity-10 {
            background-color: rgba(99, 102, 241, 0.2) !important;
        }
        .dark .bg-primary.bg-opacity-10 i {
            color: #818cf8 !important;
        }
        .dark .bg-success.bg-opacity-10 {
            background-color: rgba(16, 185, 129, 0.2) !important;
        }
        .dark .bg-success.bg-opacity-10 i {
            color: #34d399 !important;
        }
        .dark .bg-warning.bg-opacity-10 {
            background-color: rgba(245, 158, 11, 0.2) !important;
        }
        .dark .bg-warning.bg-opacity-10 i {
            color: #fbbf24 !important;
        }
        .dark .bg-secondary.bg-opacity-10 {
            background-color: rgba(148, 163, 184, 0.2) !important;
        }
        .dark .bg-secondary.bg-opacity-10 i {
            color: #cbd5e1 !important;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 transition-colors duration-200 antialiased overflow-x-hidden">

        @include('dashboard::layouts.partials.sidebar')

    <!-- Mobile Sidebar Backdrop -->
    <div id="mobile-sidebar-backdrop" class="fixed inset-0 z-30 bg-slate-900/40 backdrop-blur-sm hidden md:hidden"></div>

    <div class="flex min-h-screen">

        <!-- ========================================== -->
        <!-- MAIN CONTENT AREA                          -->
        <!-- ========================================== -->
        <div id="main-content-area" class="sidebar-transition flex-1 flex flex-col md:ml-64 min-w-0 h-screen overflow-hidden">
            
            @include('dashboard::layouts.partials.header')


            <!-- PAGE CONTENT ROUTER -->
            <main class="flex-1 overflow-y-auto pt-16 px-6 md:px-8 pb-8">
                <!-- Session Alert Messages -->
                @if(session('success'))
                    <div class="mt-6 mb-4 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-900/60 text-emerald-800 dark:text-emerald-300 flex items-center gap-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mt-6 mb-4 p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/20 border border-rose-200 dark:border-rose-900/60 text-rose-800 dark:text-rose-300 flex items-center gap-3">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-rose-500"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>

            @include('dashboard::layouts.partials.footer')

        </div>
    </div>

    <!-- ========================================== -->
    <!-- SEARCH PANEL DRAWER MODAL                  -->
    <!-- ========================================== -->
    <div id="search-modal" class="fixed inset-0 z-50 flex items-start justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="w-full max-w-xl mt-16 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <div class="flex items-center gap-3 px-4 py-3 border-b border-slate-200 dark:border-slate-800">
                <i data-lucide="search" class="w-5 h-5 text-slate-400"></i>
                <input type="text" id="search-input" placeholder="Search menus, features, orders or logs..." class="w-full bg-transparent border-0 outline-none text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm">
                <button id="search-close-btn" class="p-1 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-slate-400 dark:text-slate-500 transition">
                    <kbd>ESC</kbd>
                </button>
            </div>
            <div class="max-h-96 overflow-y-auto p-4 space-y-4">
                <div class="space-y-1.5">
                    <span class="text-xs font-semibold tracking-wider text-slate-400 dark:text-slate-500 uppercase">Quick Actions</span>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-2 hover:bg-slate-50 dark:hover:bg-slate-850 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 no-underline transition">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 text-purple-500"></i>
                        <span>Go to Dashboard</span>
                    </a>
                    <a href="{{ route('module-builder.index') }}" class="flex items-center gap-3 p-2 hover:bg-slate-50 dark:hover:bg-slate-850 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 no-underline transition">
                        <i data-lucide="cpu" class="w-4 h-4 text-indigo-500"></i>
                        <span>Open Module Builder</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 p-2 hover:bg-slate-50 dark:hover:bg-slate-850 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 no-underline transition">
                        <i data-lucide="settings" class="w-4 h-4 text-slate-500"></i>
                        <span>System Configuration</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Global Application Interactive Script -->
    <script>
        // Init Lucide Icons
        lucide.createIcons();

        // ----------------------------------------------------
        // Dropdown Utility Handler
        // ----------------------------------------------------
        function setupDropdown(triggerId, dropdownId) {
            const trigger = document.getElementById(triggerId);
            const dropdown = document.getElementById(dropdownId);
            if (!trigger || !dropdown) return;

            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                // Close all other dropdowns
                document.querySelectorAll('.dropdown-animate').forEach(d => {
                    if (d !== dropdown) {
                        d.classList.add('hidden-dropdown');
                    }
                });
                dropdown.classList.toggle('hidden-dropdown');
            });
        }

        setupDropdown('sidebar-profile-btn', 'sidebar-profile-dropdown');
        setupDropdown('message-btn', 'message-dropdown');
        setupDropdown('notification-btn', 'notification-dropdown');
        setupDropdown('topbar-avatar-btn', 'topbar-avatar-dropdown');

        // Close dropdowns on document click
        document.addEventListener('click', () => {
            document.querySelectorAll('.dropdown-animate').forEach(d => {
                d.classList.add('hidden-dropdown');
            });
        });

        // Prevent closing when clicking inside the dropdown panel itself
        document.querySelectorAll('.dropdown-animate').forEach(dropdown => {
            dropdown.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });

        // ----------------------------------------------------
        // Sidebar Toggling & Collapsing
        // ----------------------------------------------------
        const body = document.body;
        const mobileToggleBtn = document.getElementById('mobile-toggle-btn');
        const mobileBackdrop = document.getElementById('mobile-sidebar-backdrop');
        const sidebar = document.getElementById('sidebar');

        // Load Sidebar state from LocalStorage
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            body.classList.add('sidebar-collapsed');
        }

        function toggleSidebar() {
            body.classList.toggle('sidebar-collapsed');
            const isCollapsed = body.classList.contains('sidebar-collapsed');
            localStorage.setItem('sidebar-collapsed', isCollapsed);
        }

        // Mobile drawer slide-in / Desktop collapse
        if (mobileToggleBtn) {
            mobileToggleBtn.addEventListener('click', () => {
                if (window.innerWidth >= 768) {
                    toggleSidebar();
                } else {
                    sidebar.classList.remove('-translate-x-full');
                    mobileBackdrop.classList.remove('hidden');
                }
            });
        }

        if (mobileBackdrop) {
            mobileBackdrop.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                mobileBackdrop.classList.add('hidden');
            });
        }

        // ----------------------------------------------------
        // Dynamic Command Palette / Search Modal
        // ----------------------------------------------------
        const searchTrigger = document.getElementById('search-trigger-btn');
        const searchTriggerMobile = document.getElementById('search-trigger-mobile');
        const searchModal = document.getElementById('search-modal');
        const searchClose = document.getElementById('search-close-btn');
        const searchInput = document.getElementById('search-input');
        const searchResultsContainer = document.querySelector('#search-modal .max-h-96');

        window.setSelectedIndex = function(index) {
            selectedIndex = index;
            const items = searchResultsContainer.querySelectorAll('.search-result-item');
            items.forEach((item) => {
                const itemIndex = parseInt(item.getAttribute('data-index'), 10);
                const isSelected = itemIndex === selectedIndex;
                
                if (isSelected) {
                    item.classList.remove('hover:bg-slate-50', 'dark:hover:bg-slate-850/50', 'text-slate-700', 'dark:text-slate-300');
                    item.classList.add('bg-slate-100', 'dark:bg-slate-800', 'text-slate-900', 'dark:text-white', 'ring-1', 'ring-purple-500/20');
                    
                    const chevron = item.querySelector('[data-lucide="chevron-right"]');
                    if (chevron) {
                        chevron.classList.remove('opacity-0');
                        chevron.classList.add('opacity-100');
                    }
                } else {
                    item.classList.remove('bg-slate-100', 'dark:bg-slate-800', 'text-slate-900', 'dark:text-white', 'ring-1', 'ring-purple-500/20');
                    item.classList.add('hover:bg-slate-50', 'dark:hover:bg-slate-850/50', 'text-slate-700', 'dark:text-slate-300');
                    
                    const chevron = item.querySelector('[data-lucide="chevron-right"]');
                    if (chevron) {
                        chevron.classList.remove('opacity-100');
                        chevron.classList.add('opacity-0');
                    }
                }
            });
        };

        // All searchable items index
        const searchIndex = [
            { name: 'Dashboard', path: "{{ route('admin.dashboard') }}", category: 'Pages', icon: 'layout-dashboard', color: 'text-purple-500' },
            { name: 'Users', path: "{{ route('admin.users.index') }}", category: 'Management', icon: 'users', color: 'text-teal-500' },
            { name: 'Projects', path: '#', category: 'Management', icon: 'folder-kanban', color: 'text-orange-500' },
            { name: 'Tasks', path: '#', category: 'Management', icon: 'check-square', color: 'text-red-500' },
            { name: 'Orders', path: '#', category: 'Management', icon: 'shopping-cart', color: 'text-emerald-500' },
            { name: 'Products', path: '#', category: 'Management', icon: 'package', color: 'text-indigo-500' },
            { name: 'Module Builder', path: "{{ route('module-builder.index') }}", category: 'System', icon: 'cpu', color: 'text-pink-500' },
            { name: 'Roles & Permissions', path: "{{ route('admin.roles.index') }}", category: 'System', icon: 'shield', color: 'text-rose-500' },
            { name: 'Configuration', path: "{{ route('admin.settings') }}", category: 'System', icon: 'settings', color: 'text-slate-500' },
            { name: 'My Profile', path: "{{ route('admin.profile.edit') }}", category: 'Account', icon: 'user', color: 'text-sky-500' },
            { name: 'Account Settings', path: "{{ route('admin.profile.edit') }}", category: 'Account', icon: 'settings', color: 'text-purple-500' }
        ];

        let selectedIndex = 0;
        let filteredItems = [];

        function renderResults(query = '') {
            filteredItems = searchIndex.filter(item => 
                item.name.toLowerCase().includes(query.toLowerCase()) || 
                item.category.toLowerCase().includes(query.toLowerCase())
            );

            if (filteredItems.length === 0) {
                searchResultsContainer.innerHTML = `
                    <div class="text-center py-8 text-slate-400 dark:text-slate-500 text-sm">
                        <i data-lucide="info" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                        No results found for "${query}"
                    </div>
                `;
                lucide.createIcons();
                return;
            }

            // Group by category
            const groups = {};
            filteredItems.forEach((item, index) => {
                const globalIndex = index;
                if (!groups[item.category]) {
                    groups[item.category] = [];
                }
                groups[item.category].push({ ...item, globalIndex });
            });

            let html = '';
            for (const category in groups) {
                html += `
                    <div class="space-y-1.5">
                        <span class="text-[10px] font-bold tracking-wider text-slate-400 dark:text-slate-500 uppercase px-2">${category}</span>
                        <div class="space-y-0.5">
                `;
                groups[category].forEach(item => {
                    const isSelected = item.globalIndex === selectedIndex;
                    const activeClasses = isSelected 
                        ? 'bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white ring-1 ring-purple-500/20' 
                        : 'hover:bg-slate-50 dark:hover:bg-slate-850/50 text-slate-700 dark:text-slate-300';
                    
                    html += `
                        <a href="${item.path}" class="search-result-item flex items-center justify-between p-2.5 rounded-xl text-sm font-medium transition duration-100 no-underline ${activeClasses}" data-index="${item.globalIndex}" onmouseenter="setSelectedIndex(${item.globalIndex})">
                            <div class="flex items-center gap-3">
                                <div class="p-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
                                    <i data-lucide="${item.icon}" class="w-4 h-4 ${item.color}"></i>
                                </div>
                                <span>${item.name}</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5 transition-opacity duration-100 ${isSelected ? 'opacity-100 text-slate-400' : 'opacity-0'}"></i>
                        </a>
                    `;
                });
                html += `
                        </div>
                    </div>
                `;
            }

            searchResultsContainer.innerHTML = html;
            lucide.createIcons();
        }

        function openSearch() {
            if (searchModal) {
                searchModal.classList.remove('hidden');
                searchInput.value = '';
                selectedIndex = 0;
                renderResults('');
                setTimeout(() => searchInput.focus(), 50);
            }
        }

        function closeSearch() {
            if (searchModal) {
                searchModal.classList.add('hidden');
            }
        }

        if (searchTrigger) searchTrigger.addEventListener('click', openSearch);
        if (searchTriggerMobile) searchTriggerMobile.addEventListener('click', openSearch);
        if (searchClose) searchClose.addEventListener('click', closeSearch);

        // Click backdrop to close search
        if (searchModal) {
            searchModal.addEventListener('click', (e) => {
                if (e.target === searchModal) {
                    closeSearch();
                }
            });
        }

        searchInput.addEventListener('input', (e) => {
            selectedIndex = 0;
            renderResults(e.target.value);
        });

        window.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                openSearch();
            }
            if (e.key === 'Escape') {
                closeSearch();
            }

            if (!searchModal.classList.contains('hidden')) {
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (filteredItems.length > 0) {
                        selectedIndex = (selectedIndex + 1) % filteredItems.length;
                        setSelectedIndex(selectedIndex);
                    }
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (filteredItems.length > 0) {
                        selectedIndex = (selectedIndex - 1 + filteredItems.length) % filteredItems.length;
                        setSelectedIndex(selectedIndex);
                    }
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (filteredItems[selectedIndex]) {
                        window.location.href = filteredItems[selectedIndex].path;
                    }
                }
            }
        });

        // ----------------------------------------------------
        // Theme Management Script
        // ----------------------------------------------------
        const themeToggleBtn = document.getElementById('theme-toggle-btn');

        function setTheme(theme) {
            localStorage.setItem('admin-theme', theme);
            const isDark = theme === 'dark';

            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            // Dispatch dynamic window event for child frames/charts to adapt
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme, isDark } }));
        }

        // Init theme from localStorage (default: light)
        const activeTheme = localStorage.getItem('admin-theme') || 'light';
        setTheme(activeTheme);

        window.toggleTheme = function() {
            const currentTheme = localStorage.getItem('admin-theme') || 'light';
            const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(nextTheme);
        };

        // ============================================================
        // COLOR PALETTE PICKER
        // ============================================================
        const ACCENT_PALETTES = window.ACCENT_PALETTES;

        function applyAccent(palette) {
            const root = document.documentElement;
            root.style.setProperty('--accent',           palette.rgb);
            root.style.setProperty('--accent-light',     palette.light);
            root.style.setProperty('--accent-dark',      palette.dark);
            root.style.setProperty('--accent-hex',       palette.hex);
            root.style.setProperty('--accent-hex-light', palette.light);

            // Persist choice
            localStorage.setItem('admin-accent', palette.name);

            // ─── GLOBAL STYLE OVERRIDE ────────────────────────────────────
            // Dynamically replace every hardcoded purple-* Tailwind class
            // with the chosen accent color. Works across all pages/components.
            const h = palette.hex;
            const d = palette.dark;
            const l = palette.light;
            // Build a hex with opacity helper
            const hex2rgba = (hex, alpha) => {
                const r = parseInt(hex.slice(1,3),16);
                const g = parseInt(hex.slice(3,5),16);
                const b = parseInt(hex.slice(5,7),16);
                return `rgba(${r},${g},${b},${alpha})`;
            };

            let styleEl = document.getElementById('accent-override-style');
            if (!styleEl) {
                styleEl = document.createElement('style');
                styleEl.id = 'accent-override-style';
                document.head.appendChild(styleEl);
            }

            styleEl.textContent = `
                /* ═══════════════════════════════════════════
                   PURPLE — ALL VARIANTS
                ═══════════════════════════════════════════ */
                /* Backgrounds */
                .bg-purple-50  { background-color: ${hex2rgba(h, 0.08)} !important; }
                .bg-purple-100 { background-color: ${hex2rgba(h, 0.15)} !important; }
                .bg-purple-200 { background-color: ${hex2rgba(h, 0.25)} !important; }
                .bg-purple-500 { background-color: ${h} !important; }
                .bg-purple-600 { background-color: ${h} !important; }
                .bg-purple-700 { background-color: ${d} !important; }
                /* Text */
                .text-purple-100 { color: ${hex2rgba(h, 0.9)} !important; }
                .text-purple-300 { color: ${hex2rgba(h, 0.75)} !important; }
                .text-purple-400 { color: ${hex2rgba(h, 0.8)} !important; }
                .text-purple-500 { color: ${h} !important; }
                .text-purple-600 { color: ${h} !important; }
                .text-purple-700 { color: ${d} !important; }
                .text-purple-900 { color: ${d} !important; }
                /* Borders */
                .border-purple-200   { border-color: ${hex2rgba(h, 0.3)} !important; }
                .border-purple-400   { border-color: ${hex2rgba(h, 0.6)} !important; }
                .border-purple-500   { border-color: ${h} !important; }
                .border-l-purple-500 { border-left-color: ${h} !important; }
                /* Gradients */
                .from-purple-500 { --tw-gradient-from: ${h} !important; }
                .from-purple-600 { --tw-gradient-from: ${h} !important; }
                .to-purple-600   { --tw-gradient-to:   ${h} !important; }
                .to-purple-700   { --tw-gradient-to:   ${d} !important; }
                .via-purple-500  { --tw-gradient-via:  ${h} !important; }
                /* Hover */
                .hover\\:from-purple-700:hover    { --tw-gradient-from: ${d} !important; }
                .hover\\:to-purple-700:hover      { --tw-gradient-to:   ${d} !important; }
                .hover\\:text-purple-700:hover    { color: ${d} !important; }
                .hover\\:border-purple-400:hover  { border-color: ${hex2rgba(h, 0.6)} !important; }
                .hover\\:border-purple-500:hover  { border-color: ${h} !important; }
                /* Dark variants */
                .dark .dark\\:bg-purple-500\\/10     { background-color: ${hex2rgba(h, 0.1)} !important; }
                .dark .dark\\:bg-purple-500\\/20     { background-color: ${hex2rgba(h, 0.2)} !important; }
                .dark .dark\\:border-purple-500\\/20 { border-color: ${hex2rgba(h, 0.2)} !important; }
                .dark .dark\\:text-purple-300        { color: ${hex2rgba(h, 0.85)} !important; }
                .dark .dark\\:text-purple-400        { color: ${hex2rgba(h, 0.75)} !important; }
                .dark .dark\\:hover\\:border-purple-500:hover { border-color: ${h} !important; }

                /* ═══════════════════════════════════════════
                   INDIGO — ALL VARIANTS (used in gradients)
                ═══════════════════════════════════════════ */
                .bg-indigo-50  { background-color: ${hex2rgba(h, 0.08)} !important; }
                .bg-indigo-100 { background-color: ${hex2rgba(h, 0.15)} !important; }
                .bg-indigo-500 { background-color: ${h} !important; }
                .bg-indigo-600 { background-color: ${h} !important; }
                .bg-indigo-700 { background-color: ${d} !important; }
                .text-indigo-400 { color: ${hex2rgba(h, 0.8)} !important; }
                .text-indigo-500 { color: ${h} !important; }
                .text-indigo-600 { color: ${h} !important; }
                .text-indigo-700 { color: ${d} !important; }
                .border-indigo-500 { border-color: ${h} !important; }
                .from-indigo-500 { --tw-gradient-from: ${h} !important; }
                .from-indigo-600 { --tw-gradient-from: ${h} !important; }
                .to-indigo-600   { --tw-gradient-to:   ${h} !important; }
                .to-indigo-700   { --tw-gradient-to:   ${d} !important; }
                .hover\\:to-indigo-700:hover { --tw-gradient-to: ${d} !important; }
                .dark .dark\\:text-indigo-400 { color: ${hex2rgba(h, 0.8)} !important; }

                /* ═══════════════════════════════════════════
                   GRADIENT COMBINATIONS (sidebar logo, buttons)
                ═══════════════════════════════════════════ */
                .bg-gradient-to-tr.from-purple-600.to-indigo-600,
                .bg-gradient-to-tr.from-purple-600,
                [class*="from-purple-"][class*="to-indigo-"] {
                    background-image: linear-gradient(to top right, ${h}, ${d}) !important;
                }
                .bg-gradient-to-br.from-purple-600,
                [class*="from-purple-"][class*="to-indigo-"].bg-gradient-to-br {
                    background-image: linear-gradient(to bottom right, ${h}, ${d}) !important;
                }
                .bg-gradient-to-r.from-purple-600,
                .bg-gradient-to-r.from-indigo-600 {
                    background-image: linear-gradient(to right, ${h}, ${d}) !important;
                }

                /* ═══════════════════════════════════════════
                   BOOTSTRAP BUTTONS — btn-primary, btn-outline-primary
                ═══════════════════════════════════════════ */
                .btn-primary {
                    background-color: ${h} !important;
                    border-color: ${h} !important;
                    color: #fff !important;
                }
                .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
                    background-color: ${d} !important;
                    border-color: ${d} !important;
                    color: #fff !important;
                    box-shadow: 0 0 0 0.25rem ${hex2rgba(h, 0.35)} !important;
                }
                .btn-outline-primary {
                    color: ${h} !important;
                    border-color: ${h} !important;
                    background: transparent !important;
                }
                .btn-outline-primary:hover, .btn-outline-primary:focus {
                    background-color: ${h} !important;
                    border-color: ${h} !important;
                    color: #fff !important;
                }
                .btn-primary:focus-visible, .btn-outline-primary:focus-visible {
                    box-shadow: 0 0 0 0.25rem ${hex2rgba(h, 0.35)} !important;
                }

                /* ═══════════════════════════════════════════
                   FORM CONTROLS — focus ring + border (light & dark)
                ═══════════════════════════════════════════ */
                input:focus, select:focus, textarea:focus,
                .form-control:focus, .form-select:focus, .form-textarea:focus {
                    border-color: ${h} !important;
                    box-shadow: 0 0 0 3px ${hex2rgba(h, 0.2)} !important;
                    outline: none !important;
                }
                .focus\\:ring-purple-500:focus,
                .focus\\:ring-indigo-500:focus {
                    --tw-ring-color: ${h} !important;
                    box-shadow: 0 0 0 3px ${hex2rgba(h, 0.25)} !important;
                }
                .focus\\:border-purple-500:focus,
                .focus\\:border-indigo-500:focus {
                    border-color: ${h} !important;
                }
                .dark .form-control:focus, .dark .form-select:focus, .dark .form-textarea:focus {
                    border-color: ${h} !important;
                    box-shadow: 0 0 0 0.25rem ${hex2rgba(h, 0.25)} !important;
                }

                /* ═══════════════════════════════════════════
                   FILTER / SELECT BUTTONS
                ═══════════════════════════════════════════ */
                .focus\\:ring-1.focus\\:ring-purple-500:focus {
                    box-shadow: 0 0 0 1px ${h} !important;
                }
                select:focus {
                    border-color: ${h} !important;
                    box-shadow: 0 0 0 2px ${hex2rgba(h, 0.25)} !important;
                }

                /* ═══════════════════════════════════════════
                   ACTIVE MENU ITEM
                ═══════════════════════════════════════════ */
                .active-menu-item {
                    background: linear-gradient(135deg, ${h} 0%, ${d} 100%) !important;
                    box-shadow: 0 4px 14px 0 ${hex2rgba(h, 0.35)} !important;
                }

                /* ═══════════════════════════════════════════
                   SHADOWS
                ═══════════════════════════════════════════ */
                .shadow-purple-500\\/10 { box-shadow: 0 4px 6px -1px ${hex2rgba(h, 0.1)} !important; }

                /* ═══════════════════════════════════════════
                   PROFILE / AVATAR RING ON HOVER
                ═══════════════════════════════════════════ */
                .accent-avatar {
                    border-color: ${hex2rgba(h, 0.3)} !important;
                    transition: border-color 0.2s, box-shadow 0.2s !important;
                }
                .accent-avatar:hover {
                    border-color: ${h} !important;
                    box-shadow: 0 0 0 3px ${hex2rgba(h, 0.25)} !important;
                }

                /* ═══════════════════════════════════════════
                   BADGE / PILL ACCENTS
                ═══════════════════════════════════════════ */
                .badge.bg-primary, .badge-primary {
                    background-color: ${h} !important;
                    color: #fff !important;
                }
            `;
            // ─────────────────────────────────────────────────────────────

            // ── Update all .accent-avatar img src URLs ────────────────────
            // Replace the `background=XXXXXX` param in ui-avatars URLs
            const hexNoHash = h.replace('#', '');
            document.querySelectorAll('img.accent-avatar').forEach(img => {
                const currentSrc = img.src || img.getAttribute('src') || '';
                if (currentSrc.includes('ui-avatars.com')) {
                    img.src = currentSrc.replace(/background=[0-9a-fA-F]{6}/, `background=${hexNoHash}`);
                }
            });
            // ─────────────────────────────────────────────────────────────

            // Update header gradient strip
            const strip = document.getElementById('palette-header-strip');
            if (strip) strip.style.background = `linear-gradient(135deg, ${h} 0%, ${d} 100%)`;

            // Update current name + hex label
            const nameLabel = document.getElementById('palette-current-name');
            if (nameLabel) nameLabel.textContent = palette.name;
            const hexLabel = document.getElementById('palette-current-hex');
            if (hexLabel) hexLabel.textContent = palette.hex;

            // Update color count badge
            const countBadge = document.getElementById('palette-color-count');
            if (countBadge) countBadge.textContent = ACCENT_PALETTES.length + ' colors';

            // Re-paint inline-styled accent elements
            document.querySelectorAll('.accent-pulse-badge').forEach(el => {
                el.style.background = `linear-gradient(135deg, ${h}, ${d})`;
            });
            document.querySelectorAll('.accent-btn').forEach(el => {
                el.style.backgroundColor = h;
            });

            // Refresh grouped swatch panel
            renderGroups();

            window.dispatchEvent(new CustomEvent('accent-changed', { detail: palette }));

        }

        // ── Color groups definition ────────────────────────────────
        const PALETTE_GROUPS = [
            { label: '🌀 Cool',    emoji: '❄️', names: ['Purple','Violet','Indigo','Blue','Sky','Cyan'] },
            { label: '🌿 Nature',  emoji: '🌿', names: ['Teal','Emerald','Green','Lime'] },
            { label: '🔥 Warm',   emoji: '🔥', names: ['Yellow','Amber','Orange','Red'] },
            { label: '✨ Vibrant', emoji: '✨', names: ['Rose','Pink','Fuchsia','Magenta'] },
            { label: '🪨 Neutral', emoji: '🪨', names: ['Slate','Gray','Zinc','Stone','Copper','Midnight'] },
        ];

        function renderGroups() {
            const groupsContainer = document.getElementById('palette-groups');
            if (!groupsContainer) return;
            const saved = localStorage.getItem('admin-accent') || 'Purple';
            const isDark = document.documentElement.classList.contains('dark');
            const borderColor = isDark ? '#1e293b' : '#f1f5f9';

            groupsContainer.innerHTML = '';

            PALETTE_GROUPS.forEach((group, gi) => {
                const palettes = group.names
                    .map(n => ACCENT_PALETTES.find(p => p.name === n))
                    .filter(Boolean);
                if (!palettes.length) return;

                // Group wrapper
                const groupEl = document.createElement('div');
                groupEl.style.cssText = `
                    margin-bottom: 10px;
                    padding-bottom: ${gi < PALETTE_GROUPS.length - 1 ? '10px' : '0'};
                    border-bottom: ${gi < PALETTE_GROUPS.length - 1 ? `1px solid ${borderColor}` : 'none'};
                `;

                // Group label
                const labelEl = document.createElement('div');
                labelEl.textContent = group.label;
                labelEl.style.cssText = `
                    font-size: 9px;
                    font-weight: 700;
                    color: #94a3b8;
                    text-transform: uppercase;
                    letter-spacing: 0.1em;
                    margin-bottom: 7px;
                    padding-left: 2px;
                `;
                groupEl.appendChild(labelEl);

                // Swatch row grid (6-per-row max)
                const grid = document.createElement('div');
                grid.style.cssText = `
                    display: grid;
                    grid-template-columns: repeat(6, 1fr);
                    gap: 4px;
                `;

                palettes.forEach(p => {
                    const isActive = p.name === saved;
                    const glow = p.hex + '55';

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.title = p.name;
                    btn.onclick = () => applyAccentByName(p.name);
                    btn.style.cssText = `
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        gap: 5px;
                        padding: 6px 2px;
                        border-radius: 10px;
                        border: none;
                        cursor: pointer;
                        background: ${isActive ? (isDark ? 'rgba(30, 41, 59, 0.6)' : '#f1f5f9') : 'transparent'};
                        transition: background 0.15s;
                        width: 100%;
                    `;

                    const circle = document.createElement('span');
                    circle.style.cssText = `
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 30px;
                        height: 30px;
                        border-radius: 9999px;
                        background-color: ${p.hex};
                        transition: transform 0.15s, box-shadow 0.15s;
                        transform: ${isActive ? 'scale(1.15)' : 'scale(1)'};
                        box-shadow: ${isActive ? `0 0 0 2px ${isDark ? '#0f172a' : 'white'}, 0 0 0 4px ${p.hex}, 0 3px 10px ${glow}` : 'none'};
                    `;
                    if (isActive) {
                        circle.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`;
                    }

                    const lbl = document.createElement('span');
                    lbl.textContent = p.name;
                    lbl.style.cssText = `
                        font-size: 8px;
                        font-weight: ${isActive ? '700' : '500'};
                        color: ${isActive ? p.hex : '#94a3b8'};
                        line-height: 1;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        max-width: 100%;
                        transition: color 0.15s;
                    `;

                    btn.addEventListener('mouseenter', () => {
                        if (!isActive) { 
                            btn.style.background = isDark ? 'rgba(30, 41, 59, 0.4)' : '#f8fafc'; 
                            circle.style.transform = 'scale(1.08)'; 
                            lbl.style.color = isDark ? '#cbd5e1' : '#64748b'; 
                        }
                    });
                    btn.addEventListener('mouseleave', () => {
                        if (!isActive) { 
                            btn.style.background = 'transparent'; 
                            circle.style.transform = 'scale(1)'; 
                            lbl.style.color = '#94a3b8'; 
                        }
                    });

                    btn.appendChild(circle);
                    btn.appendChild(lbl);
                    grid.appendChild(btn);
                });

                groupEl.appendChild(grid);
                groupsContainer.appendChild(groupEl);
            });
        }

        window.applyAccentByName = function(name) {
            const p = ACCENT_PALETTES.find(x => x.name === name);
            if (p) applyAccent(p);
        };

        // Boot: load saved accent or default to Purple
        (function initAccent() {
            const savedName = localStorage.getItem('admin-accent') || 'Purple';
            const palette = ACCENT_PALETTES.find(p => p.name === savedName) || ACCENT_PALETTES[0];
            applyAccent(palette);
        })();

        // Reset button: clear saved accent & reapply default (Purple)
        const paletteResetBtn = document.getElementById('palette-reset-btn');
        if (paletteResetBtn) {
            paletteResetBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                localStorage.removeItem('admin-accent');
                const defaultPalette = ACCENT_PALETTES[0]; // Purple
                applyAccent(defaultPalette);

                // Brief visual feedback on the button
                paletteResetBtn.classList.add('text-rose-500');
                setTimeout(() => paletteResetBtn.classList.remove('text-rose-500'), 800);
            });
        }

        // Wire up the palette button to the dropdown system
        setupDropdown('color-palette-btn', 'color-palette-dropdown');

        // Scroll fade: hide gradient when user scrolls to bottom of swatch list
        const swatchScroll = document.getElementById('palette-swatches-scroll');
        const scrollFade   = document.getElementById('palette-scroll-fade');
        if (swatchScroll && scrollFade) {
            swatchScroll.addEventListener('scroll', () => {
                const atBottom = swatchScroll.scrollTop + swatchScroll.clientHeight >= swatchScroll.scrollHeight - 4;
                scrollFade.style.opacity = atBottom ? '0' : '1';
                scrollFade.style.transition = 'opacity 0.2s';
            });
        }

    </script>
    @stack('scripts')
</body>
</html>
