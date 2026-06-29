<nav class="navbar navbar-expand-lg navbar-dark navbar-mkt sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4 text-white d-flex align-items-center gap-2" href="{{ route('marketing.index') }}">
            <i class="bi bi-moon-stars-fill text-primary"></i>
            <span>{{ config('app.name') }}</span>
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
                
                <li class="nav-item dropdown ms-lg-2">
                    <button class="btn btn-sm btn-mkt-outline dropdown-toggle py-2 px-3 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-moon-stars-fill text-primary"></i>
                        <span>Obsidian Dark</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="background: #111827; border: 1px solid rgba(255, 255, 255, 0.08);">
                        @foreach(config('marketing.themes') as $key => $t)
                            <li>
                                <form action="{{ route('marketing.theme.set') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="theme" value="{{ $key }}">
                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2 text-white">
                                        <i class="{{ $t['icon'] }} text-primary"></i>
                                        <span>{{ $t['name'] }}</span>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item ms-lg-2"><a href="{{ route('auth.login') }}" class="nav-link nav-link-mkt">Log In</a></li>
                <li class="nav-item"><a href="{{ route('auth.register') }}" class="btn btn-sm btn-mkt-primary">Register</a></li>
            </ul>
        </div>
    </div>
</nav>
