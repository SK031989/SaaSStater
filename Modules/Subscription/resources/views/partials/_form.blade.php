<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label font-semibold">Plan Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $plan->name ?? '') }}" required placeholder="e.g. Growth Pro">
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label for="price_monthly" class="form-label font-semibold">Monthly Price ($) <span class="text-danger">*</span></label>
        <input type="number" step="0.01" class="form-control @error('price_monthly') is-invalid @enderror" id="price_monthly" name="price_monthly" value="{{ old('price_monthly', $plan->price_monthly ?? 0) }}" required placeholder="29.00">
        @error('price_monthly') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label for="price_yearly" class="form-label font-semibold">Yearly Price ($) <span class="text-danger">*</span></label>
        <input type="number" step="0.01" class="form-control @error('price_yearly') is-invalid @enderror" id="price_yearly" name="price_yearly" value="{{ old('price_yearly', $plan->price_yearly ?? 0) }}" required placeholder="290.00">
        @error('price_yearly') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="max_users" class="form-label font-semibold">Max Users Quota <span class="text-danger">*</span></label>
        <input type="number" class="form-control @error('max_users') is-invalid @enderror" id="max_users" name="max_users" value="{{ old('max_users', $plan->max_users ?? 10) }}" required placeholder="10">
        @error('max_users') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label font-semibold">Status <span class="text-danger">*</span></label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
            <option value="active" {{ old('status', $plan->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $plan->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" id="is_popular" name="is_popular" value="1" {{ old('is_popular', $plan->is_popular ?? false) ? 'checked' : '' }}>
            <label class="form-check-label font-semibold" for="is_popular">Highlight as "Popular Plan"</label>
        </div>
    </div>

    <div class="col-12">
        <label for="description" class="form-label font-semibold">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Features and summary of this subscription plan...">{{ old('description', $plan->description ?? '') }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
