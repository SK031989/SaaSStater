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

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-4">{{ session('success') }}</div>
    @endif

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
                            <td class="text-slate-600">{{ $ticket->tenant->name ?? 'N/A' }}</td>
                            <td>
                                @php $pc = ['low'=>'secondary','medium'=>'info','high'=>'warning','urgent'=>'danger'][$ticket->priority] ?? 'secondary' @endphp
                                <span class="badge bg-{{ $pc }}-subtle text-{{ $pc }}-emphasis rounded-pill px-3">{{ ucfirst($ticket->priority) }}</span>
                            </td>
                            <td>
                                @php $sc = ['open'=>'primary','in_progress'=>'warning','resolved'=>'success','closed'=>'secondary'][$ticket->status] ?? 'secondary' @endphp
                                <span class="badge bg-{{ $sc }}-subtle text-{{ $sc }}-emphasis rounded-pill px-3">{{ ucwords(str_replace('_',' ',$ticket->status)) }}</span>
                            </td>
                            <td class="text-xs text-slate-500">{{ $ticket->created_at?->format('M d, Y') }}</td>
                            <td class="text-center pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm border-0 rounded-circle" type="button" data-bs-toggle="dropdown" data-bs-display="static">
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
