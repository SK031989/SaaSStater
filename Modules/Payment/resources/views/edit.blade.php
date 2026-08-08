@extends('dashboard::layouts.admin')

@section('title', 'Configure Gateway — ' . $gateway->name)

@section('content')
<div class="container-fluid py-4">
    <div class="max-w-3xl mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">Configure {{ $gateway->name }}</h1>
                <p class="text-sm text-slate-500 mb-0">Update API keys, environment mode, and customer instructions.</p>
            </div>
            <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white dark:bg-slate-900 p-4">
            <form action="{{ route('payments.gateways.update', $gateway->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-8">
                        <label for="name" class="form-label font-semibold text-slate-700 dark:text-slate-300">Gateway Display Name</label>
                        <input type="text" name="name" id="name" class="form-control dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" value="{{ old('name', $gateway->name) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="mode" class="form-label font-semibold text-slate-700 dark:text-slate-300">Environment Mode</label>
                        <select name="mode" id="mode" class="form-select dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" required>
                            <option value="sandbox" {{ old('mode', $gateway->mode) === 'sandbox' ? 'selected' : '' }}>Sandbox (Test)</option>
                            <option value="live" {{ old('mode', $gateway->mode) === 'live' ? 'selected' : '' }}>Live (Production)</option>
                        </select>
                    </div>

                    {{-- Dynamic Credentials Fields based on Gateway Code --}}
                    <div class="col-md-12 border-t border-slate-100 dark:border-slate-800 pt-3 mt-3">
                        <h6 class="font-bold text-slate-900 dark:text-white mb-3"><i class="bi bi-key-fill text-warning me-1"></i> API Credentials & Secrets</h6>

                        @if($gateway->code === 'stripe')
                            <div class="mb-3">
                                <label for="pk" class="form-label text-xs font-semibold text-slate-600 dark:text-slate-400">Publishable Key</label>
                                <input type="text" name="credentials[publishable_key]" id="pk" class="form-control font-mono text-xs dark:bg-slate-800 dark:border-slate-700 dark:text-white" value="{{ old('credentials.publishable_key', $gateway->credentials['publishable_key'] ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label for="sk" class="form-label text-xs font-semibold text-slate-600 dark:text-slate-400">Secret Key</label>
                                <input type="password" name="credentials[secret_key]" id="sk" class="form-control font-mono text-xs dark:bg-slate-800 dark:border-slate-700 dark:text-white" value="{{ old('credentials.secret_key', $gateway->credentials['secret_key'] ?? '') }}">
                            </div>
                        @elseif($gateway->code === 'paypal')
                            <div class="mb-3">
                                <label for="client_id" class="form-label text-xs font-semibold text-slate-600 dark:text-slate-400">PayPal Client ID</label>
                                <input type="text" name="credentials[client_id]" id="client_id" class="form-control font-mono text-xs dark:bg-slate-800 dark:border-slate-700 dark:text-white" value="{{ old('credentials.client_id', $gateway->credentials['client_id'] ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label for="secret" class="form-label text-xs font-semibold text-slate-600 dark:text-slate-400">PayPal Secret</label>
                                <input type="password" name="credentials[secret]" id="secret" class="form-control font-mono text-xs dark:bg-slate-800 dark:border-slate-700 dark:text-white" value="{{ old('credentials.secret', $gateway->credentials['secret'] ?? '') }}">
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="bank_details" class="form-label text-xs font-semibold text-slate-600 dark:text-slate-400">Bank Account Details / Wire Instructions</label>
                                <textarea name="instructions" id="instructions" rows="4" class="form-control text-xs font-mono dark:bg-slate-800 dark:border-slate-700 dark:text-white">{{ old('instructions', $gateway->instructions) }}</textarea>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 pt-2">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $gateway->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label font-semibold text-slate-700 dark:text-slate-300" for="is_active">Enable Gateway</label>
                        </div>
                    </div>

                    <div class="col-md-6 pt-2">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_default" id="is_default" class="form-check-input" value="1" {{ old('is_default', $gateway->is_default) ? 'checked' : '' }}>
                            <label class="form-check-label font-semibold text-slate-700 dark:text-slate-300" for="is_default">Default Gateway at Checkout</label>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('payments.index') }}" class="btn btn-light dark:bg-slate-800 dark:text-slate-300 rounded-3 px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">
                        <i class="bi bi-check-lg me-1"></i> Save Configuration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
