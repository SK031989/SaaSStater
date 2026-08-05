@extends('dashboard::layouts.admin')

@section('title', 'Entitlement Details')

@section('content')
<div class="container-fluid max-w-4xl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex items-center gap-3">
            <a href="{{ route('entitlements.index') }}" class="btn btn-sm btn-light rounded-circle p-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-0">Entitlement Details — {{ $entitlement->feature_name }}</h1>
        </div>
        <a href="{{ route('entitlements.edit', $entitlement->id) }}" class="btn btn-warning text-white rounded-pill px-3">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Target Plan</small>
                        <div class="font-bold text-slate-900 fs-5">{{ $entitlement->plan->name ?? 'Plan #'.$entitlement->plan_id }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Feature Key</small>
                        <div class="font-mono text-purple-600 font-semibold">{{ $entitlement->feature_key }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Feature Display Name</small>
                        <div class="font-semibold text-slate-800">{{ $entitlement->feature_name }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Quota Limit</small>
                        <div class="font-bold text-slate-900">
                            @if($entitlement->is_unlimited)
                                <span class="text-emerald-600">Unlimited (∞)</span>
                            @else
                                {{ $entitlement->limit_value }} {{ $entitlement->unit }}
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Unit Type</small>
                        <div class="font-semibold text-slate-800">{{ $entitlement->unit }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Unlimited Override</small>
                        @if($entitlement->is_unlimited)
                            <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-pill px-3 py-1">Enabled</span>
                        @else
                            <span class="badge bg-slate-100 text-slate-500 border border-slate-200 rounded-pill px-3 py-1">Disabled</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
