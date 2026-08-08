<div class="row g-3">
    @if(auth()->user()->is_admin && $tenants->count() > 0)
    <div class="col-md-12">
        <label for="tenant_id" class="form-label font-semibold text-slate-700 dark:text-slate-300">Assign to Tenant</label>
        <select name="tenant_id" id="tenant_id" class="form-select dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3">
            <option value="">-- Platform Default (Global HQ) --</option>
            @foreach($tenants as $t)
                <option value="{{ $t->id }}" {{ old('tenant_id', $location->tenant_id) == $t->id ? 'selected' : '' }}>
                    {{ $t->name }} (ID: {{ $t->id }})
                </option>
            @endforeach
        </select>
        @error('tenant_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    @endif

    <div class="col-md-8">
        <label for="name" class="form-label font-semibold text-slate-700 dark:text-slate-300">Location Name <span class="text-danger">*</span></label>
        <input type="text" name="name" id="name" class="form-control dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" value="{{ old('name', $location->name) }}" placeholder="e.g. San Francisco HQ, London Office" required>
        @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label for="code" class="form-label font-semibold text-slate-700 dark:text-slate-300">Location Code</label>
        <input type="text" name="code" id="code" class="form-control dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" value="{{ old('code', $location->code) }}" placeholder="e.g. HQ-01">
        @error('code')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="country" class="form-label font-semibold text-slate-700 dark:text-slate-300">Country <span class="text-danger">*</span></label>
        <input type="text" name="country" id="country" class="form-control dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" value="{{ old('country', $location->country) }}" placeholder="e.g. United States" required>
        @error('country')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="state" class="form-label font-semibold text-slate-700 dark:text-slate-300">State / Region</label>
        <input type="text" name="state" id="state" class="form-control dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" value="{{ old('state', $location->state) }}" placeholder="e.g. California">
        @error('state')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="city" class="form-label font-semibold text-slate-700 dark:text-slate-300">City <span class="text-danger">*</span></label>
        <input type="text" name="city" id="city" class="form-control dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" value="{{ old('city', $location->city) }}" placeholder="e.g. San Francisco" required>
        @error('city')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="postal_code" class="form-label font-semibold text-slate-700 dark:text-slate-300">Postal / Zip Code</label>
        <input type="text" name="postal_code" id="postal_code" class="form-control dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" value="{{ old('postal_code', $location->postal_code) }}" placeholder="e.g. 94105">
        @error('postal_code')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-12">
        <label for="address_line_1" class="form-label font-semibold text-slate-700 dark:text-slate-300">Address Line 1 <span class="text-danger">*</span></label>
        <input type="text" name="address_line_1" id="address_line_1" class="form-control dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" value="{{ old('address_line_1', $location->address_line_1) }}" placeholder="Street address, P.O. box" required>
        @error('address_line_1')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-12">
        <label for="address_line_2" class="form-label font-semibold text-slate-700 dark:text-slate-300">Address Line 2</label>
        <input type="text" name="address_line_2" id="address_line_2" class="form-control dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" value="{{ old('address_line_2', $location->address_line_2) }}" placeholder="Apartment, suite, unit, building, floor">
        @error('address_line_2')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="phone" class="form-label font-semibold text-slate-700 dark:text-slate-300">Phone Number</label>
        <input type="text" name="phone" id="phone" class="form-control dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" value="{{ old('phone', $location->phone) }}" placeholder="+1 (555) 000-0000">
        @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label font-semibold text-slate-700 dark:text-slate-300">Contact Email</label>
        <input type="email" name="email" id="email" class="form-control dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" value="{{ old('email', $location->email) }}" placeholder="location@company.com">
        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label font-semibold text-slate-700 dark:text-slate-300">Status <span class="text-danger">*</span></label>
        <select name="status" id="status" class="form-select dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" required>
            <option value="active" {{ old('status', $location->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $location->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 d-flex align-items-center pt-4">
        <div class="form-check form-switch">
            <input type="checkbox" name="is_primary" id="is_primary" class="form-check-input" value="1" {{ old('is_primary', $location->is_primary) ? 'checked' : '' }}>
            <label class="form-check-label font-semibold text-slate-700 dark:text-slate-300" for="is_primary">Set as Primary Location for Tenant</label>
        </div>
    </div>

    <div class="col-md-12">
        <label for="notes" class="form-label font-semibold text-slate-700 dark:text-slate-300">Internal Notes</label>
        <textarea name="notes" id="notes" rows="3" class="form-control dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" placeholder="Access codes, office hours, logistics notes...">{{ old('notes', $location->notes) }}</textarea>
        @error('notes')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
</div>
