<footer class="py-5 mt-auto border-top">
    <div class="container">
        @php
            $logoIcon = config('settings.project_logo', 'shield');
            $biIcon = match($logoIcon) {
                'shield' => 'bi-shield-check',
                'box' => 'bi-box-seam',
                'cpu' => 'bi-cpu-fill',
                'database' => 'bi-database-fill',
                'globe' => 'bi-globe',
                'heart' => 'bi-heart-fill',
                'key' => 'bi-key-fill',
                'lock' => 'bi-lock-fill',
                'settings' => 'bi-gear-fill',
                'activity' => 'bi-activity',
                'server' => 'bi-server',
                'terminal' => 'bi-terminal-fill',
                default => 'bi-shield-check',
            };
        @endphp
        <div class="row g-4">
            <div class="col-lg-5 col-md-6">
                <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="bi {{ $biIcon }} text-info"></i> {{ config('settings.project_name', config('app.name', 'SaaSStater')) }}
                </h5>
                <p class="small text-muted mb-4" style="max-width: 380px;">
                    {{ config('settings.project_description', 'A high-performance cyber neon SaaS portal.') }}
                </p>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-semibold mb-3 text-info">Grid Routes</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="{{ route('marketing.index') }}" class="text-decoration-none text-muted">Home Node</a></li>
                    <li><a href="{{ route('marketing.features') }}" class="text-decoration-none text-muted">Features Matrix</a></li>
                    <li><a href="{{ route('marketing.pricing') }}" class="text-decoration-none text-muted">Pricing Tiers</a></li>
                    <li><a href="{{ route('marketing.contact') }}" class="text-decoration-none text-muted">Support Relay</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12">
                <h6 class="fw-semibold mb-3 text-info">Authentication</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="{{ route('auth.login') }}" class="text-decoration-none text-muted">Sign In</a></li>
                    <li><a href="{{ route('auth.register') }}" class="text-decoration-none text-muted">Create Account</a></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-info">Admin Panel</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-4 opacity-10" style="background-color: #06b6d4;">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
            <span class="small text-muted">&copy; {{ date('Y') }} {{ config('settings.project_name', config('app.name', 'SaaSStater')) }}. Cybernetics online.</span>
        </div>
    </div>
</footer>
