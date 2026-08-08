@extends('dashboard::layouts.admin')

@section('title', 'Notifications & Activity Center')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">Notifications & Activity Logs</h1>
            <p class="text-sm text-slate-500 mb-0">Manage in-app user notifications, audit logs, notification templates, and channel preferences.</p>
        </div>
        <a href="{{ route('notifications.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i> Send / Log Notification
        </a>
    </div>


    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs border-bottom mb-4">
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'notifications' ? 'active font-bold text-primary border-primary' : 'text-slate-600' }}" href="{{ route('notifications.index', ['tab' => 'notifications']) }}">
                <i class="bi bi-bell me-2"></i> In-App Notifications
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'logs' ? 'active font-bold text-primary border-primary' : 'text-slate-600' }}" href="{{ route('notifications.index', ['tab' => 'logs']) }}">
                <i class="bi bi-journal-text me-2"></i> Activity Logs
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'templates' ? 'active font-bold text-primary border-primary' : 'text-slate-600' }}" href="{{ route('notifications.index', ['tab' => 'templates']) }}">
                <i class="bi bi-file-earmark-text me-2"></i> Notification Templates
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'settings' ? 'active font-bold text-primary border-primary' : 'text-slate-600' }}" href="{{ route('notifications.index', ['tab' => 'settings']) }}">
                <i class="bi bi-sliders me-2"></i> Channel Preferences
            </a>
        </li>
    </ul>

    <!-- Tab 1: In-App Notifications -->
    @if($tab === 'notifications')
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white dark:bg-slate-900 border-0 py-3">
            <h5 class="card-title mb-0 text-slate-800 font-bold">User Notifications Table</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Title & Message</th>
                            <th>Type</th>
                            <th>Recipient</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th class="text-center pe-4" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($notifications as $item)
                        <tr>
                            <td class="ps-4 font-semibold text-slate-600">#{{ $item->id }}</td>
                            <td>
                                <div class="font-bold text-slate-900 dark:text-white">{{ $item->title }}</div>
                                <div class="text-xs text-slate-500">{{ Str::limit($item->message, 80) }}</div>
                            </td>
                            <td>
                                @if($item->type === 'billing')
                                    <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-300 dark:border-emerald-500/30 rounded-pill px-3 py-1">Billing</span>
                                @elseif($item->type === 'security')
                                    <span class="badge bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-500/15 dark:text-rose-300 dark:border-rose-500/30 rounded-pill px-3 py-1">Security</span>
                                @elseif($item->type === 'warning')
                                    <span class="badge bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-500/15 dark:text-amber-300 dark:border-amber-500/30 rounded-pill px-3 py-1">Warning</span>
                                @else
                                    <span class="badge bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-500/15 dark:text-indigo-300 dark:border-indigo-500/30 rounded-pill px-3 py-1">Info</span>
                                @endif
                            </td>
                            <td class="font-semibold text-slate-800 dark:text-slate-200">{{ $item->user->name ?? 'All Users' }}</td>
                            <td>
                                @if($item->is_read)
                                    <span class="badge bg-slate-100 text-slate-700 border border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 px-3 py-1 rounded-pill"><i class="bi bi-check2-all me-1"></i> Read</span>
                                @else
                                    <span class="badge bg-primary text-white px-3 py-1 rounded-pill"><i class="bi bi-envelope me-1"></i> Unread</span>
                                @endif
                            </td>
                            <td class="text-xs text-slate-500 dark:text-slate-400">{{ $item->created_at ? $item->created_at->format('M d, Y h:i A') : 'N/A' }}</td>
                            <td class="text-center pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm border-0 rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('notifications.view', $item->id) }}">
                                                <i class="bi bi-eye text-primary me-2"></i> View Details
                                            </a>
                                        </li>
                                        @if(!$item->is_read)
                                        <li>
                                            <form action="{{ route('notifications.read', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="dropdown-item py-2 rounded-2 text-success">
                                                    <i class="bi bi-check-circle text-success me-2"></i> Mark as Read
                                                </button>
                                            </form>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        @endif
                                        <li>
                                            <form action="{{ route('notifications.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this notification?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item py-2 rounded-2 text-danger">
                                                    <i class="bi bi-trash text-danger me-2"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-slate-400">
                                <i class="bi bi-bell-slash display-6 d-block mb-2"></i>
                                No notifications recorded yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($notifications->hasPages())
            <div class="p-3 border-t border-slate-200 dark:border-slate-800">
                {{ $notifications->appends(['tab' => 'notifications'])->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Tab 2: Activity Logs -->
    @elseif($tab === 'logs')
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white dark:bg-slate-900 border-0 py-3">
            <h5 class="card-title mb-0 text-slate-800 dark:text-white font-bold">System Activity & Audit Logs Table</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 uppercase text-xs">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Module</th>
                            <th>Action Title</th>
                            <th>Log Level</th>
                            <th>Triggered By</th>
                            <th>IP Address</th>
                            <th>Timestamp</th>
                            <th class="text-center pe-4" style="width: 80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($logs as $log)
                        <tr>
                            <td class="ps-4 font-semibold text-slate-600 dark:text-slate-400">#{{ $log->id }}</td>
                            <td>
                                <span class="badge bg-slate-100 text-slate-700 border border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 px-2.5 py-1 rounded-pill font-mono text-xs">
                                    {{ $log->module ?? 'System' }}
                                </span>
                            </td>
                            <td class="font-bold text-slate-900 dark:text-white">{{ $log->action }}</td>
                            <td>
                                @if($log->log_type === 'success')
                                    <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-300 dark:border-emerald-500/30 rounded-pill px-3 py-1">Success</span>
                                @elseif($log->log_type === 'warning')
                                    <span class="badge bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-500/15 dark:text-amber-300 dark:border-amber-500/30 rounded-pill px-3 py-1">Warning</span>
                                @elseif($log->log_type === 'danger')
                                    <span class="badge bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-500/15 dark:text-rose-300 dark:border-rose-500/30 rounded-pill px-3 py-1">Danger</span>
                                @else
                                    <span class="badge bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-500/15 dark:text-indigo-300 dark:border-indigo-500/30 rounded-pill px-3 py-1">Info</span>
                                @endif
                            </td>
                            <td class="font-semibold text-slate-800">{{ $log->user->name ?? 'System Process' }}</td>
                            <td class="font-mono text-xs text-slate-600">{{ $log->ip_address ?? '127.0.0.1' }}</td>
                            <td class="text-xs text-slate-500">{{ $log->created_at ? $log->created_at->format('M d, Y h:i A') : 'N/A' }}</td>
                            <td class="text-center pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm border-0 rounded-circle" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" title="Actions">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('notifications.show', $log->id) }}">
                                                <i class="bi bi-eye text-primary me-2"></i> View Details
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('notifications.edit', $log->id) }}">
                                                <i class="bi bi-pencil text-warning me-2"></i> Edit Log
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form action="{{ route('notifications.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Delete this activity log?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item py-2 rounded-2 text-danger">
                                                    <i class="bi bi-trash text-danger me-2"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-slate-400">
                                <i class="bi bi-journal-x display-6 d-block mb-2"></i>
                                No activity logs recorded.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
            <div class="p-3 border-t border-slate-200">
                {{ $logs->appends(['tab' => 'logs'])->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Tab 3: Notification Templates -->
    @elseif($tab === 'templates')
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white dark:bg-slate-900 border-0 py-3">
            <h5 class="card-title mb-0 text-slate-800 font-bold">System Notification Templates Table</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="ps-4">Code Key</th>
                            <th>Template Name</th>
                            <th>Subject</th>
                            <th>Channel</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($templates as $tpl)
                        <tr>
                            <td class="ps-4 font-mono text-xs text-primary font-bold">{{ $tpl->code }}</td>
                            <td class="font-bold text-slate-900 dark:text-white">{{ $tpl->title }}</td>
                            <td class="text-slate-700 text-sm">{{ $tpl->subject }}</td>
                            <td><span class="badge bg-slate-100 text-slate-700 px-3 py-1 rounded-pill uppercase">{{ $tpl->channel }}</span></td>
                            <td>
                                @if($tpl->is_active)
                                    <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-pill px-3 py-1">Active</span>
                                @else
                                    <span class="badge bg-slate-100 text-slate-500 rounded-pill px-3 py-1">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-slate-400">
                                <i class="bi bi-file-earmark-x display-6 d-block mb-2"></i>
                                No notification templates defined.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($templates->hasPages())
            <div class="p-3 border-t border-slate-200">
                {{ $templates->appends(['tab' => 'templates'])->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Tab 4: Channel Preferences / Settings -->
    @elseif($tab === 'settings')
    <div class="card border-0 shadow-sm rounded-4 max-w-2xl">
        <div class="card-header bg-white dark:bg-slate-900 border-0 py-3">
            <h5 class="card-title mb-0 text-slate-800 font-bold">Notification Channel & Alert Preferences</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('notifications.settings.update') }}" method="POST">
                @csrf
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="email_notifications" id="email_notifications" {{ $settings->email_notifications ? 'checked' : '' }}>
                    <label class="form-check-label font-semibold text-slate-800" for="email_notifications">
                        Email Notifications
                    </label>
                    <div class="text-xs text-slate-500">Receive transactional emails and updates directly to your registered inbox.</div>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="system_notifications" id="system_notifications" {{ $settings->system_notifications ? 'checked' : '' }}>
                    <label class="form-check-label font-semibold text-slate-800" for="system_notifications">
                        In-App System Notifications
                    </label>
                    <div class="text-xs text-slate-500">Display popup alerts and badge indicators in the top navigation bar.</div>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="billing_alerts" id="billing_alerts" {{ $settings->billing_alerts ? 'checked' : '' }}>
                    <label class="form-check-label font-semibold text-slate-800" for="billing_alerts">
                        Billing & Payment Alerts
                    </label>
                    <div class="text-xs text-slate-500">Get notified when new invoices are generated or subscriptions renew.</div>
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="security_alerts" id="security_alerts" {{ $settings->security_alerts ? 'checked' : '' }}>
                    <label class="form-check-label font-semibold text-slate-800" for="security_alerts">
                        Critical Security Alerts
                    </label>
                    <div class="text-xs text-slate-500">Receive immediate warnings on unrecognized login attempts or password changes.</div>
                </div>

                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-save me-2"></i> Save Notification Preferences
                </button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
