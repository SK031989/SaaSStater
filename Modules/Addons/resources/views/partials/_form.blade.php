<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label font-semibold">Addon Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $addon->name ?? '') }}" required placeholder="e.g. Custom Domain SSL">
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="code" class="form-label font-semibold">Unique Addon Code</label>
        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $addon->code ?? '') }}" placeholder="custom-domain-ssl">
        @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="price_monthly" class="form-label font-semibold">Monthly Price ($) <span class="text-danger">*</span></label>
        <input type="number" step="0.01" class="form-control @error('price_monthly') is-invalid @enderror" id="price_monthly" name="price_monthly" value="{{ old('price_monthly', $addon->price_monthly ?? 0) }}" required placeholder="10.00">
        @error('price_monthly') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label font-semibold">Status <span class="text-danger">*</span></label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
            <option value="active" {{ old('status', $addon->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $addon->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label font-semibold">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Summary of functionality provided by this addon...">{{ old('description', $addon->description ?? '') }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
