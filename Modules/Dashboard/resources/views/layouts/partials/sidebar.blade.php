{{-- ============================================ --}}
{{-- SIDEBAR PARTIAL                              --}}
{{-- Include in layout: @include('dashboard::layouts.partials.sidebar') --}}
{{-- ============================================ --}}

<!-- Fixed Left Sidebar -->
<aside id="sidebar" class="sidebar-transition fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-slate-200 text-slate-700 flex flex-col -translate-x-full md:translate-x-0">

    <!-- Brand logo area -->
    <div class="logo-container h-16 flex items-center justify-between px-6 border-b border-slate-200 dark:border-slate-800/60 shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 no-underline">
            <div class="p-2 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-600 shadow-md">
                <i data-lucide="shield" class="w-5 h-5 text-white"></i>
            </div>
            <span class="logo-full-text font-bold text-lg tracking-tight text-slate-900 dark:text-white">SaaSStater</span>
        </a>
    </div>

    <!-- Navigation List -->
    <nav class="flex-grow px-4 py-6 space-y-7 overflow-y-auto shrink min-h-0">
        <div class="space-y-1">
            <div class="sidebar-menu-category px-3 mb-2">
                <span class="sidebar-menu-category-text text-xs font-semibold tracking-wider text-slate-400 dark:text-slate-500 uppercase">Core Dashboard</span>
            </div>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300 {{ request()->routeIs('admin.dashboard') ? 'active-menu-item !text-white' : '' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">Dashboard</span>
            </a>

            <!-- Analytics -->
            <a href="#" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300">
                <i data-lucide="bar-chart-3" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">Analytics</span>
            </a>
        </div>

        <div class="space-y-1">
            <div class="sidebar-menu-category px-3 mb-2">
                <span class="sidebar-menu-category-text text-xs font-semibold tracking-wider text-slate-400 dark:text-slate-500 uppercase">Management</span>
            </div>

            <!-- Users -->
            <a href="#" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300">
                <i data-lucide="users" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">Users</span>
            </a>

            <!-- Projects -->
            <a href="#" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300">
                <i data-lucide="folder-kanban" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">Projects</span>
            </a>

            <!-- Tasks -->
            <a href="#" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300">
                <i data-lucide="check-square" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">Tasks</span>
            </a>

            <!-- Orders -->
            <a href="#" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300">
                <i data-lucide="shopping-cart" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">Orders</span>
            </a>

            <!-- Products -->
            <a href="#" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300">
                <i data-lucide="package" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">Products</span>
            </a>
        </div>

        <div class="space-y-1">
            <div class="sidebar-menu-category px-3 mb-2">
                <span class="sidebar-menu-category-text text-xs font-semibold tracking-wider text-slate-400 dark:text-slate-500 uppercase">System</span>
            </div>

            <!-- Module Builder -->
            <a href="{{ route('module-builder.index') }}" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300 {{ request()->routeIs('module-builder.*') ? 'active-menu-item !text-white' : '' }}">
                <i data-lucide="cpu" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">Module Builder</span>
            </a>

            <!-- Reports -->
            <a href="#" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300">
                <i data-lucide="trending-up" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">Reports</span>
            </a>

            <!-- Settings -->
            <a href="#" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300">
                <i data-lucide="settings" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">Settings</span>
            </a>

            <!-- My Profile -->
            <a href="{{ route('auth.profile.edit') }}" class="nav-link-item sidebar-nav-hover flex items-center gap-3 px-3 py-2.5 rounded-xl no-underline font-medium text-sm transition-all duration-150 text-slate-700 dark:text-slate-300 {{ request()->routeIs('auth.profile.edit') ? 'active-menu-item !text-white' : '' }}">
                <i data-lucide="user" class="w-5 h-5 shrink-0"></i>
                <span class="nav-label-text">My Profile</span>
            </a>
        </div>
    </nav>

    <!-- Sidebar Bottom: User Profile Area -->
    <div class="border-t border-slate-200 dark:border-slate-800 shrink-0">
        <div class="relative">
            <button id="sidebar-profile-btn" class="profile-wrapper w-full h-16 flex items-center justify-between px-6 hover:bg-slate-100 dark:hover:bg-slate-800/40 transition text-left">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Administrator') }}&background=6366f1&color=fff" alt="Avatar" class="w-9 h-9 rounded-xl shadow-inner border border-slate-200 dark:border-slate-700">
                    <div class="profile-details">
                        <div class="text-sm font-semibold text-slate-900 dark:text-white truncate max-w-[120px]">{{ auth()->user()->name ?? 'Administrator' }}</div>
                        <div class="text-xs text-slate-500 dark:text-slate-500 font-medium truncate max-w-[120px]">{{ auth()->user()->is_admin ? 'Administrator' : 'User' }}</div>
                    </div>
                </div>
                <i data-lucide="chevron-up" class="profile-chevron w-4 h-4 text-slate-400"></i>
            </button>

            <!-- Sidebar Profile Dropdown -->
            <div id="sidebar-profile-dropdown" class="dropdown-animate hidden-dropdown absolute bottom-full left-0 right-0 z-50 mb-2 bg-white dark:bg-[#0f172a] border border-slate-200 dark:border-slate-800 rounded-2xl shadow-2xl p-2 space-y-1">
                <a href="{{ route('auth.profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg no-underline transition animate-none">
                    <i data-lucide="user" class="w-4 h-4"></i>
                    <span>My Profile</span>
                </a>
                <a href="{{ route('auth.profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg no-underline transition">
                    <i data-lucide="settings" class="w-4 h-4"></i>
                    <span>Account Settings</span>
                </a>
                <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg no-underline transition">
                    <i data-lucide="sliders" class="w-4 h-4"></i>
                    <span>Preferences</span>
                </a>
                <hr class="border-slate-200 dark:border-slate-800 my-1">
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition text-left">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

</aside>
