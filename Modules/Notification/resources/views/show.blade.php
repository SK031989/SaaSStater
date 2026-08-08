@extends('dashboard::layouts.admin')

@section('title', 'Log Details')

@section('content')
<div class="container-fluid max-w-4xl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex items-center gap-3">
            <a href="{{ route('notifications.index', ['tab' => 'logs']) }}" class="btn btn-sm btn-light rounded-circle p-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-0">Activity Log — {{ $log->action }}</h1>
        </div>
        <a href="{{ route('notifications.edit', $log->id) }}" class="btn btn-warning text-white rounded-pill px-3">
            <i class="bi bi-pencil me-1"></i> Edit Log
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Action Title</small>
                        <div class="font-bold text-slate-900 fs-5">{{ $log->action }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Module</small>
                        <span class="badge bg-slate-200 text-slate-800 font-mono text-sm px-3 py-1 rounded-pill">{{ $log->module ?? 'System' }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Log Level</small>
                        @if($log->log_type === 'success')
                            <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-pill px-3 py-1 fs-6">Success</span>
                        @elseif($log->log_type === 'warning')
                            <span class="badge bg-amber-50 text-amber-600 border border-amber-200 rounded-pill px-3 py-1 fs-6">Warning</span>
                        @elseif($log->log_type === 'danger')
                            <span class="badge bg-rose-50 text-rose-600 border border-rose-200 rounded-pill px-3 py-1 fs-6">Danger</span>
                        @else
                            <span class="badge bg-purple-50 text-purple-600 border border-purple-200 rounded-pill px-3 py-1 fs-6">Info</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Triggered By User</small>
                        <div class="font-semibold text-slate-800">{{ $log->user->name ?? 'System Process' }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">IP Address</small>
                        <div class="font-mono text-slate-800">{{ $log->ip_address ?? '127.0.0.1' }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Created At</small>
                        <div class="font-semibold text-slate-800">{{ $log->created_at ? $log->created_at->format('F d, Y h:i A') : 'N/A' }}</div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Detailed Log Description</small>
                        <div class="text-slate-800">{{ $log->description ?? 'No extra description recorded.' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
