@extends('dashboard::layouts.admin')

@section('title', 'Tenant Details')

@section('content')
<div class="container-fluid max-w-4xl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex items-center gap-3">
            <a href="{{ route('tenants.index') }}" class="btn btn-sm btn-light rounded-circle p-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-0">Tenant Details — {{ $tenant->name }}</h1>
        </div>
        <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn btn-warning text-white rounded-pill px-3">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Tenant Name</small>
                        <div class="font-bold text-slate-900 fs-5">{{ $tenant->name }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Admin Email</small>
                        <div class="font-semibold text-slate-800 fs-6">{{ $tenant->email }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Subdomain</small>
                        <span class="badge bg-purple-50 text-purple-600 border border-purple-200 rounded-pill px-3 py-1 font-mono fs-6">
                            {{ $tenant->subdomain }}.saas.local
                        </span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Company Name</small>
                        <div class="font-semibold text-slate-800">{{ $tenant->company_name ?? 'N/A' }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Custom Domain</small>
                        <div class="font-semibold text-slate-800">{{ $tenant->domains->first()?->domain ?? 'None Configured' }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Status</small>
                        @if($tenant->status === 'active')
                            <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-pill px-3 py-1">Active</span>
                        @elseif($tenant->status === 'suspended')
                            <span class="badge bg-rose-50 text-rose-600 border border-rose-200 rounded-pill px-3 py-1">Suspended</span>
                        @else
                            <span class="badge bg-amber-50 text-amber-600 border border-amber-200 rounded-pill px-3 py-1">Pending</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Onboarded Date</small>
                        <div class="font-semibold text-slate-800">{{ $tenant->onboarded_at ? $tenant->onboarded_at->format('F d, Y h:i A') : 'N/A' }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Last Updated</small>
                        <div class="font-semibold text-slate-800">{{ $tenant->updated_at ? $tenant->updated_at->format('F d, Y h:i A') : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
