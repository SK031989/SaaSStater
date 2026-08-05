<div class="row g-3">
    <div class="col-md-6">
        <label for="log_type" class="form-label font-semibold">Log Level / Type <span class="text-danger">*</span></label>
        <select class="form-select @error('log_type') is-invalid @enderror" id="log_type" name="log_type" required>
            <option value="info" {{ old('log_type', $log->log_type ?? 'info') === 'info' ? 'selected' : '' }}>Info</option>
            <option value="success" {{ old('log_type', $log->log_type ?? '') === 'success' ? 'selected' : '' }}>Success</option>
            <option value="warning" {{ old('log_type', $log->log_type ?? '') === 'warning' ? 'selected' : '' }}>Warning</option>
            <option value="danger" {{ old('log_type', $log->log_type ?? '') === 'danger' ? 'selected' : '' }}>Critical Danger</option>
        </select>
        @error('log_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="action" class="form-label font-semibold">Action Title <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('action') is-invalid @enderror" id="action" name="action" value="{{ old('action', $log->action ?? '') }}" required placeholder="e.g. User Profile Updated">
        @error('action') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label font-semibold">Audit Event Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Detailed audit trail description...">{{ old('description', $log->description ?? '') }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
