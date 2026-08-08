@extends('dashboard::layouts.admin')

@section('title', 'Location Management')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">Locations & Regional Hubs</h1>
            <p class="text-sm text-slate-500 mb-0">Manage physical offices, warehouses, hubs, and primary regional addresses.</p>
        </div>
        <a href="{{ route('locations.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i> Add Location
        </a>
    </div>

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white dark:bg-slate-900">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300 rounded-3">
                        <i class="bi bi-geo-alt fs-4"></i>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 font-medium">Total Locations</div>
                        <div class="fs-4 font-bold text-slate-900 dark:text-white">{{ $stats['total'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white dark:bg-slate-900">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-300 rounded-3">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 font-medium">Active Locations</div>
                        <div class="fs-4 font-bold text-slate-900 dark:text-white">{{ $stats['active'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white dark:bg-slate-900">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-300 rounded-3">
                        <i class="bi bi-star fs-4"></i>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 font-medium">Primary Hubs</div>
                        <div class="fs-4 font-bold text-slate-900 dark:text-white">{{ $stats['primary'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white dark:bg-slate-900">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300 rounded-3">
                        <i class="bi bi-pause-circle fs-4"></i>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 font-medium">Inactive</div>
                        <div class="fs-4 font-bold text-slate-900 dark:text-white">{{ $stats['inactive'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white dark:bg-slate-900 p-3">
        <form method="GET" action="{{ route('locations.index') }}" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 dark:border-slate-800 text-slate-400">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 dark:bg-slate-900 dark:border-slate-800 dark:text-white" value="{{ $filters['search'] ?? '' }}" placeholder="Search by name, city, country, code...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select dark:bg-slate-900 dark:border-slate-800 dark:text-white">
                    <option value="">All Statuses</option>
                    <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            @if(auth()->user()->is_admin && $tenants->count() > 0)
            <div class="col-md-3">
                <select name="tenant_id" class="form-select dark:bg-slate-900 dark:border-slate-800 dark:text-white">
                    <option value="">All Tenants</option>
                    @foreach($tenants as $t)
                        <option value="{{ $t->id }}" {{ ($filters['tenant_id'] ?? '') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 rounded-3"><i class="bi bi-funnel me-1"></i> Filter</button>
                <a href="{{ route('locations.index') }}" class="btn btn-light dark:bg-slate-800 dark:text-slate-300 rounded-3"><i class="bi bi-x-circle"></i></a>
            </div>
        </form>
    </div>

    {{-- Main Locations Table Card --}}
    <div class="card border-0 shadow-sm rounded-4 bg-white dark:bg-slate-900">
        <div class="card-body p-0">
            @include('locations::partials.table', ['locations' => $locations])
        </div>
        @if($locations->hasPages())
        <div class="card-footer bg-transparent border-0 py-3">
            {{ $locations->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
