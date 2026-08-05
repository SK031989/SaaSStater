@extends('dashboard::layouts.admin')

@section('title', 'Activity Logs & Notifications')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">Activity & Audit Logs</h1>
            <p class="text-sm text-slate-500 mb-0">System notifications, user access activity, and security audit trails.</p>
        </div>
        <a href="{{ route('notifications.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i> Record Manual Log
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Action Title</th>
                            <th>Log Level</th>
                            <th>Triggered By User</th>
                            <th>IP Address</th>
                            <th>Timestamp</th>
                            <th class="text-center pe-4" style="width: 80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($logs as $log)
                        <tr>
                            <td class="ps-4 font-semibold text-slate-600">#{{ $log->id }}</td>
                            <td class="font-bold text-slate-900 dark:text-white">{{ $log->action }}</td>
                            <td>
                                @if($log->log_type === 'success')
                                    <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-pill px-3 py-1">Success</span>
                                @elseif($log->log_type === 'warning')
                                    <span class="badge bg-amber-50 text-amber-600 border border-amber-200 rounded-pill px-3 py-1">Warning</span>
                                @elseif($log->log_type === 'danger')
                                    <span class="badge bg-rose-50 text-rose-600 border border-rose-200 rounded-pill px-3 py-1">Danger</span>
                                @else
                                    <span class="badge bg-purple-50 text-purple-600 border border-purple-200 rounded-pill px-3 py-1">Info</span>
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
                                                <i class="bi bi-eye text-primary me-2"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('notifications.edit', $log->id) }}">
                                                <i class="bi bi-pencil text-warning me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form action="{{ route('notifications.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this log?');">
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
                                <i class="bi bi-bell display-6 d-block mb-2"></i>
                                No activity logs found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
            <div class="p-3 border-t border-slate-200">
                {{ $logs->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
