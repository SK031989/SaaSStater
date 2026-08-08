@extends('dashboard::layouts.admin')

@section('title', 'Transaction Receipt — ' . $transaction->transaction_id)

@section('content')
<div class="container-fluid py-4">
    <div class="max-w-3xl mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">Transaction Receipt</h1>
                <p class="text-sm text-slate-500 mb-0">Transaction ID: <code class="text-indigo-400">{{ $transaction->transaction_id }}</code></p>
            </div>
            <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Back to Payments
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white dark:bg-slate-900 p-4">
            <div class="d-flex justify-content-between align-items-center pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                <div>
                    <span class="text-xs text-slate-500 uppercase block font-semibold">Total Amount Charged</span>
                    <div class="fs-2 font-bold text-emerald-600 dark:text-emerald-400">${{ number_format($transaction->amount, 2) }} {{ $transaction->currency }}</div>
                </div>
                <div>
                    @if($transaction->status === 'completed')
                        <span class="badge badge-emerald rounded-pill px-3 py-2 fs-6 font-medium"><i class="bi bi-check-circle-fill me-1"></i> Completed</span>
                    @else
                        <span class="badge badge-amber rounded-pill px-3 py-2 fs-6 font-medium">{{ ucfirst($transaction->status) }}</span>
                    @endif
                </div>
            </div>

            <div class="row g-3 text-sm">
                <div class="col-sm-6">
                    <span class="text-slate-500 block">Payer Name:</span>
                    <span class="fw-semibold text-slate-900 dark:text-white">{{ $transaction->user->name ?? 'N/A' }}</span>
                </div>
                <div class="col-sm-6">
                    <span class="text-slate-500 block">Payer Email:</span>
                    <span class="fw-semibold text-slate-900 dark:text-white">{{ $transaction->user->email ?? 'N/A' }}</span>
                </div>
                <div class="col-sm-6">
                    <span class="text-slate-500 block">Tenant Organization:</span>
                    <span class="fw-semibold text-slate-900 dark:text-white">{{ $transaction->tenant->name ?? 'Platform Global HQ' }}</span>
                </div>
                <div class="col-sm-6">
                    <span class="text-slate-500 block">Payment Gateway:</span>
                    <span class="fw-semibold text-slate-900 dark:text-white">{{ $transaction->gateway->name ?? 'Direct Payment' }}</span>
                </div>
                <div class="col-sm-6">
                    <span class="text-slate-500 block">Payment Method:</span>
                    <span class="fw-semibold text-slate-900 dark:text-white font-mono">{{ $transaction->payment_method ?? 'card' }}</span>
                </div>
                <div class="col-sm-6">
                    <span class="text-slate-500 block">Date & Time:</span>
                    <span class="fw-semibold text-slate-900 dark:text-white">{{ $transaction->created_at?->format('F d, Y \a\t H:i:s A') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
