<nav class="navbar navbar-expand-lg navbar-dark navbar-mkt sticky-top py-3">
    <div class="container">
        @php
            $logoIcon = config('settings.project_logo', 'shield');
            $logoImage = config('settings.project_logo_image', null);
            $biIcon = match($logoIcon) {
                'shield' => 'bi-shield-check',
                'box' => 'bi-box-seam',
                'shopping-cart' => 'bi-cart-check-fill',
                'store' => 'bi-shop',
                'package' => 'bi-box-seam-fill',
                'layers' => 'bi-layers-fill',
                'truck' => 'bi-truck',
                'award' => 'bi-award-fill',
                'bar-chart-2' => 'bi-bar-chart-fill',
                'rocket' => 'bi-rocket-takeoff-fill',
                'zap' => 'bi-lightning-charge-fill',
                'cpu' => 'bi-cpu-fill',
                'database' => 'bi-database-fill',
                'globe' => 'bi-globe',
                'heart' => 'bi-heart-fill',
                'key' => 'bi-key-fill',
                'lock' => 'bi-lock-fill',
                'settings' => 'bi-gear-fill',
                'user' => 'bi-person-fill',
                'activity' => 'bi-activity',
                'briefcase' => 'bi-briefcase-fill',
                'calendar' => 'bi-calendar-event',
                'compass' => 'bi-compass',
                'feather' => 'bi-feather',
                'server' => 'bi-server',
                'terminal' => 'bi-terminal-fill',
                'wind' => 'bi-wind',
                default => 'bi-shield-check',
            };
        @endphp
        <a class="navbar-brand fw-bold fs-4 d-flex align-items-center gap-2" href="{{ route('marketing.index') }}">
            @if(!empty($logoImage))
                <img src="{{ asset($logoImage) }}" alt="{{ config('settings.project_name', 'SaaSStater') }}" style="height: 32px; width: auto; object-fit: contain;">
            @else
                <i class="bi {{ $biIcon }} text-info"></i>
            @endif
            <span>{{ config('settings.project_name', config('app.name', 'SaaSStater')) }}</span>
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mktNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="mktNavbar">
            <ul class="navbar-nav ms-auto gap-2 mb-2 mb-lg-0 align-items-center">
                <li class="nav-item"><a class="nav-link nav-link-mkt {{ request()->routeIs('marketing.index') ? 'active' : '' }}" href="{{ route('marketing.index') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link nav-link-mkt {{ request()->routeIs('marketing.features') ? 'active' : '' }}" href="{{ route('marketing.features') }}">Features</a></li>
                <li class="nav-item"><a class="nav-link nav-link-mkt {{ request()->routeIs('marketing.pricing') ? 'active' : '' }}" href="{{ route('marketing.pricing') }}">Pricing</a></li>
                <li class="nav-item"><a class="nav-link nav-link-mkt {{ request()->routeIs('marketing.contact') ? 'active' : '' }}" href="{{ route('marketing.contact') }}">Contact</a></li>
                
                <li class="nav-item ms-lg-2">
                    <button id="mode-toggle-btn" class="btn btn-sm btn-mkt-outline p-2 d-flex align-items-center justify-content-center" type="button" onclick="toggleMode()" title="Toggle Mode" style="min-width: 38px; min-height: 38px; border-radius: 0;">
                        <i class="bi bi-sun-fill sun-icon d-none text-warning"></i>
                        <i class="bi bi-moon-stars-fill moon-icon d-none text-info"></i>
                    </button>
                </li>
                @auth
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle nav-link-mkt d-flex align-items-center gap-2" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="rounded-circle" style="width: 28px; height: 28px; object-fit: cover;">
                            <span>{{ auth()->user()->first_name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow py-2" aria-labelledby="navbarUserDropdown" style="border-radius: 0.75rem;">
                            <li>
                                <a class="dropdown-item py-2" href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('auth.profile.edit') }}">
                                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ auth()->user()->is_admin ? route('admin.profile.edit') : route('auth.profile.edit') }}">
                                    <i class="bi bi-person me-2"></i> My Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider opacity-25"></li>
                            <li>
                                <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2 w-100 text-start bg-transparent border-0">
                                        <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item ms-lg-2"><a href="{{ route('auth.login') }}" class="btn btn-sm btn-mkt-primary px-4">Log In</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
