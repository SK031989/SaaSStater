@extends('dashboard::layouts.admin')

@section('title', 'Role Details')

@section('content')
<div class="container-fluid max-w-4xl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex items-center gap-3">
            <a href="{{ route('rolepermissions.index') }}" class="btn btn-sm btn-light rounded-circle p-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-0">Role Details — {{ $role->role_name }}</h1>
        </div>
        <a href="{{ route('rolepermissions.edit', $role->id) }}" class="btn btn-warning text-white rounded-pill px-3">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Role Title</small>
                        <div class="font-bold text-indigo-600 fs-5">{{ $role->role_name }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Guard Name</small>
                        <div class="font-mono text-slate-800 fs-6">{{ $role->guard_name }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">System Core Role</small>
                        @if($role->is_system)
                            <span class="badge bg-rose-50 text-rose-600 border border-rose-200 rounded-pill px-3 py-1 fs-6">Core System Role</span>
                        @else
                            <span class="badge bg-slate-100 text-slate-500 border border-slate-200 rounded-pill px-3 py-1 fs-6">Custom Role</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Created Date</small>
                        <div class="font-semibold text-slate-800">{{ $role->created_at ? $role->created_at->format('F d, Y h:i A') : 'N/A' }}</div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Description & Scope</small>
                        <div class="text-slate-800">{{ $role->description ?? 'No description provided.' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
