<div class="row g-3">
    <div class="col-md-6">
        <label for="plan_id" class="form-label font-semibold">Subscription Plan <span class="text-danger">*</span></label>
        <select class="form-select @error('plan_id') is-invalid @enderror" id="plan_id" name="plan_id" required>
            <option value="">Select Plan...</option>
            @foreach($plans as $p)
                <option value="{{ $p->id }}" {{ old('plan_id', $entitlement->plan_id ?? '') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
            @endforeach
        </select>
        @error('plan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="feature_key" class="form-label font-semibold">Feature Key <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('feature_key') is-invalid @enderror" id="feature_key" name="feature_key" value="{{ old('feature_key', $entitlement->feature_key ?? '') }}" required placeholder="e.g. max_storage, max_api_calls">
        @error('feature_key') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="feature_name" class="form-label font-semibold">Feature Label Name</label>
        <input type="text" class="form-control @error('feature_name') is-invalid @enderror" id="feature_name" name="feature_name" value="{{ old('feature_name', $entitlement->feature_name ?? '') }}" placeholder="e.g. Storage Limit">
        @error('feature_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label for="limit_value" class="form-label font-semibold">Quota Limit Value <span class="text-danger">*</span></label>
        <input type="number" class="form-control @error('limit_value') is-invalid @enderror" id="limit_value" name="limit_value" value="{{ old('limit_value', $entitlement->limit_value ?? 0) }}" required placeholder="100">
        @error('limit_value') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label for="unit" class="form-label font-semibold">Unit Type <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" value="{{ old('unit', $entitlement->unit ?? 'Count') }}" required placeholder="GB, Users, Requests">
        @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" id="is_unlimited" name="is_unlimited" value="1" {{ old('is_unlimited', $entitlement->is_unlimited ?? false) ? 'checked' : '' }}>
            <label class="form-check-label font-semibold" for="is_unlimited">Set Feature as Unlimited (Overrides Limit Value)</label>
        </div>
    </div>
</div>
