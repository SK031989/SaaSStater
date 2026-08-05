@extends('dashboard::layouts.admin')

@section('title', 'Invoice Details')

@section('content')
<div class="container-fluid max-w-4xl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex items-center gap-3">
            <a href="{{ route('billings.index') }}" class="btn btn-sm btn-light rounded-circle p-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-0">Invoice {{ $invoice->invoice_number }}</h1>
        </div>
        <a href="{{ route('billings.edit', $invoice->id) }}" class="btn btn-warning text-white rounded-pill px-3">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Invoice Number</small>
                        <div class="font-bold text-purple-600 fs-5 font-mono">{{ $invoice->invoice_number }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Tenant Organization</small>
                        <div class="font-bold text-slate-900 fs-6">{{ $invoice->tenant->name ?? 'Tenant #'.$invoice->tenant_id }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Total Amount</small>
                        <div class="font-bold text-slate-900 fs-4">${{ number_format($invoice->amount, 2) }} {{ $invoice->currency }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Payment Status</small>
                        @if($invoice->status === 'paid')
                            <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-pill px-3 py-1 fs-6">Paid</span>
                        @elseif($invoice->status === 'pending')
                            <span class="badge bg-amber-50 text-amber-600 border border-amber-200 rounded-pill px-3 py-1 fs-6">Pending</span>
                        @else
                            <span class="badge bg-rose-50 text-rose-600 border border-rose-200 rounded-pill px-3 py-1 fs-6">{{ ucfirst($invoice->status) }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Due Date</small>
                        <div class="font-semibold text-slate-800">{{ $invoice->due_date ? $invoice->due_date->format('F d, Y') : 'N/A' }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Paid At Timestamp</small>
                        <div class="font-semibold text-slate-800">{{ $invoice->paid_at ? $invoice->paid_at->format('F d, Y h:i A') : 'Not Yet Paid' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
