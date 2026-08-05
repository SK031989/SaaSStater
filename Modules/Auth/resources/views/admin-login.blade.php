@extends('auth-module::layouts.auth')

@section('title', 'Admin Login')

{{-- ── Left Panel Credential Cards ── --}}
@section('left-bottom')
<p style="font-size:.66rem; font-weight:600; color:#475569; text-transform:uppercase; letter-spacing:.06em; margin: .85rem 0 .5rem;">
    <i class="bi bi-cursor me-1"></i> Admin Accounts — click to fill
</p>

{{-- Super Admin --}}
<div class="cred-card" onclick="fillAdminCredentials('admin@saas.local','AdminPass123!')"
     style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3);">
    <div class="cred-card-label" style="color:#f87171; display:flex; align-items:center;">
        <i class="bi bi-shield-fill-check me-1"></i>Super Admin
        <span class="cred-fill-hint">click to fill</span>
    </div>
    <div class="cred-card-row"><i class="bi bi-envelope" style="color:#475569;"></i><code style="color:#93c5fd;">admin@saas.local</code></div>
    <div class="cred-card-row"><i class="bi bi-lock" style="color:#475569;"></i><code style="color:#86efac;">AdminPass123!</code></div>
</div>

{{-- Alpha Tenant Admin --}}
<div class="cred-card" onclick="fillAdminCredentials('tenant1@saas.local','TenantPass123!')"
     style="background:rgba(99,102,241,0.1); border:1px solid rgba(99,102,241,0.3);">
    <div class="cred-card-label" style="color:#a5b4fc; display:flex; align-items:center;">
        <i class="bi bi-building me-1"></i>Alpha Corp Admin
        <span class="cred-fill-hint">click to fill</span>
    </div>
    <div class="cred-card-row"><i class="bi bi-envelope" style="color:#475569;"></i><code style="color:#93c5fd;">tenant1@saas.local</code></div>
    <div class="cred-card-row"><i class="bi bi-lock" style="color:#475569;"></i><code style="color:#86efac;">TenantPass123!</code></div>
</div>

{{-- Beta Tenant Admin --}}
<div class="cred-card" onclick="fillAdminCredentials('tenant2@saas.local','TenantPass123!')"
     style="background:rgba(16,185,129,0.08); border:1px solid rgba(16,185,129,0.28);">
    <div class="cred-card-label" style="color:#6ee7b7; display:flex; align-items:center;">
        <i class="bi bi-building me-1"></i>Beta Solutions Admin
        <span class="cred-fill-hint">click to fill</span>
    </div>
    <div class="cred-card-row"><i class="bi bi-envelope" style="color:#475569;"></i><code style="color:#93c5fd;">tenant2@saas.local</code></div>
    <div class="cred-card-row"><i class="bi bi-lock" style="color:#475569;"></i><code style="color:#86efac;">TenantPass123!</code></div>
</div>
@endsection

@section('content')

{{-- Header --}}
<div class="text-center mb-3">
    <span class="badge px-3 py-1 mb-2" style="background:rgba(220,53,69,0.18); color:#f87171; border:1px solid rgba(220,53,69,0.35); border-radius:2rem; font-size:.72rem;">
        <i class="bi bi-shield-lock me-1"></i>Administrator Area
    </span>
    <h5 class="fw-bold mb-1">Admin Login</h5>
    <p class="text-muted mb-0" style="font-size:.8rem;">Authorized personnel only.</p>
</div>

{{-- Flash --}}
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
<form action="{{ route('admin.login.store') }}" method="POST" id="adminLoginForm">
    @csrf

    {{-- Email --}}
    <div class="mb-3">
        <label for="email" class="form-label">Admin Email</label>
        <div class="input-group">
            <span class="input-group-text" style="border-radius:.65rem 0 0 .65rem; border-right:none;">
                <i class="bi bi-envelope-check"></i>
            </span>
            <input type="email" name="email" id="email"
                   class="form-control border-start-0 @error('email') is-invalid @enderror"
                   value="{{ old('email') }}"
                   placeholder="admin@saas.local"
                   required autofocus
                   style="border-radius:0 .65rem .65rem 0;">
        </div>
        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>

    {{-- Password --}}
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text" style="border-radius:.65rem 0 0 .65rem; border-right:none;">
                <i class="bi bi-lock-fill"></i>
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

    {{-- Remember --}}
    <div class="mb-3 form-check">
        <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="remember" style="font-size:.8rem; color:#64748b;">Remember me on this device</label>
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn btn-danger w-100 mb-3">
        <i class="bi bi-shield-shaded me-2"></i>Authenticate Admin
    </button>

    <div class="text-center" style="font-size:.78rem; color:#334155;">
        <a href="{{ route('auth.login') }}" style="color:#334155;">
            <i class="bi bi-arrow-left me-1"></i>Back to User Login
        </a>
    </div>
</form>

@push('scripts')
<script>
function fillAdminCredentials(email, password) {
    var e = document.getElementById('email');
    var p = document.getElementById('password');
    if (!e || !p) return;
    e.value = email;
    p.value = password;
    [e, p].forEach(function(f) {
        f.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.4)';
        setTimeout(function() { f.style.boxShadow = ''; }, 900);
    });
}
</script>
@endpush

@endsection
