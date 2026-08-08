@extends('dashboard::layouts.admin')

@section('title', 'Notification Details')

@section('content')
<div class="container-fluid max-w-4xl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex items-center gap-3">
            <a href="{{ route('notifications.index', ['tab' => 'notifications']) }}" class="btn btn-sm btn-light rounded-circle p-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-0">Notification Details — {{ $notification->title }}</h1>
        </div>
        @if(!$notification->is_read)
        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success text-white rounded-pill px-3">
                <i class="bi bi-check-circle me-1"></i> Mark as Read
            </button>
        </form>
        @endif
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Notification Title</small>
                        <div class="font-bold text-slate-900 fs-5">{{ $notification->title }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Category Type</small>
                        @if($notification->type === 'billing')
                            <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-pill px-3 py-1 fs-6">Billing Alert</span>
                        @elseif($notification->type === 'security')
                            <span class="badge bg-rose-50 text-rose-600 border border-rose-200 rounded-pill px-3 py-1 fs-6">Security Warning</span>
                        @elseif($notification->type === 'warning')
                            <span class="badge bg-amber-50 text-amber-600 border border-amber-200 rounded-pill px-3 py-1 fs-6">Warning</span>
                        @else
                            <span class="badge bg-purple-50 text-purple-600 border border-purple-200 rounded-pill px-3 py-1 fs-6">Info</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Recipient User</small>
                        <div class="font-semibold text-slate-800">{{ $notification->user->name ?? 'All Tenant Users' }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Read Status</small>
                        @if($notification->is_read)
                            <span class="badge bg-slate-100 text-slate-700 px-3 py-1 rounded-pill"><i class="bi bi-check2-all me-1"></i> Read on {{ $notification->read_at ? $notification->read_at->format('M d, Y h:i A') : 'N/A' }}</span>
                        @else
                            <span class="badge bg-primary text-white px-3 py-1 rounded-pill"><i class="bi bi-envelope me-1"></i> Unread</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Created At</small>
                        <div class="font-semibold text-slate-800">{{ $notification->created_at ? $notification->created_at->format('F d, Y h:i A') : 'N/A' }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Action URL</small>
                        @if($notification->action_url)
                            <a href="{{ $notification->action_url }}" class="font-semibold text-primary text-decoration-underline" target="_blank">{{ $notification->action_url }}</a>
                        @else
                            <span class="text-slate-400">None</span>
                        @endif
                    </div>
                </div>

                <div class="col-12">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Notification Message</small>
                        <div class="text-slate-800 fs-6">{{ $notification->message }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
