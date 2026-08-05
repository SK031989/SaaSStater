<div class="row g-3">
    <div class="col-md-6">
        <label for="code" class="form-label font-semibold">Coupon Code <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $coupon->code ?? '') }}" required placeholder="e.g. WELCOME20">
        @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="type" class="form-label font-semibold">Discount Type <span class="text-danger">*</span></label>
        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
            <option value="percentage" {{ old('type', $coupon->type ?? 'percentage') === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
            <option value="fixed" {{ old('type', $coupon->type ?? '') === 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
        </select>
        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="value" class="form-label font-semibold">Discount Value <span class="text-danger">*</span></label>
        <input type="number" step="0.01" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="{{ old('value', $coupon->value ?? 0) }}" required placeholder="20">
        @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="max_uses" class="form-label font-semibold">Max Uses Limit <span class="text-danger">*</span></label>
        <input type="number" class="form-control @error('max_uses') is-invalid @enderror" id="max_uses" name="max_uses" value="{{ old('max_uses', $coupon->max_uses ?? 100) }}" required placeholder="100">
        @error('max_uses') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label font-semibold">Status <span class="text-danger">*</span></label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
            <option value="active" {{ old('status', $coupon->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="expired" {{ old('status', $coupon->status ?? '') === 'expired' ? 'selected' : '' }}>Expired</option>
            <option value="disabled" {{ old('status', $coupon->status ?? '') === 'disabled' ? 'selected' : '' }}>Disabled</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="expires_at" class="form-label font-semibold">Expiration Date</label>
        <input type="date" class="form-control @error('expires_at') is-invalid @enderror" id="expires_at" name="expires_at" value="{{ old('expires_at', isset($coupon->expires_at) ? $coupon->expires_at->format('Y-m-d') : now()->addMonths(3)->format('Y-m-d')) }}">
        @error('expires_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
