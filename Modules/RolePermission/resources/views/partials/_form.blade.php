<div class="row g-3">
    <div class="col-md-6">
        <label for="role_name" class="form-label font-semibold">Role Title <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('role_name') is-invalid @enderror" id="role_name" name="role_name" value="{{ old('role_name', $role->role_name ?? '') }}" required placeholder="e.g. Tenant HR Manager">
        @error('role_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="guard_name" class="form-label font-semibold">Guard Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('guard_name') is-invalid @enderror" id="guard_name" name="guard_name" value="{{ old('guard_name', $role->guard_name ?? 'web') }}" required placeholder="web, sanctum">
        @error('guard_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" id="is_system" name="is_system" value="1" {{ old('is_system', $role->is_system ?? false) ? 'checked' : '' }}>
            <label class="form-check-label font-semibold" for="is_system">System Core Role (Protected from Deletion)</label>
        </div>
    </div>

    <div class="col-12">
        <label for="description" class="form-label font-semibold">Description & Access Scope</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Define access permissions and role scope...">{{ old('description', $role->description ?? '') }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
