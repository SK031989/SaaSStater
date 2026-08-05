<div class="row g-3">
    <div class="col-md-6">
        <label for="subject" class="form-label font-semibold">Ticket Subject <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject"
               value="{{ old('subject', $ticket->subject ?? '') }}" required placeholder="e.g. Cannot access dashboard after plan upgrade">
        @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label for="priority" class="form-label font-semibold">Priority <span class="text-danger">*</span></label>
        <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
            <option value="low"    {{ old('priority', $ticket->priority ?? '') === 'low'    ? 'selected' : '' }}>Low</option>
            <option value="medium" {{ old('priority', $ticket->priority ?? 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="high"   {{ old('priority', $ticket->priority ?? '') === 'high'   ? 'selected' : '' }}>High</option>
            <option value="urgent" {{ old('priority', $ticket->priority ?? '') === 'urgent' ? 'selected' : '' }}>Urgent</option>
        </select>
        @error('priority') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label for="status" class="form-label font-semibold">Status <span class="text-danger">*</span></label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
            <option value="open"        {{ old('status', $ticket->status ?? 'open') === 'open'        ? 'selected' : '' }}>Open</option>
            <option value="in_progress" {{ old('status', $ticket->status ?? '') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="resolved"    {{ old('status', $ticket->status ?? '') === 'resolved'    ? 'selected' : '' }}>Resolved</option>
            <option value="closed"      {{ old('status', $ticket->status ?? '') === 'closed'      ? 'selected' : '' }}>Closed</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label for="message" class="form-label font-semibold">Message / Issue Description <span class="text-danger">*</span></label>
        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5"
                  required placeholder="Describe your issue in detail...">{{ old('message', $ticket->message ?? '') }}</textarea>
        @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
