@extends('dashboard::layouts.admin')

@section('title', 'API Key Details')

@section('content')
<div class="container-fluid max-w-4xl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex items-center gap-3">
            <a href="{{ route('apikeys.index') }}" class="btn btn-sm btn-light rounded-circle p-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-0">API Key Details — {{ $apiKey->name }}</h1>
        </div>
        <a href="{{ route('apikeys.edit', $apiKey->id) }}" class="btn btn-warning text-white rounded-pill px-3">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Token Name</small>
                        <div class="font-bold text-slate-900 fs-5">{{ $apiKey->name }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Tenant Organization</small>
                        <div class="font-bold text-slate-900 fs-6">{{ $apiKey->tenant->name ?? 'Tenant #'.$apiKey->tenant_id }}</div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Full Secret Key Token</small>
                        <div class="font-mono text-purple-600 font-bold fs-6 select-all">{{ $apiKey->key }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Status</small>
                        @if($apiKey->status === 'active')
                            <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-pill px-3 py-1 fs-6">Active</span>
                        @else
                            <span class="badge bg-rose-50 text-rose-600 border border-rose-200 rounded-pill px-3 py-1 fs-6">Revoked</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Last Used Timestamp</small>
                        <div class="font-semibold text-slate-800">{{ $apiKey->last_used_at ? $apiKey->last_used_at->format('F d, Y h:i A') : 'Never Used' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
