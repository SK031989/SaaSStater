@extends('dashboard::layouts.admin')
@section('title', 'Ticket Details')
@section('content')
<div class="container-fluid max-w-4xl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-light rounded-circle p-2"><i class="bi bi-arrow-left"></i></a>
            <div>
                <h1 class="h3 font-bold text-slate-900 dark:text-white mb-0">{{ $ticket->ticket_number }}</h1>
                <p class="text-sm text-slate-500 mb-0">{{ $ticket->subject }}</p>
            </div>
        </div>
        <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning text-white rounded-pill px-3"><i class="bi bi-pencil me-1"></i>Edit</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block text-uppercase" style="font-size:.7rem;">Tenant</small>
                        <div class="font-bold text-slate-900">{{ $ticket->tenant->name ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block text-uppercase" style="font-size:.7rem;">Priority</small>
                        @php $pc = ['low'=>'secondary','medium'=>'info','high'=>'warning','urgent'=>'danger'][$ticket->priority] ?? 'secondary' @endphp
                        <span class="badge bg-{{ $pc }}-subtle text-{{ $pc }}-emphasis rounded-pill px-3 py-1 fs-6">{{ ucfirst($ticket->priority) }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block text-uppercase" style="font-size:.7rem;">Status</small>
                        @php $sc = ['open'=>'primary','in_progress'=>'warning','resolved'=>'success','closed'=>'secondary'][$ticket->status] ?? 'secondary' @endphp
                        <span class="badge bg-{{ $sc }}-subtle text-{{ $sc }}-emphasis rounded-pill px-3 py-1 fs-6">{{ ucwords(str_replace('_',' ',$ticket->status)) }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block text-uppercase" style="font-size:.7rem;">Submitted By</small>
                        <div class="font-semibold text-slate-800">{{ $ticket->user->name ?? 'Guest / System' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block text-uppercase" style="font-size:.7rem;">Opened On</small>
                        <div class="font-semibold text-slate-800">{{ $ticket->created_at?->format('F d, Y h:i A') }}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block text-uppercase mb-2" style="font-size:.7rem;">Message</small>
                        <div class="text-slate-800">{{ $ticket->message }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
