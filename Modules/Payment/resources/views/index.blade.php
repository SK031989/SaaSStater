@extends('dashboard::layouts.admin')

@section('title', 'Payment Gateways & Transactions')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">Payment Gateways & Transactions</h1>
            <p class="text-sm text-slate-500 mb-0">Configure payment gateways, sandbox modes, and monitor payment transaction logs.</p>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white dark:bg-slate-900">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300 rounded-3">
                        <i class="bi bi-wallet2 fs-4"></i>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 font-medium">Total Transactions</div>
                        <div class="fs-4 font-bold text-slate-900 dark:text-white">{{ $stats['total_transactions'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white dark:bg-slate-900">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-300 rounded-3">
                        <i class="bi bi-currency-dollar fs-4"></i>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 font-medium">Processed Revenue</div>
                        <div class="fs-4 font-bold text-slate-900 dark:text-white">${{ number_format($stats['total_revenue'], 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white dark:bg-slate-900">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-300 rounded-3">
                        <i class="bi bi-credit-card-2-front fs-4"></i>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 font-medium">Active Gateways</div>
                        <div class="fs-4 font-bold text-slate-900 dark:text-white">{{ $stats['active_gateways'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white dark:bg-slate-900">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-300 rounded-3">
                        <i class="bi bi-clock-history fs-4"></i>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 font-medium">Pending Review</div>
                        <div class="fs-4 font-bold text-slate-900 dark:text-white">{{ $stats['pending_count'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs border-0 mb-4 gap-2" id="paymentTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active rounded-pill px-4" id="gateways-tab" data-bs-toggle="tab" data-bs-target="#gateways" type="button">
                <i class="bi bi-sliders me-2"></i> Gateway Configurations
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-4" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#transactions" type="button">
                <i class="bi bi-list-ul me-2"></i> Transaction Audit Logs
            </button>
        </li>
    </ul>

    <div class="tab-content" id="paymentTabsContent">
        
        {{-- TAB 1: GATEWAYS CONFIG --}}
        <div class="tab-pane fade show active" id="gateways" role="tabpanel">
            <div class="row g-4">
                @foreach($gateways as $g)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 bg-white dark:bg-slate-900 p-4 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="p-3 rounded-3 bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200">
                                    @if($g->code === 'stripe')
                                        <i class="bi bi-stripe fs-3 text-indigo-500"></i>
                                    @elseif($g->code === 'paypal')
                                        <i class="bi bi-paypal fs-3 text-blue-500"></i>
                                    @elseif($g->code === 'razorpay')
                                        <i class="bi bi-qr-code-scan fs-3 text-cyan-500"></i>
                                    @else
                                        <i class="bi bi-bank fs-3 text-emerald-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="fw-bold text-slate-900 dark:text-white mb-0">{{ $g->name }}</h5>
                                    <span class="text-xs text-slate-400 font-mono">Code: {{ $g->code }}</span>
                                </div>
                            </div>
                            <form action="{{ route('payments.gateways.toggle', $g->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $g->is_active ? 'btn-success' : 'btn-secondary' }} rounded-pill px-3">
                                    {{ $g->is_active ? 'Active' : 'Disabled' }}
                                </button>
                            </form>
                        </div>

                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">{{ $g->instructions ?? 'No instructions provided.' }}</p>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-t border-slate-100 dark:border-slate-800">
                            <span class="badge {{ $g->mode === 'live' ? 'bg-danger' : 'bg-warning text-dark' }} rounded-pill px-3 py-1 text-xs">
                                Mode: {{ strtoupper($g->mode) }}
                            </span>
                            <a href="{{ route('payments.gateways.edit', $g->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                <i class="bi bi-gear me-1"></i> Configure Keys
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- TAB 2: TRANSACTIONS LOG --}}
        <div class="tab-pane fade" id="transactions" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4 bg-white dark:bg-slate-900">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-xs">
                            <tr>
                                <th class="ps-4">Transaction ID</th>
                                <th>Gateway</th>
                                <th>Amount</th>
                                <th>Payer / Tenant</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-center pe-4" style="width:70px;">View</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @forelse($transactions as $t)
                            <tr>
                                <td class="ps-4 font-mono font-bold text-slate-900 dark:text-white">{{ $t->transaction_id }}</td>
                                <td class="font-medium text-slate-800 dark:text-slate-200">{{ $t->gateway->name ?? 'Direct' }}</td>
                                <td class="font-bold text-emerald-600 dark:text-emerald-400">${{ number_format($t->amount, 2) }} {{ $t->currency }}</td>
                                <td>
                                    <div class="font-semibold text-slate-900 dark:text-white text-xs">{{ $t->user->name ?? $t->tenant->name ?? 'Guest Payer' }}</div>
                                    <div class="text-xs text-slate-500">{{ $t->user->email ?? 'N/A' }}</div>
                                </td>
                                <td class="text-xs text-slate-500 font-mono">{{ $t->payment_method ?? 'card' }}</td>
                                <td>
                                    @if($t->status === 'completed')
                                        <span class="badge badge-emerald rounded-pill px-3 py-1 font-medium">Completed</span>
                                    @elseif($t->status === 'pending')
                                        <span class="badge badge-amber rounded-pill px-3 py-1 font-medium">Pending</span>
                                    @else
                                        <span class="badge badge-slate rounded-pill px-3 py-1 font-medium">{{ ucfirst($t->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-xs text-slate-500">{{ $t->created_at?->format('M d, Y H:i') }}</td>
                                <td class="text-center pe-4">
                                    <a href="{{ route('payments.transactions.show', $t->id) }}" class="btn btn-light btn-sm border-0 rounded-circle" title="View Transaction">
                                        <i class="bi bi-eye text-primary"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-slate-400">
                                    <i class="bi bi-wallet2 fs-2 d-block mb-2 opacity-50"></i>
                                    No payment transactions found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($transactions->hasPages())
                <div class="card-footer bg-transparent border-0 py-3">
                    {{ $transactions->links() }}
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
