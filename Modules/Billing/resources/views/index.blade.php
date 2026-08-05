@extends('dashboard::layouts.admin')

@section('title', 'Billing & Invoices')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">Billing & Invoices</h1>
            <p class="text-sm text-slate-500 mb-0">Track subscription billing receipts, transaction history, and payment statuses.</p>
        </div>
        <a href="{{ route('billings.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i> Create Invoice
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="ps-4">Invoice #</th>
                            <th>Tenant Organization</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Paid Date</th>
                            <th class="text-center pe-4" style="width: 80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($invoices as $invoice)
                        <tr>
                            <td class="ps-4 font-bold text-purple-600 font-mono">{{ $invoice->invoice_number }}</td>
                            <td>
                                <div class="font-semibold text-slate-900 dark:text-white">{{ $invoice->tenant->name ?? 'Tenant #'.$invoice->tenant_id }}</div>
                                <div class="text-xs text-slate-500">{{ $invoice->tenant->subdomain ?? '' }}.saas.local</div>
                            </td>
                            <td class="font-bold text-slate-900">${{ number_format($invoice->amount, 2) }}</td>
                            <td class="font-mono text-xs text-slate-600">{{ $invoice->currency }}</td>
                            <td>
                                @if($invoice->status === 'paid')
                                    <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-pill px-3 py-1">Paid</span>
                                @elseif($invoice->status === 'pending')
                                    <span class="badge bg-amber-50 text-amber-600 border border-amber-200 rounded-pill px-3 py-1">Pending</span>
                                @else
                                    <span class="badge bg-rose-50 text-rose-600 border border-rose-200 rounded-pill px-3 py-1">{{ ucfirst($invoice->status) }}</span>
                                @endif
                            </td>
                            <td class="text-xs text-slate-500">{{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'N/A' }}</td>
                            <td class="text-xs text-slate-500">{{ $invoice->paid_at ? $invoice->paid_at->format('M d, Y') : 'Unpaid' }}</td>
                            <td class="text-center pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm border-0 rounded-circle" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" title="Actions">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('billings.show', $invoice->id) }}">
                                                <i class="bi bi-eye text-primary me-2"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('billings.edit', $invoice->id) }}">
                                                <i class="bi bi-pencil text-warning me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form action="{{ route('billings.destroy', $invoice->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this invoice record?');">
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
                            <td colspan="8" class="text-center py-5 text-slate-400">
                                <i class="bi bi-receipt display-6 d-block mb-2"></i>
                                No invoices found. Click "Create Invoice" to issue one.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($invoices->hasPages())
            <div class="p-3 border-t border-slate-200">
                {{ $invoices->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
