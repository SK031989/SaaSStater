@extends('dashboard::layouts.admin')

@section('title', 'Location Details — ' . $location->name)

@section('content')
<div class="container-fluid py-4">
    <div class="max-w-4xl mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">{{ $location->name }}</h1>
                <p class="text-sm text-slate-500 mb-0">Location Code: {{ $location->code ?? 'N/A' }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-warning rounded-pill px-4">
                    <i class="bi bi-pencil me-1"></i> Edit Location
                </a>
                <a href="{{ route('locations.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 bg-white dark:bg-slate-900 p-4 mb-4">
                    <h5 class="fw-bold text-slate-900 dark:text-white mb-3">Address & Coordinates</h5>
                    <div class="p-3 bg-slate-50 dark:bg-slate-800 rounded-3 mb-3 font-mono text-sm text-slate-800 dark:text-slate-200">
                        <i class="bi bi-geo-alt-fill text-danger me-2"></i>{{ $location->full_address }}
                    </div>
                    <div class="row g-3 text-sm">
                        <div class="col-sm-6">
                            <span class="text-slate-500 block">Address Line 1:</span>
                            <span class="fw-semibold text-slate-800 dark:text-slate-200">{{ $location->address_line_1 }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-slate-500 block">Address Line 2:</span>
                            <span class="fw-semibold text-slate-800 dark:text-slate-200">{{ $location->address_line_2 ?? '—' }}</span>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-slate-500 block">City:</span>
                            <span class="fw-semibold text-slate-800 dark:text-slate-200">{{ $location->city }}</span>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-slate-500 block">State / Region:</span>
                            <span class="fw-semibold text-slate-800 dark:text-slate-200">{{ $location->state ?? '—' }}</span>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-slate-500 block">Postal Code:</span>
                            <span class="fw-semibold text-slate-800 dark:text-slate-200">{{ $location->postal_code ?? '—' }}</span>
                        </div>
                    </div>
                </div>

                @if($location->notes)
                <div class="card border-0 shadow-sm rounded-4 bg-white dark:bg-slate-900 p-4">
                    <h5 class="fw-bold text-slate-900 dark:text-white mb-2">Location Notes</h5>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-0">{{ $location->notes }}</p>
                </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white dark:bg-slate-900 p-4 mb-4">
                    <h5 class="fw-bold text-slate-900 dark:text-white mb-3">Status & Scope</h5>
                    <div class="space-y-3 text-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-slate-500">Status:</span>
                            @if($location->status === 'active')
                                <span class="badge badge-emerald rounded-pill px-3 py-1 font-medium">Active</span>
                            @else
                                <span class="badge badge-slate rounded-pill px-3 py-1 font-medium">Inactive</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-slate-500">Primary Hub:</span>
                            @if($location->is_primary)
                                <span class="badge badge-purple rounded-pill px-3 py-1 font-medium"><i class="bi bi-star-fill me-1"></i>Primary</span>
                            @else
                                <span class="text-xs text-slate-400">Secondary</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-slate-500">Tenant:</span>
                            <span class="fw-semibold text-slate-800 dark:text-slate-200">{{ $location->tenant->name ?? 'Global Platform' }}</span>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 bg-white dark:bg-slate-900 p-4">
                    <h5 class="fw-bold text-slate-900 dark:text-white mb-3">Contact Details</h5>
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-slate-500 block">Phone:</span>
                            <span class="fw-semibold text-slate-800 dark:text-slate-200">{{ $location->phone ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Email:</span>
                            <span class="fw-semibold text-slate-800 dark:text-slate-200">{{ $location->email ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
