@extends('auth-module::layouts.auth')

@section('title', 'Sign In')

{{-- ── Left Panel Credential Cards ── --}}
@section('left-bottom')
<p style="font-size:.66rem; font-weight:600; color:#475569; text-transform:uppercase; letter-spacing:.06em; margin: .85rem 0 .5rem;">
    <i class="bi bi-cursor me-1"></i> Demo Accounts — click to fill
</p>

{{-- Super Admin --}}
<div class="cred-card" onclick="fillCredentials('admin@saas.local','AdminPass123!')"
     style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3);">
    <div class="cred-card-label" style="color:#f87171; display:flex; align-items:center;">
        <i class="bi bi-shield-fill-check me-1"></i>Super Admin
        <span class="cred-fill-hint">click to fill</span>
    </div>
    <div class="cred-card-row"><i class="bi bi-envelope" style="color:#475569;"></i><code style="color:#93c5fd;">admin@saas.local</code></div>
    <div class="cred-card-row"><i class="bi bi-lock" style="color:#475569;"></i><code style="color:#86efac;">AdminPass123!</code></div>
</div>

{{-- Tenant Admin --}}
<div class="cred-card" onclick="fillCredentials('tenant1@saas.local','TenantPass123!')"
     style="background:rgba(99,102,241,0.1); border:1px solid rgba(99,102,241,0.3);">
    <div class="cred-card-label" style="color:#a5b4fc; display:flex; align-items:center;">
        <i class="bi bi-building me-1"></i>Alpha Tenant Admin
        <span class="cred-fill-hint">click to fill</span>
    </div>
    <div class="cred-card-row"><i class="bi bi-envelope" style="color:#475569;"></i><code style="color:#93c5fd;">tenant1@saas.local</code></div>
    <div class="cred-card-row"><i class="bi bi-lock" style="color:#475569;"></i><code style="color:#86efac;">TenantPass123!</code></div>
</div>

{{-- Demo User --}}
<div class="cred-card" onclick="fillCredentials('user@saas.local','UserPass123!')"
     style="background:rgba(16,185,129,0.08); border:1px solid rgba(16,185,129,0.28);">
    <div class="cred-card-label" style="color:#6ee7b7; display:flex; align-items:center;">
        <i class="bi bi-person-circle me-1"></i>Demo User
        <span class="cred-fill-hint">click to fill</span>
    </div>
    <div class="cred-card-row"><i class="bi bi-envelope" style="color:#475569;"></i><code style="color:#93c5fd;">user@saas.local</code></div>
    <div class="cred-card-row"><i class="bi bi-lock" style="color:#475569;"></i><code style="color:#86efac;">UserPass123!</code></div>
</div>
@endsection

@section('content')

{{-- Header --}}
<h5 class="fw-bold mb-1">Welcome Back</h5>
<p class="text-muted mb-3" style="font-size:.8rem;">Enter your credentials to access your account.</p>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success small py-2 mb-3">
        <i class="bi bi-check-circle-fill me-1"></i>{{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger small py-2 mb-3">
        <i class="bi bi-exclamation-triangle-fill me-1"></i>{{ session('error') }}
    </div>
@endif

{{-- Login Form --}}
<form action="{{ route('auth.login.store') }}" method="POST" id="userLoginForm">
    @csrf

    {{-- Email --}}
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text" style="border-radius:.65rem 0 0 .65rem; border-right:none;">
                <i class="bi bi-envelope"></i>
            </span>
            <input type="email" name="email" id="email"
                   class="form-control border-start-0 @error('email') is-invalid @enderror"
                   value="{{ old('email') }}"
                   placeholder="you@company.com"
                   required autofocus
                   style="border-radius:0 .65rem .65rem 0;">
        </div>
        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>

    {{-- Password --}}
    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <label for="password" class="form-label mb-0">Password</label>
            <a href="{{ route('auth.password.request') }}" style="font-size:.76rem;">Forgot?</a>
        </div>
        <div class="input-group">
            <span class="input-group-text" style="border-radius:.65rem 0 0 .65rem; border-right:none;">
                <i class="bi bi-lock"></i>
            </span>
            <input type="password" name="password" id="password"
                   class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                   placeholder="••••••••"
                   required style="border-radius:0;">
            <span class="input-group-text-toggle password-toggle-btn" data-target="password">
                <i class="bi bi-eye-slash"></i>
            </span>
        </div>
        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>

    {{-- Remember Me --}}
    <div class="mb-3 form-check">
        <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="remember" style="font-size:.8rem; color:#64748b;">Remember me on this device</label>
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn btn-primary w-100 mb-3">
        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
    </button>

    @if(config('auth-module.registration.enabled', true))
    <div class="text-center mb-2" style="font-size:.8rem; color:#64748b;">
        Don't have an account? <a href="{{ route('auth.register') }}">Create one</a>
    </div>
    @endif

    <div class="text-center" style="font-size:.75rem; color:#334155;">
        <a href="{{ route('admin.login') }}" style="color:#334155;">
            <i class="bi bi-shield-lock me-1"></i>Go to Admin Panel login →
        </a>
    </div>
</form>

@push('scripts')
<script>
function fillCredentials(email, password) {
    var e = document.getElementById('email');
    var p = document.getElementById('password');
    if (!e || !p) return;
    e.value = email;
    p.value = password;
    [e, p].forEach(function(f) {
        f.style.boxShadow = '0 0 0 3px rgba(99,102,241,0.45)';
        setTimeout(function() { f.style.boxShadow = ''; }, 900);
    });
}
</script>
@endpush

@endsection
