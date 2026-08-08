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
                    <i class="bi {{ $biIcon }} text-primary"></i> {{ config('settings.project_name', config('app.name', 'SaaSStater')) }}
                </h5>
                <p class="small text-muted mb-4" style="max-width: 380px;">
                    {{ config('settings.project_description', 'A premium multi-tenant SaaS application engine built with Laravel.') }}
                </p>
                <div class="d-flex gap-3 text-muted">
                    <a href="#" class="text-reset hover-cosmic"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-reset hover-cosmic"><i class="bi bi-github"></i></a>
                    <a href="#" class="text-reset hover-cosmic"><i class="bi bi-discord"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-semibold mb-3">Quick Links</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="{{ route('marketing.index') }}" class="text-decoration-none text-muted hover-cosmic">Home</a></li>
                    <li><a href="{{ route('marketing.features') }}" class="text-decoration-none text-muted hover-cosmic">Features</a></li>
                    <li><a href="{{ route('marketing.pricing') }}" class="text-decoration-none text-muted hover-cosmic">Pricing</a></li>
                    <li><a href="{{ route('marketing.contact') }}" class="text-decoration-none text-muted hover-cosmic">Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12">
                <h6 class="fw-semibold mb-3">Portals & Login</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="{{ route('auth.login') }}" class="text-decoration-none text-muted hover-cosmic">User Login</a></li>
                    <li><a href="{{ route('auth.register') }}" class="text-decoration-none text-muted hover-cosmic">Register Tenant</a></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted hover-cosmic text-warning">Admin Console</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-4 opacity-10" style="background-color: #6366f1;">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
            <span class="small text-muted">&copy; {{ date('Y') }} {{ config('settings.project_name', config('app.name', 'SaaSStater')) }}. All rights reserved.</span>
            <span class="small text-muted">Powered by Laravel Modular SaaS Platform</span>
        </div>
    </div>
</footer>

<style>
.hover-cosmic {
    transition: color 0.2s ease, text-shadow 0.2s ease;
}
.hover-cosmic:hover {
    color: #a855f7 !important;
    text-shadow: 0 0 8px rgba(168, 85, 247, 0.5);
}
</style>
