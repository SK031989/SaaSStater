@extends('dashboard::layouts.admin')

@section('title', 'Support Tickets')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">Support Tickets</h1>
            <p class="text-sm text-slate-500 mb-0">Manage customer helpdesk tickets and support requests.</p>
        </div>
        <a href="{{ route('tickets.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i> Open Ticket
        </a>
    </div>


    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="ps-4">Ticket #</th>
                            <th>Subject</th>
                            <th>Tenant</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Opened</th>
                            <th class="text-center pe-4" style="width:80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                        <tr>
                            <td class="ps-4 font-mono font-semibold text-purple-600">{{ $ticket->ticket_number }}</td>
                            <td class="font-bold text-slate-900 dark:text-white">{{ Str::limit($ticket->subject, 45) }}</td>
                            <td class="text-slate-600 dark:text-slate-300">{{ $ticket->tenant->name ?? 'N/A' }}</td>
                            <td>
                                @if($ticket->priority === 'urgent')
                                    <span class="badge bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-500/15 dark:text-rose-300 dark:border-rose-500/30 rounded-pill px-3 py-1 font-medium">Urgent</span>
                                @elseif($ticket->priority === 'high')
                                    <span class="badge bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-500/15 dark:text-amber-300 dark:border-amber-500/30 rounded-pill px-3 py-1 font-medium">High</span>
                                @elseif($ticket->priority === 'medium')
                                    <span class="badge bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-500/15 dark:text-indigo-300 dark:border-indigo-500/30 rounded-pill px-3 py-1 font-medium">Medium</span>
                                @else
                                    <span class="badge bg-slate-100 text-slate-700 border border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 rounded-pill px-3 py-1 font-medium">Low</span>
                                @endif
                            </td>
                            <td>
                                @if($ticket->status === 'resolved')
                                    <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-300 dark:border-emerald-500/30 rounded-pill px-3 py-1 font-medium">Resolved</span>
                                @elseif($ticket->status === 'in_progress')
                                    <span class="badge bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-500/15 dark:text-amber-300 dark:border-amber-500/30 rounded-pill px-3 py-1 font-medium">In Progress</span>
                                @elseif($ticket->status === 'open')
                                    <span class="badge bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-500/15 dark:text-indigo-300 dark:border-indigo-500/30 rounded-pill px-3 py-1 font-medium">Open</span>
                                @else
                                    <span class="badge bg-slate-100 text-slate-700 border border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 rounded-pill px-3 py-1 font-medium">Closed</span>
                                @endif
                            </td>
                            <td class="text-xs text-slate-500">{{ $ticket->created_at?->format('M d, Y') }}</td>
                            <td class="text-center pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm border-0 rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                                        <li><a class="dropdown-item py-2 rounded-2" href="{{ route('tickets.show', $ticket->id) }}"><i class="bi bi-eye text-primary me-2"></i>View</a></li>
                                        <li><a class="dropdown-item py-2 rounded-2" href="{{ route('tickets.edit', $ticket->id) }}"><i class="bi bi-pencil text-warning me-2"></i>Edit</a></li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Close and delete this ticket?');">
                                                @csrf @method('DELETE')
                                                <button class="dropdown-item py-2 rounded-2 text-danger"><i class="bi bi-trash text-danger me-2"></i>Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-slate-400">
                                <i class="bi bi-headset display-6 d-block mb-2"></i>No support tickets found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($tickets->hasPages())
            <div class="p-3 border-top">{{ $tickets->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
