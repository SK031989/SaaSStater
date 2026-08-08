<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRMS & SaaS Documentation — User Manual & Technical Reference</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --docs-bg: #0b0f19;
            --docs-card-bg: #111827;
            --docs-sidebar-bg: #0f172a;
            --docs-border: rgba(255, 255, 255, 0.08);
            --docs-text: #f8fafc;
            --docs-muted: #94a3b8;
            --docs-accent: #6366f1;
            --docs-code-bg: #030712;
        }

        body.light-mode {
            --docs-bg: #f8fafc;
            --docs-card-bg: #ffffff;
            --docs-sidebar-bg: #ffffff;
            --docs-border: #e2e8f0;
            --docs-text: #0f172a;
            --docs-muted: #64748b;
            --docs-accent: #4f46e5;
            --docs-code-bg: #1e293b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--docs-bg);
            color: var(--docs-text);
            transition: background-color 0.3s, color 0.3s;
        }

        code, pre {
            font-family: 'JetBrains Mono', monospace;
        }

        /* ── Sticky Top Header ─────────────────────────────────────── */
        .docs-header {
            height: 64px;
            background-color: var(--docs-card-bg);
            border-bottom: 1px solid var(--docs-border);
            position: sticky;
            top: 0;
            z-index: 1040;
            backdrop-filter: blur(12px);
        }

        /* ── Sidebar ───────────────────────────────────────────────── */
        .docs-sidebar {
            width: 290px;
            background-color: var(--docs-sidebar-bg);
            border-right: 1px solid var(--docs-border);
            position: fixed;
            top: 64px;
            bottom: 0;
            left: 0;
            overflow-y: auto;
            z-index: 1030;
            padding: 1.5rem 1rem;
            transition: transform 0.3s ease;
        }

        .sidebar-section-title {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--docs-muted);
            margin: 1.25rem 0 0.5rem 0.5rem;
        }

        .docs-nav-link {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.55rem 0.75rem;
            border-radius: 0.6rem;
            color: var(--docs-muted);
            text-decoration: none;
            font-size: 0.83rem;
            font-weight: 500;
            transition: all 0.15s ease;
        }

        .docs-nav-link:hover, .docs-nav-link.active {
            color: var(--docs-text);
            background-color: rgba(99, 102, 241, 0.12);
        }

        .docs-nav-link.active {
            color: #818cf8;
            font-weight: 700;
        }

        /* ── Main Content Area ─────────────────────────────────────── */
        .docs-content {
            margin-left: 290px;
            padding: 2.5rem 3rem;
            min-height: calc(100vh - 64px);
        }

        @media (max-width: 991.98px) {
            .docs-sidebar {
                transform: translateX(-100%);
            }
            .docs-sidebar.show {
                transform: translateX(0);
            }
            .docs-content {
                margin-left: 0;
                padding: 1.5rem 1rem;
            }
        }

        /* ── Card Styling ──────────────────────────────────────────── */
        .docs-card {
            background-color: var(--docs-card-bg);
            border: 1px solid var(--docs-border);
            border-radius: 1rem;
            padding: 1.75rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .code-block {
            background-color: var(--docs-code-bg);
            border: 1px solid var(--docs-border);
            border-radius: 0.75rem;
            padding: 1.25rem;
            color: #38bdf8;
            font-size: 0.82rem;
            overflow-x: auto;
            position: relative;
        }

        .badge-tag {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
        }

        .user-step-box {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--docs-border);
            border-radius: 0.85rem;
            padding: 1.25rem;
            margin-bottom: 1rem;
        }

        .step-number {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #6366f1;
            color: #fff;
            font-weight: 700;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
    </style>
</head>
<body>

    <!-- ── 1. INDEPENDENT HEADER ── -->
    <header class="docs-header d-flex align-items-center px-4 justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <!-- Mobile Toggle -->
            <button class="btn btn-link text-slate-400 d-lg-none p-0" id="sidebarToggle">
                <i class="bi bi-list fs-3"></i>
            </button>

            <!-- Brand -->
            <a href="/" class="d-flex align-items-center gap-2.5 text-decoration-none">
                <div class="p-2 rounded-3 bg-gradient-to-tr from-indigo-600 to-purple-600 shadow-sm" style="background: linear-gradient(135deg, #6366f1, #a855f7);">
                    <i data-lucide="{{ config('settings.project_logo', 'shield') }}" class="w-5 h-5 text-white" style="width:20px; height:20px; color:#fff;"></i>
                </div>
                <div>
                    <span class="fw-bold text-white fs-5 leading-none d-block" style="color:var(--docs-text);">{{ config('settings.project_name', 'SaaSStater') }}</span>
                    <span class="text-xs text-slate-400 font-mono" style="font-size:0.68rem; color:var(--docs-muted);">HRMS Documentation Portal</span>
                </div>
            </a>
        </div>

        <!-- Right Header Actions -->
        <div class="d-flex align-items-center gap-3">
            <!-- Light/Dark Toggle -->
            <button class="btn btn-outline-secondary border-0 text-slate-400 p-2 rounded-circle" id="themeToggle" title="Toggle Theme">
                <i class="bi bi-sun-fill fs-5" id="themeIcon"></i>
            </button>

            @if(auth()->check())
                <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('dashboard') }}" class="btn btn-indigo rounded-pill px-4 btn-sm font-semibold" style="background:#6366f1; color:#fff;">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>
            @else
                <a href="{{ route('auth.login') }}" class="btn btn-indigo rounded-pill px-4 btn-sm font-semibold" style="background:#6366f1; color:#fff;">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                </a>
            @endif
        </div>
    </header>

    <!-- ── 2. INDEPENDENT SIDEBAR ── -->
    <aside class="docs-sidebar" id="docsSidebar">
        <!-- Section 1: User Manual -->
        <div class="sidebar-section-title"><i class="bi bi-book me-1"></i> User Operating Manual</div>
        <nav class="space-y-1">
            <a href="#user-getting-started" class="docs-nav-link active" onclick="activateLink(this)">
                <i class="bi bi-box-arrow-in-right"></i> Getting Started & Login
            </a>
            <a href="#user-locations" class="docs-nav-link" onclick="activateLink(this)">
                <i class="bi bi-geo-alt"></i> Managing Office Locations
            </a>
            <a href="#user-tenant-mgmt" class="docs-nav-link" onclick="activateLink(this)">
                <i class="bi bi-building"></i> Tenants & Client Companies
            </a>
            <a href="#user-staff-roles" class="docs-nav-link" onclick="activateLink(this)">
                <i class="bi bi-people"></i> Staff Users & Role Assignment
            </a>
            <a href="#user-billing-plans" class="docs-nav-link" onclick="activateLink(this)">
                <i class="bi bi-receipt"></i> Subscriptions & Invoices
            </a>
            <a href="#user-checkout" class="docs-nav-link" onclick="activateLink(this)">
                <i class="bi bi-cart-check"></i> Secure Checkout Portal
            </a>
            <a href="#user-settings-themes" class="docs-nav-link" onclick="activateLink(this)">
                <i class="bi bi-palette"></i> Themes & Custom Branding
            </a>
        </nav>

        <!-- Section 2: Technical Specs -->
        <div class="sidebar-section-title"><i class="bi bi-gear me-1"></i> Technical Specs & API</div>
        <nav class="space-y-1">
            <a href="#tech-architecture" class="docs-nav-link" onclick="activateLink(this)">
                <i class="bi bi-diagram-3"></i> System Architecture
            </a>
            <a href="#tech-database-schema" class="docs-nav-link" onclick="activateLink(this)">
                <i class="bi bi-database"></i> Database Schema & Entities
            </a>
            <a href="#tech-rbac-matrix" class="docs-nav-link" onclick="activateLink(this)">
                <i class="bi bi-shield-check"></i> Spatie RBAC Matrix
            </a>
            <a href="#tech-api-sanctum" class="docs-nav-link" onclick="activateLink(this)">
                <i class="bi bi-code-slash"></i> REST API v1 Reference
            </a>
            <a href="#tech-cli-setup" class="docs-nav-link" onclick="activateLink(this)">
                <i class="bi bi-terminal"></i> CLI Setup & Migrations
            </a>
        </nav>

        <!-- Section 3: Module Deep Dive -->
        <div class="sidebar-section-title"><i class="bi bi-boxes me-1"></i> 15 Core Modules</div>
        <nav class="space-y-1">
            <a href="#mod-reference" class="docs-nav-link" onclick="activateLink(this)">
                <i class="bi bi-box-seam"></i> Modules Reference Guide
            </a>
        </nav>
    </aside>

    <!-- ── 3. MAIN DOCUMENTATION CONTENT ── -->
    <main class="docs-content">
        <div class="max-w-5xl mx-auto">

            <!-- ==================================================================================== -->
            <!-- SECTION 1: USER OPERATING MANUAL                                                      -->
            <!-- ==================================================================================== -->

            {{-- GETTING STARTED --}}
            <section id="user-getting-started" class="docs-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3 class="fw-bold mb-0">📖 User Manual: Getting Started & Authentication</h3>
                    <span class="badge badge-tag bg-indigo-500/20 text-indigo-400 border border-indigo-500/30" style="background:rgba(99,102,241,0.15); color:#a5b4fc;">User Guide</span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed mb-4">
                    Learn how to access your HRMS portal, sign in with pre-seeded demo accounts or custom credentials, and navigate your dashboard.
                </p>

                <div class="user-step-box d-flex gap-3">
                    <div class="step-number">1</div>
                    <div>
                        <h6 class="fw-bold mb-1">Access the Login Page</h6>
                        <p class="text-xs text-slate-400 mb-0">Navigate to <code>http://127.0.0.1:8000/login</code> for Tenant Admins and Users, or <code>http://127.0.0.1:8000/admin/login</code> for Super Administrators.</p>
                    </div>
                </div>

                <div class="user-step-box d-flex gap-3">
                    <div class="step-number">2</div>
                    <div>
                        <h6 class="fw-bold mb-1">Use Click-to-Fill Demo Account Cards</h6>
                        <p class="text-xs text-slate-400 mb-0">Click any card on the left panel (e.g. <strong>Super Admin</strong>, <strong>Alpha Tenant Admin</strong>, or <strong>Demo User</strong>) to instantly auto-fill credentials.</p>
                    </div>
                </div>

                <div class="user-step-box d-flex gap-3">
                    <div class="step-number">3</div>
                    <div>
                        <h6 class="fw-bold mb-1">Role-Based Dashboard Redirection</h6>
                        <p class="text-xs text-slate-400 mb-0">Super Admins land on <code>/admin/dashboard</code> with full platform operations. Tenant Admins and Staff Users land on <code>/dashboard</code>.</p>
                    </div>
                </div>
            </section>

            {{-- MANAGING OFFICE LOCATIONS --}}
            <section id="user-locations" class="docs-card">
                <h3 class="fw-bold mb-3">🏢 User Manual: Managing Office Locations & Regional Hubs</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-4">
                    The <strong>Location Module</strong> allows organizations to track physical headquarters, regional offices, warehouse fulfillment centers, and work hubs.
                </p>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.03); border:1px solid var(--docs-border);">
                            <h6 class="fw-bold text-white mb-1"><i class="bi bi-plus-circle text-primary me-1"></i> Creating a Location</h6>
                            <p class="text-xs text-slate-400 mb-0">Go to <strong>Locations -> Add Location</strong>. Enter location name, city, country, street address, and contact email/phone. Toggle <em>"Set as Primary Location"</em> if this is your company HQ.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.03); border:1px solid var(--docs-border);">
                            <h6 class="fw-bold text-white mb-1"><i class="bi bi-three-dots-vertical text-warning me-1"></i> Actions & Details View</h6>
                            <p class="text-xs text-slate-400 mb-0">Click the 3-dot dropdown menu on any location row to <strong>View Details</strong>, <strong>Edit Address</strong>, or <strong>Delete Location</strong>.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- TENANTS & CLIENT COMPANIES --}}
            <section id="user-tenant-mgmt" class="docs-card">
                <h3 class="fw-bold mb-3">🏢 User Manual: Multi-Tenant & Client Company Onboarding</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-4">
                    Super Administrators can onboard new client tenant companies, assign custom subdomains (e.g. <code>alpha.saas.local</code>), and link subscription plans.
                </p>
                <div class="user-step-box d-flex gap-3">
                    <div class="step-number"><i class="bi bi-building"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Onboarding a New Tenant</h6>
                        <p class="text-xs text-slate-400 mb-0">Go to <strong>Tenants -> Add Tenant</strong>. Provide company name, unique subdomain, contact email, and assign a Subscription Plan (Free Starter, Growth Pro, or Enterprise Scale).</p>
                    </div>
                </div>
            </section>

            {{-- STAFF USERS & ROLES --}}
            <section id="user-staff-roles" class="docs-card">
                <h3 class="fw-bold mb-3">👥 User Manual: Staff User Management & Spatie Roles</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-4">
                    Manage system users, assign Spatie roles (Super Admin, Tenant Admin, User), and update account statuses.
                </p>
                <div class="table-responsive">
                    <table class="table table-dark table-hover text-xs mb-0">
                        <thead>
                            <tr style="color:#94a3b8;">
                                <th>Role</th>
                                <th>Default Target</th>
                                <th>Permissions Scope</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold text-danger">Super Admin</td>
                                <td>Platform HQ Team</td>
                                <td>Full access to all tenants, global billing, plans, and dynamic module builder.</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-indigo-400" style="color:#a5b4fc;">Tenant Admin</td>
                                <td>Company HR Managers</td>
                                <td>Full administrative access within their assigned tenant organization.</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-success">User / Employee</td>
                                <td>Company Employees</td>
                                <td>Access to personal profile, support tickets, and assigned office location details.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- SUBSCRIPTIONS & BILLING --}}
            <section id="user-billing-plans" class="docs-card">
                <h3 class="fw-bold mb-3">💳 User Manual: Subscriptions, Entitlements & Billing</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-4">
                    Monitor tenant subscription tiers, enforce maximum user limits, and issue invoices.
                </p>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 border border-slate-700 bg-slate-900">
                            <h6 class="fw-bold text-white mb-1">Free Starter</h6>
                            <div class="fs-4 font-bold text-indigo-400 mb-1">$0 <span class="fs-6 text-slate-500">/mo</span></div>
                            <div class="text-xs text-slate-400 mb-0">Max 3 users • 1 Location</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 border border-indigo-500/50 bg-indigo-500/10">
                            <h6 class="fw-bold text-white mb-1">Growth Pro <span class="badge bg-indigo-500 text-xs">Popular</span></h6>
                            <div class="fs-4 font-bold text-indigo-400 mb-1">$29 <span class="fs-6 text-slate-500">/mo</span></div>
                            <div class="text-xs text-slate-400 mb-0">Max 25 users • Unlimited Locations</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 border border-purple-500/50 bg-purple-500/10">
                            <h6 class="fw-bold text-white mb-1">Enterprise Scale</h6>
                            <div class="fs-4 font-bold text-purple-400 mb-1">$99 <span class="fs-6 text-slate-500">/mo</span></div>
                            <div class="text-xs text-slate-400 mb-0">Max 500 users • Dedicated Priority SLA</div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- SECURE CHECKOUT PORTAL --}}
            <section id="user-checkout" class="docs-card">
                <h3 class="fw-bold mb-3">🛒 User Manual: Secure Checkout & Payment Processing</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-3">
                    Access <code class="text-indigo-400">/checkout</code> to complete plan subscriptions, apply promotional discount coupons (e.g. <code>SAVE20</code>, <code>SAAS50</code>), and process instant payments via active gateway channels.
                </p>
                <div class="user-step-box d-flex gap-3">
                    <div class="step-number"><i class="bi bi-cart-check"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Unified Order Summary & Automatic Invoice Generation</h6>
                        <p class="text-xs text-slate-400 mb-0">Completing checkout creates a paid <strong>Invoice (#INV-xxx)</strong> in the Billing module, records an audit log entry in <strong>Payment Transactions (#TXN-xxx)</strong>, and automatically upgrades your company's tenant subscription plan.</p>
                    </div>
                </div>
            </section>

            {{-- THEMES & CUSTOM BRANDING --}}
            <section id="user-settings-themes" class="docs-card">
                <h3 class="fw-bold mb-3">🎨 User Manual: Theme Customization & Accent Color Palettes</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-3">
                    Customize your portal look and feel directly from <strong>Configuration -> General Settings</strong> or using the Topbar Palette Selector button.
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="badge bg-purple-600 px-3 py-2">Obsidian Dark</span>
                    <span class="badge bg-cyan-600 px-3 py-2">Cyber Pulse</span>
                    <span class="badge bg-indigo-600 px-3 py-2">Astral Glass</span>
                    <span class="badge bg-slate-600 px-3 py-2">Minimal Clean</span>
                </div>
            </section>


            <!-- ==================================================================================== -->
            <!-- SECTION 2: TECHNICAL SPECS & ARCHITECTURE                                            -->
            <!-- ==================================================================================== -->

            {{-- TECHNICAL ARCHITECTURE --}}
            <section id="tech-architecture" class="docs-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3 class="fw-bold mb-0">⚙️ Technical Specs: Architecture & Routing</h3>
                    <span class="badge badge-tag bg-emerald-500/20 text-emerald-400 border border-emerald-500/30" style="background:rgba(16,185,129,0.15); color:#6ee7b7;">Developer Specs</span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed mb-4">
                    SaaSStater routes requests through custom middleware pipelines to guarantee multi-tenant data isolation and role verification.
                </p>

                <h6 class="fw-bold mb-2 text-white">Core Middleware Stack</h6>
                <ul class="text-xs text-slate-300 space-y-1 mb-4">
                    <li><code>Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin</code> — Restricts <code>/admin/*</code> operations exclusively to Super Admins.</li>
                    <li><code>Modules\Tenant\App\Http\Middleware\TenantResolverMiddleware</code> — Resolves tenant identity from subdomains (e.g. <code>alpha.saas.local</code>).</li>
                </ul>
            </section>

            {{-- DATABASE SCHEMA --}}
            <section id="tech-database-schema" class="docs-card">
                <h3 class="fw-bold mb-3">🗄️ Technical Specs: Database Schema & Entity Relations</h3>
                <div class="table-responsive">
                    <table class="table table-dark table-hover text-xs mb-0 font-mono">
                        <thead>
                            <tr style="color:#94a3b8;">
                                <th>Table Name</th>
                                <th>Key Columns</th>
                                <th>Foreign Key References</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-info fw-bold">tenants</td>
                                <td>id, name, subdomain, plan_id, status</td>
                                <td><code>plan_id</code> -> subscription_plans.id</td>
                            </tr>
                            <tr>
                                <td class="text-info fw-bold">locations</td>
                                <td>id, tenant_id, name, city, country, address_line_1, is_primary</td>
                                <td><code>tenant_id</code> -> tenants.id</td>
                            </tr>
                            <tr>
                                <td class="text-info fw-bold">users</td>
                                <td>id, tenant_id, name, email, password, is_admin, status</td>
                                <td><code>tenant_id</code> -> tenants.id</td>
                            </tr>
                            <tr>
                                <td class="text-info fw-bold">billings</td>
                                <td>id, tenant_id, plan_id, amount, status, invoice_number</td>
                                <td><code>tenant_id</code> -> tenants.id, <code>plan_id</code> -> subscription_plans.id</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- RBAC MATRIX --}}
            <section id="tech-rbac-matrix" class="docs-card">
                <h3 class="fw-bold mb-3">🔐 Technical Specs: Spatie RBAC Permissions Matrix</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-3">
                    Permissions are dynamically seeded across 13 core modules: <code>tenants</code>, <code>subscriptions</code>, <code>entitlements</code>, <code>billings</code>, <code>addons</code>, <code>coupons</code>, <code>rolepermissions</code>, <code>notifications</code>, <code>apikeys</code>, <code>tickets</code>, <code>users</code>, <code>products</code>, and <code>locations</code>.
                </p>
                <div class="code-block">
                    <pre class="mb-0" style="color:#38bdf8;">
// Spatie Permission Naming Pattern
{module}.view   e.g. locations.view, tenants.view
{module}.create e.g. locations.create, tenants.create
{module}.edit   e.g. locations.edit, tenants.edit
{module}.delete e.g. locations.delete, tenants.delete
                    </pre>
                </div>
            </section>

            {{-- SANCTUM REST API --}}
            <section id="tech-api-sanctum" class="docs-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3 class="fw-bold mb-0">🔌 Sanctum REST API v1 Reference (Module-Wise)</h3>
                    <span class="badge badge-tag bg-cyan-500/20 text-cyan-400 border border-cyan-500/30" style="background:rgba(6,182,212,0.15); color:#22d3ee;">Sanctum Token Auth</span>
                </div>
                <p class="text-slate-400 text-xs mb-4">All API requests must include header: <code class="text-indigo-300">Authorization: Bearer &lt;sanctum_token&gt;</code> and <code class="text-indigo-300">Accept: application/json</code>.</p>

                <div class="table-responsive">
                    <table class="table table-dark table-hover text-xs mb-0 font-mono">
                        <thead>
                            <tr style="color:#94a3b8;">
                                <th>Module</th>
                                <th>Method</th>
                                <th>Endpoint</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Auth -->
                            <tr>
                                <td class="fw-bold text-indigo-400">Auth</td>
                                <td><span class="badge bg-primary">POST</span></td>
                                <td class="fw-bold text-white">/api/v1/auth/login</td>
                                <td>Authenticate user & generate Sanctum bearer token</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-indigo-400">Auth</td>
                                <td><span class="badge bg-danger">POST</span></td>
                                <td class="fw-bold text-white">/api/v1/auth/logout</td>
                                <td>Revoke active token & logout user</td>
                            </tr>

                            <!-- Location -->
                            <tr>
                                <td class="fw-bold text-emerald-400">Location</td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td class="fw-bold text-white">/api/v1/locations</td>
                                <td>List office locations (paginated & filtered)</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-emerald-400">Location</td>
                                <td><span class="badge bg-primary">POST</span></td>
                                <td class="fw-bold text-white">/api/v1/locations</td>
                                <td>Create a new office location hub</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-emerald-400">Location</td>
                                <td><span class="badge bg-info text-dark">GET</span></td>
                                <td class="fw-bold text-white">/api/v1/locations/{id}</td>
                                <td>Get specific office location details</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-emerald-400">Location</td>
                                <td><span class="badge bg-warning text-dark">PUT</span></td>
                                <td class="fw-bold text-white">/api/v1/locations/{id}</td>
                                <td>Update location address & details</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-emerald-400">Location</td>
                                <td><span class="badge bg-danger">DELETE</span></td>
                                <td class="fw-bold text-white">/api/v1/locations/{id}</td>
                                <td>Soft delete office location</td>
                            </tr>

                            <!-- Payment -->
                            <tr>
                                <td class="fw-bold text-purple-400">Payment</td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td class="fw-bold text-white">/api/v1/payments/gateways</td>
                                <td>List active payment gateways (Stripe, PayPal, Bank)</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-purple-400">Payment</td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td class="fw-bold text-white">/api/v1/payments/transactions</td>
                                <td>List payment transaction logs & audit trail</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-purple-400">Payment</td>
                                <td><span class="badge bg-primary">POST</span></td>
                                <td class="fw-bold text-white">/api/v1/payments/transactions</td>
                                <td>Create/record payment transaction</td>
                            </tr>

                            <!-- Tenant -->
                            <tr>
                                <td class="fw-bold text-blue-400">Tenant</td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td class="fw-bold text-white">/api/v1/tenants</td>
                                <td>List client tenant companies (Super Admin)</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-blue-400">Tenant</td>
                                <td><span class="badge bg-primary">POST</span></td>
                                <td class="fw-bold text-white">/api/v1/tenants</td>
                                <td>Onboard new client tenant organization</td>
                            </tr>

                            <!-- Subscription -->
                            <tr>
                                <td class="fw-bold text-amber-400">Subscription</td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td class="fw-bold text-white">/api/v1/subscriptions</td>
                                <td>List available pricing plans & limits</td>
                            </tr>

                            <!-- Entitlement -->
                            <tr>
                                <td class="fw-bold text-pink-400">Entitlement</td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td class="fw-bold text-white">/api/v1/entitlements</td>
                                <td>List feature flags & limits for tenant plan</td>
                            </tr>

                            <!-- Billing -->
                            <tr>
                                <td class="fw-bold text-cyan-400">Billing</td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td class="fw-bold text-white">/api/v1/billings</td>
                                <td>List tenant invoices & payment history</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-cyan-400">Billing</td>
                                <td><span class="badge bg-info text-dark">GET</span></td>
                                <td class="fw-bold text-white">/api/v1/billings/{id}/pdf</td>
                                <td>Download invoice receipt PDF</td>
                            </tr>

                            <!-- Addons & Coupons -->
                            <tr>
                                <td class="fw-bold text-rose-400">Addons</td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td class="fw-bold text-white">/api/v1/addons</td>
                                <td>List modular HR add-ons (Payroll, Attendance)</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-teal-400">Coupons</td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td class="fw-bold text-white">/api/v1/coupons</td>
                                <td>List active promotional coupons & vouchers</td>
                            </tr>

                            <!-- Notification & ApiKey -->
                            <tr>
                                <td class="fw-bold text-sky-400">Notification</td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td class="fw-bold text-white">/api/v1/notifications</td>
                                <td>List user notifications & system logs</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-violet-400">ApiKey</td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td class="fw-bold text-white">/api/v1/apikeys</td>
                                <td>List active API integration tokens</td>
                            </tr>

                            <!-- Support -->
                            <tr>
                                <td class="fw-bold text-orange-400">Support</td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td class="fw-bold text-white">/api/v1/tickets</td>
                                <td>List employee HR support tickets</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-orange-400">Support</td>
                                <td><span class="badge bg-primary">POST</span></td>
                                <td class="fw-bold text-white">/api/v1/tickets</td>
                                <td>Submit a new HR support ticket</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- CLI SETUP --}}
            <section id="tech-cli-setup" class="docs-card">
                <h3 class="fw-bold mb-3">🚀 Technical Specs: CLI Setup & Maintenance Commands</h3>
                <div class="code-block">
                    <pre class="mb-0" style="color:#38bdf8;">
# Enable Location Module
php artisan module:enable Location

# Clear Compiled Cache
php artisan optimize:clear

# Migrate & Seed All Modules
php artisan migrate:fresh --seed

# Start Local Dev Server
php artisan serve
                    </pre>
                </div>
            </section>


            <!-- ==================================================================================== -->
            <!-- SECTION 3: 15 CORE MODULES REFERENCE                                                 -->
            <!-- ==================================================================================== -->

            <section id="mod-reference" class="docs-card">
                <h3 class="fw-bold mb-4">🧩 15 Decoupled Core Modules Detailed Reference</h3>
                <div class="row g-3">
                    @php
                        $deepModules = [
                            ['name' => 'Auth', 'path' => 'Modules/Auth', 'desc' => 'Handles authentication, login controllers, password resets, verification, and audit logs.', 'model' => 'User, LoginActivity'],
                            ['name' => 'Tenant', 'path' => 'Modules/Tenant', 'desc' => 'Manages client tenants, custom subdomains, domain mapping, and tenant onboarding.', 'model' => 'Tenant, Domain'],
                            ['name' => 'Location', 'path' => 'Modules/Location', 'desc' => 'Manages physical office locations, regional branches, warehouse hubs, and contact details.', 'model' => 'Location'],
                            ['name' => 'Subscription', 'path' => 'Modules/Subscription', 'desc' => 'Subscription pricing plans, pricing rules, billing intervals, and max user limits.', 'model' => 'SubscriptionPlan'],
                            ['name' => 'Entitlement', 'path' => 'Modules/Entitlement', 'desc' => 'Feature flags and entitlement limits allocated per tenant subscription tier.', 'model' => 'Entitlement'],
                            ['name' => 'Billing', 'path' => 'Modules/Billing', 'desc' => 'Generates PDF invoices, tracks billing transactions, and processes payments.', 'model' => 'Billing'],
                            ['name' => 'Addons', 'path' => 'Modules/Addons', 'desc' => 'Modular HR add-on extensions (Payroll, Time Tracking, Performance Reviews).', 'model' => 'Addon'],
                            ['name' => 'Coupons', 'path' => 'Modules/Coupons', 'desc' => 'Promotional voucher codes, percentage/fixed pricing discounts.', 'model' => 'Coupon'],
                            ['name' => 'RolePermission', 'path' => 'Modules/RolePermission', 'desc' => 'Spatie RBAC role management, permission assignment, and security guards.', 'model' => 'Role, Permission'],
                            ['name' => 'Notification', 'path' => 'Modules/Notification', 'desc' => 'Multi-channel notifications, activity logs, and email template manager.', 'model' => 'Notification, NotificationTemplate'],
                            ['name' => 'ApiKey', 'path' => 'Modules/ApiKey', 'desc' => 'Sanctum API tokens management for mobile apps and third-party integrations.', 'model' => 'ApiKey'],
                            ['name' => 'Support', 'path' => 'Modules/Support', 'desc' => 'Internal HR helpdesk, support tickets, categories, and SLA tracking.', 'model' => 'Ticket, TicketMessage'],
                            ['name' => 'ModuleBuilder', 'path' => 'Modules/ModuleBuilder', 'desc' => 'Dynamic CRUD generator engine for scaffolding new HR entities on the fly.', 'model' => 'DynamicModule, DynamicField'],
                            ['name' => 'Payment', 'path' => 'Modules/Payment', 'desc' => 'Multi-gateway configurations (Stripe, PayPal, Razorpay, Bank Wire), sandbox modes, and payment audit logs.', 'model' => 'PaymentGateway, PaymentTransaction'],
                            ['name' => 'Product', 'path' => 'Modules/Product', 'desc' => 'Product catalog, digital assets, services, and product entitlements.', 'model' => 'Product'],
                            ['name' => 'Dashboard', 'path' => 'Modules/Dashboard', 'desc' => 'Central control panel with KPI cards, revenue charts, and theme customizer.', 'model' => 'DashboardController'],
                        ];
                    @endphp

                    @foreach($deepModules as $dm)
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 h-100" style="background:rgba(255,255,255,0.03); border:1px solid var(--docs-border);">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-white fs-6">Modules/{{ $dm['name'] }}</span>
                                <span class="badge bg-indigo-500/20 text-indigo-400 text-xs font-mono" style="background:rgba(99,102,241,0.15); color:#a5b4fc;">{{ $dm['model'] }}</span>
                            </div>
                            <div class="text-xs text-slate-400 leading-relaxed mb-2">{{ $dm['desc'] }}</div>
                            <div class="text-xs text-slate-500 font-mono">Directory: <code>{{ $dm['path'] }}</code></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();

        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('light-mode');
            if (document.body.classList.contains('light-mode')) {
                themeIcon.className = 'bi bi-moon-stars-fill fs-5';
            } else {
                themeIcon.className = 'bi bi-sun-fill fs-5';
            }
        });

        // Mobile Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const docsSidebar = document.getElementById('docsSidebar');
        sidebarToggle.addEventListener('click', () => {
            docsSidebar.classList.toggle('show');
        });

        // Sidebar link highlight
        function activateLink(element) {
            document.querySelectorAll('.docs-nav-link').forEach(el => el.classList.remove('active'));
            element.classList.add('active');
            if (window.innerWidth < 992) {
                docsSidebar.classList.remove('show');
            }
        }
    </script>
</body>
</html>
