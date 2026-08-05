@extends('dashboard::layouts.admin')

@section('title', 'Addon Extension Details')

@section('content')
<div class="container-fluid max-w-4xl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex items-center gap-3">
            <a href="{{ route('addons.index') }}" class="btn btn-sm btn-light rounded-circle p-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-0">Extension Details — {{ $addon->name }}</h1>
        </div>
        <a href="{{ route('addons.edit', $addon->id) }}" class="btn btn-warning text-white rounded-pill px-3">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Addon Name</small>
                        <div class="font-bold text-slate-900 fs-5">{{ $addon->name }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Addon Unique Code</small>
                        <div class="font-mono text-purple-600 font-semibold">{{ $addon->code }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Monthly Price</small>
                        <div class="font-bold text-slate-900 fs-4">${{ number_format($addon->price_monthly, 2) }} / month</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Status</small>
                        @if($addon->status === 'active')
                            <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-pill px-3 py-1 fs-6">Active</span>
                        @else
                            <span class="badge bg-slate-100 text-slate-500 border border-slate-200 rounded-pill px-3 py-1 fs-6">Inactive</span>
                        @endif
                    </div>
                </div>

                <div class="col-12">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Description</small>
                        <div class="text-slate-800">{{ $addon->description ?? 'No description provided.' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
