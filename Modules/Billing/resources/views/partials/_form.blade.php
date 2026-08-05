<div class="row g-3">
    <div class="col-md-6">
        <label for="tenant_id" class="form-label font-semibold">Tenant Organization <span class="text-danger">*</span></label>
        <select class="form-select @error('tenant_id') is-invalid @enderror" id="tenant_id" name="tenant_id" required>
            <option value="">Select Tenant...</option>
            @foreach($tenants as $t)
                <option value="{{ $t->id }}" {{ old('tenant_id', $invoice->tenant_id ?? '') == $t->id ? 'selected' : '' }}>{{ $t->name }} ({{ $t->subdomain }})</option>
            @endforeach
        </select>
        @error('tenant_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label for="amount" class="form-label font-semibold">Invoice Amount ($) <span class="text-danger">*</span></label>
        <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount', $invoice->amount ?? 0) }}" required placeholder="29.00">
        @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label for="currency" class="form-label font-semibold">Currency <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('currency') is-invalid @enderror" id="currency" name="currency" value="{{ old('currency', $invoice->currency ?? 'USD') }}" required placeholder="USD">
        @error('currency') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label font-semibold">Payment Status <span class="text-danger">*</span></label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
            <option value="pending" {{ old('status', $invoice->status ?? 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="paid" {{ old('status', $invoice->status ?? '') === 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="failed" {{ old('status', $invoice->status ?? '') === 'failed' ? 'selected' : '' }}>Failed</option>
            <option value="refunded" {{ old('status', $invoice->status ?? '') === 'refunded' ? 'selected' : '' }}>Refunded</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="due_date" class="form-label font-semibold">Due Date</label>
        <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date', isset($invoice->due_date) ? $invoice->due_date->format('Y-m-d') : now()->addDays(14)->format('Y-m-d')) }}">
        @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
