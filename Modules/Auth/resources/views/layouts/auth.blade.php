<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Welcome') — {{ config('app.name', 'SaaS App') }}</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
    <meta name="theme-color" content="#6366f1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ── Reset & Base ──────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0b0f19;
            color: #f8fafc;
            overflow: hidden; /* NO SCROLL anywhere */
        }

        /* ── Full-screen layout ────────────────────────────────── */
        .auth-wrapper {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        /* ── Left Panel ────────────────────────────────────────── */
        .auth-left {
            display: none;
            flex-direction: column;
            width: 48%;
            background: linear-gradient(145deg, #0f172a 0%, #1e1b4b 55%, #2d1155 100%);
            border-right: 1px solid rgba(255,255,255,0.07);
            position: relative;
            overflow: hidden;
            padding: 2.5rem 2.8rem;
        }
        @media (min-width: 992px) {
            .auth-left { display: flex; }
        }

        /* Ambient glows */
        .auth-left::before {
            content: '';
            position: absolute;
            width: 320px; height: 320px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            filter: blur(90px);
            opacity: 0.18;
            bottom: -60px; left: -60px;
            pointer-events: none;
        }
        .auth-left::after {
            content: '';
            position: absolute;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: linear-gradient(135deg, #06b6d4, #10b981);
            filter: blur(80px);
            opacity: 0.13;
            top: -40px; right: -40px;
            pointer-events: none;
        }

        .auth-left-inner {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Brand */
        .auth-brand {
            font-size: 1.35rem;
            font-weight: 800;
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            flex-shrink: 0;
        }

        /* Left hero text */
        .auth-hero { flex-shrink: 0; margin-top: 1.5rem; }
        .auth-hero h2 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.3;
            margin-bottom: .5rem;
        }
        .auth-hero p {
            font-size: .78rem;
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        /* Feature bullets */
        .auth-features { flex-shrink: 0; display: flex; flex-direction: column; gap: .55rem; }
        .auth-feature-item {
            display: flex;
            align-items: center;
            gap: .65rem;
            font-size: .77rem;
            color: #94a3b8;
        }
        .auth-feature-icon {
            width: 30px; height: 30px;
            border-radius: .5rem;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: .85rem;
        }

        /* Credentials section on left */
        .auth-credentials {
            flex: 1;
            overflow-y: auto;
            padding-top: .75rem;
            scrollbar-width: none; /* Firefox */
        }
        .auth-credentials::-webkit-scrollbar { display: none; }

        /* ── Right Panel ───────────────────────────────────────── */
        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0b0f19;
            overflow-y: auto;
            padding: 1.25rem;
            scrollbar-width: none;
        }
        .auth-right::-webkit-scrollbar { display: none; }

        /* Form card */
        .auth-card {
            background: rgba(30, 41, 59, 0.45);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 1.25rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.35);
            padding: 2rem 2.25rem;
            width: 100%;
            max-width: 420px;
        }

        /* Mobile logo */
        .auth-mobile-logo {
            font-size: 1.25rem;
            font-weight: 800;
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
        }

        /* Form elements */
        .form-label {
            font-weight: 500;
            color: #cbd5e1;
            font-size: .82rem;
            margin-bottom: .35rem;
        }
        .form-control {
            background: rgba(15, 23, 42, 0.65);
            border: 1px solid rgba(255,255,255,0.1);
            color: #f8fafc;
            border-radius: .65rem;
            padding: .55rem .85rem;
            font-size: .875rem;
            transition: all .2s;
            height: 40px;
        }
        .form-control:focus {
            background: rgba(15, 23, 42, 0.85);
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(129,140,248,0.22);
            color: #fff;
        }
        .form-control::placeholder { color: #475569; }

        .input-group-text {
            background: rgba(15, 23, 42, 0.65);
            border: 1px solid rgba(255,255,255,0.1);
            color: #64748b;
            font-size: .85rem;
        }
        .input-group-text-toggle {
            background: rgba(15, 23, 42, 0.65);
            border: 1px solid rgba(255,255,255,0.1);
            border-left: none;
            color: #9ca3af;
            cursor: pointer;
            border-radius: 0 .65rem .65rem 0;
            display: flex;
            align-items: center;
            padding: 0 .85rem;
            transition: color .2s;
            height: 40px;
        }
        .input-group-text-toggle:hover { color: #e2e8f0; }
        .input-group .form-control { height: 40px; }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border: none;
            border-radius: .65rem;
            padding: .6rem 1.25rem;
            font-weight: 600;
            font-size: .875rem;
            transition: all .2s;
            height: 40px;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 16px rgba(99,102,241,0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            border: none;
            border-radius: .65rem;
            padding: .6rem 1.25rem;
            font-weight: 600;
            font-size: .875rem;
            transition: all .2s;
            height: 40px;
        }
        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 16px rgba(220,38,38,0.3);
        }

        .alert { border-radius: .65rem; border: none; font-size: .82rem; padding: .55rem .85rem; }
        .text-muted { color: #94a3b8 !important; }

        a { color: #818cf8; text-decoration: none; transition: color .15s; }
        a:hover { color: #a5b4fc; }

        /* form-check compact */
        .form-check-input {
            background-color: rgba(15,23,42,0.6);
            border-color: rgba(255,255,255,0.15);
        }
        .form-check-label { color: #94a3b8; font-size: .8rem; }

        /* Credential cards */
        .cred-card {
            cursor: pointer;
            border-radius: .75rem;
            padding: .65rem .85rem;
            margin-bottom: .5rem;
            transition: transform .18s, box-shadow .18s;
        }
        .cred-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        .cred-card:last-child { margin-bottom: 0; }
        .cred-card-label {
            font-size: .67rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-bottom: .3rem;
        }
        .cred-card-row {
            font-size: .73rem;
            color: #cbd5e1;
            display: flex;
            align-items: center;
            gap: .4rem;
        }
        .cred-card-row code {
            font-size: .71rem;
        }
        .cred-fill-hint {
            font-size: .6rem;
            color: #475569;
            border: 1px solid rgba(255,255,255,.07);
            background: rgba(255,255,255,.04);
            border-radius: 3px;
            padding: 1px 5px;
            margin-left: auto;
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="auth-wrapper">

    {{-- ── LEFT PANEL (Desktop only) ── --}}
    <div class="auth-left">
        <div class="auth-left-inner">

            {{-- Brand --}}
            <a href="/" class="auth-brand">
                <i class="bi bi-shield-lock-fill"></i>
                {{ config('app.name', 'SaaSStater') }}
            </a>

            {{-- Hero --}}
            <div class="auth-hero">
                <h2>Enterprise SaaS<br>Blueprint</h2>
                <p>Launch faster with multi-tenant isolation, dynamic modules, robust audit logging, and role-based access control.</p>

                <div class="auth-features">
                    <div class="auth-feature-item">
                        <div class="auth-feature-icon" style="background:rgba(99,102,241,.15); color:#818cf8;">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <span>Dynamic Module Builder & Scaffold engine</span>
                    </div>
                    <div class="auth-feature-item">
                        <div class="auth-feature-icon" style="background:rgba(16,185,129,.15); color:#34d399;">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <span>Secure portal with audit & activity logs</span>
                    </div>
                    <div class="auth-feature-item">
                        <div class="auth-feature-icon" style="background:rgba(6,182,212,.15); color:#22d3ee;">
                            <i class="bi bi-building-check"></i>
                        </div>
                        <span>Seamless multi-tenant isolation layers</span>
                    </div>
                </div>
            </div>

            {{-- Credentials section (scrollable if needed, but compact) --}}
            @hasSection('left-bottom')
                <div class="auth-credentials">
                    @yield('left-bottom')
                </div>
            @endif

        </div>
    </div>

    {{-- ── RIGHT PANEL (Form) ── --}}
    <div class="auth-right">
        <div class="auth-card">

            {{-- Mobile logo --}}
            <div class="text-center d-lg-none mb-3">
                <a href="/" class="auth-mobile-logo">
                    <i class="bi bi-shield-lock-fill"></i>
                    {{ config('app.name', 'SaaSStater') }}
                </a>
            </div>

            @yield('content')
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Password visibility toggle
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.password-toggle-btn').forEach(function(btn) {
            btn.addEventListener('click', function () {
                var id    = this.getAttribute('data-target');
                var input = document.getElementById(id);
                var icon  = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('bi-eye-slash', 'bi-eye');
                } else {
                    input.type = 'password';
                    icon.classList.replace('bi-eye', 'bi-eye-slash');
                }
            });
        });
    });
</script>
@stack('scripts')
</body>
</html>
