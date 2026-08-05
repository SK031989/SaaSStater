<div class="row g-3">
    <div class="col-md-6">
        <label for="tenant_id" class="form-label font-semibold">Tenant Workspace <span class="text-danger">*</span></label>
        <select class="form-select @error('tenant_id') is-invalid @enderror" id="tenant_id" name="tenant_id" required>
            <option value="">Select Tenant...</option>
            @foreach($tenants as $t)
                <option value="{{ $t->id }}" {{ old('tenant_id', $apiKey->tenant_id ?? '') == $t->id ? 'selected' : '' }}>{{ $t->name }} ({{ $t->subdomain }})</option>
            @endforeach
        </select>
        @error('tenant_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="name" class="form-label font-semibold">Token Identifier Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $apiKey->name ?? '') }}" required placeholder="e.g. Production Webhook Token">
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label font-semibold">Status <span class="text-danger">*</span></label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
            <option value="active" {{ old('status', $apiKey->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="revoked" {{ old('status', $apiKey->status ?? '') === 'revoked' ? 'selected' : '' }}>Revoked</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
