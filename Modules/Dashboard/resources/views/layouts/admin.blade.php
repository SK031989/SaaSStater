<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — {{ config('app.name', 'SaaS Starter') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
        }
        .sidebar {
            background-color: #0f172a;
            border-right: 1px solid #e2e8f0;
            min-height: 100vh;
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #ffffff;
            font-size: 1.25rem;
            font-weight: 700;
            text-decoration: none;
            padding: 0 0.5rem;
        }
        .sidebar-category {
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            padding: 0 0.5rem;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #94a3b8;
            padding: 0.65rem 0.75rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.15s ease;
        }
        .sidebar-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
        }
        .sidebar-link.active {
            color: #ffffff;
            background-color: #2563eb;
        }
        .sidebar-plan-card {
            background-color: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 0.75rem;
            padding: 1rem;
            margin-top: auto;
        }
        .btn-upgrade {
            background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
            border: none;
            color: #ffffff;
            font-size: 0.875rem;
            font-weight: 600;
            width: 100%;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: opacity 0.15s;
        }
        .btn-upgrade:hover {
            opacity: 0.9;
            color: #ffffff;
        }
        .navbar-top {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .main-content {
            padding: 2rem;
            background-color: #f8fafc;
        }
        .admin-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
        .breadcrumb-custom {
            font-size: 0.75rem;
            color: #64748b;
        }
        .breadcrumb-item-custom + .breadcrumb-item-custom::before {
            content: ">";
            padding: 0 0.25rem;
            color: #94a3b8;
        }
        .nav-tabs-custom {
            border-bottom: 1px solid #e2e8f0;
        }
        .nav-tabs-custom .nav-link {
            border: none;
            color: #64748b;
            font-weight: 500;
            font-size: 0.875rem;
            padding: 0.75rem 1rem;
            border-bottom: 2px solid transparent;
        }
        .nav-tabs-custom .nav-link.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
            background: transparent;
        }
        .badge-published {
            background-color: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }
        .badge-draft {
            background-color: #fffbe6;
            color: #d97706;
            border: 1px solid #fef3c7;
        }
        .top-nav-icon {
            font-size: 1.25rem;
            color: #64748b;
            position: relative;
            cursor: pointer;
        }
        .top-nav-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background-color: #ef4444;
            color: #ffffff;
            font-size: 0.65rem;
            padding: 0.15rem 0.35rem;
            border-radius: 50%;
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="container-fluid p-0">
        <div class="row g-0">
            
            {{-- Sidebar navigation --}}
            <div class="col-md-3 col-lg-2 sidebar">
                <div>
                    {{-- Logo --}}
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-logo mb-4">
                        <i class="bi bi-box-seam-fill text-primary fs-4"></i>
                        <span>SaaS Starter</span>
                    </a>
                    
                    {{-- Navigation links --}}
                    <div class="d-flex flex-column gap-1">
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>

                        <div class="sidebar-category">Modules</div>

                        <a href="{{ route('module-builder.index') }}" class="sidebar-link {{ request()->routeIs('module-builder.*') ? 'active' : '' }}">
                            <i class="bi bi-grid-fill"></i>
                            <span>Module Builder</span>
                        </a>
                        
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-shield-lock"></i>
                            <span>Role & Permission</span>
                        </a>
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-people"></i>
                            <span>User Management</span>
                        </a>
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-building"></i>
                            <span>Tenant Management</span>
                        </a>
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-credit-card"></i>
                            <span>Plan & Subscription</span>
                        </a>
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-receipt"></i>
                            <span>Billing & Invoice</span>
                        </a>
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-headset"></i>
                            <span>Support</span>
                        </a>
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                            <span>Reports</span>
                        </a>
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-folder2-open"></i>
                            <span>Documents</span>
                        </a>
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-gear"></i>
                            <span>Settings</span>
                        </a>
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-journal-text"></i>
                            <span>Audit Logs</span>
                        </a>
                    </div>
                </div>

                {{-- Plan card at bottom of sidebar --}}
                <div class="sidebar-plan-card">
                    <div class="text-secondary small mb-1" style="font-size: 0.75rem;">Current Plan</div>
                    <div class="text-white fw-bold mb-1" style="font-size: 0.9rem;">Business</div>
                    <div class="text-muted small mb-3" style="font-size: 0.75rem;">Expires on 31 Dec, 2025</div>
                    <a href="#" class="btn btn-upgrade text-decoration-none">Upgrade Plan</a>
                </div>
            </div>

            {{-- Main area --}}
            <div class="col-md-9 col-lg-10 d-flex flex-column min-vh-100">
                
                {{-- Top Navbar --}}
                <header class="navbar-top">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-link text-secondary p-0 fs-4 text-decoration-none"><i class="bi bi-list"></i></button>
                        <span class="fw-semibold text-secondary small">Module Builder</span>
                    </div>

                    <div class="d-flex align-items-center gap-4">
                        {{-- Tenant --}}
                        <div class="d-flex align-items-center gap-2 border-end pe-4">
                            <span class="text-muted small">Tenant</span>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-building"></i>
                                    <span>Demo Company</span>
                                </button>
                            </div>
                        </div>

                        {{-- Notifications and messages --}}
                        <div class="d-flex align-items-center gap-3">
                            <div class="top-nav-icon">
                                <i class="bi bi-bell"></i>
                                <span class="top-nav-badge">5</span>
                            </div>
                            <div class="top-nav-icon">
                                <i class="bi bi-envelope"></i>
                                <span class="top-nav-badge">3</span>
                            </div>
                        </div>

                        {{-- Avatar drop --}}
                        <div class="d-flex align-items-center gap-2 ps-3 border-start">
                            <img src="https://ui-avatars.com/api/?name=Admin&background=2563eb&color=fff" class="rounded-circle" width="32" height="32">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-link text-decoration-none text-dark dropdown-toggle fw-semibold p-0" type="button" data-bs-toggle="dropdown">
                                    Admin
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <li>
                                        <form action="{{ route('auth.logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-1"></i>Sign Out</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </header>

                {{-- Page Main Content --}}
                <main class="main-content flex-grow-1">
                    @yield('content')
                </main>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
