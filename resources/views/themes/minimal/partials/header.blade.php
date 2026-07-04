<nav class="navbar navbar-expand-lg navbar-mkt sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4 d-flex align-items-center gap-2" href="{{ route('marketing.index') }}">
            <i class="bi bi-sun-fill text-warning"></i>
            <span>Minimalist</span>
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
                    <button id="mode-toggle-btn" class="btn btn-sm btn-mkt-outline p-2 d-flex align-items-center justify-content-center" type="button" onclick="toggleMode()" title="Toggle Mode" style="min-width: 38px; min-height: 38px;">
                        <i class="bi bi-sun-fill sun-icon d-none text-warning"></i>
                        <i class="bi bi-moon-stars-fill moon-icon d-none text-primary"></i>
                    </button>
                </li>
                <li class="nav-item ms-lg-2"><a href="{{ route('auth.login') }}" class="nav-link nav-link-mkt">Log In</a></li>
                <li class="nav-item"><a href="{{ route('auth.register') }}" class="btn btn-sm btn-mkt-primary">Register</a></li>
            </ul>
        </div>
    </div>
</nav>
