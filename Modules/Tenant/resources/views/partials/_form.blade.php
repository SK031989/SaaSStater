<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label font-semibold">Tenant Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $tenant->name ?? '') }}" required placeholder="e.g. Acme Corp">
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label font-semibold">Admin Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $tenant->email ?? '') }}" required placeholder="admin@acme.com">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="subdomain" class="form-label font-semibold">Subdomain Prefix <span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="text" class="form-control @error('subdomain') is-invalid @enderror" id="subdomain" name="subdomain" value="{{ old('subdomain', $tenant->subdomain ?? '') }}" required placeholder="acme">
            <span class="input-group-text">.saas.local</span>
        </div>
        @error('subdomain') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="company_name" class="form-label font-semibold">Legal Company Name</label>
        <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name', $tenant->company_name ?? '') }}" placeholder="Acme International Inc.">
        @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="custom_domain" class="form-label font-semibold">Custom Domain</label>
        <input type="text" class="form-control @error('custom_domain') is-invalid @enderror" id="custom_domain" name="custom_domain" value="{{ old('custom_domain', isset($tenant) ? $tenant->domains->first()?->domain : '') }}" placeholder="app.acme.com">
        @error('custom_domain') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label font-semibold">Status <span class="text-danger">*</span></label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
            <option value="active" {{ old('status', $tenant->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="suspended" {{ old('status', $tenant->status ?? '') === 'suspended' ? 'selected' : '' }}>Suspended</option>
            <option value="pending" {{ old('status', $tenant->status ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
