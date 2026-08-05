@extends('dashboard::layouts.admin')

@section('title', 'Coupons & Discounts')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">Coupons & Discounts</h1>
            <p class="text-sm text-slate-500 mb-0">Manage promotional voucher codes, discount rules, usage limits, and expiration dates.</p>
        </div>
        <a href="{{ route('coupons.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i> Create Coupon
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Coupon Code</th>
                            <th>Discount Type</th>
                            <th>Discount Value</th>
                            <th>Usage Progress</th>
                            <th>Status</th>
                            <th>Expires At</th>
                            <th class="text-center pe-4" style="width: 80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($coupons as $coupon)
                        <tr>
                            <td class="ps-4 font-semibold text-slate-600">#{{ $coupon->id }}</td>
                            <td>
                                <span class="badge bg-purple-50 text-purple-600 border border-purple-200 rounded-pill px-3 py-1 font-mono font-bold text-sm">
                                    {{ $coupon->code }}
                                </span>
                            </td>
                            <td class="font-semibold text-slate-800">{{ ucfirst($coupon->type) }}</td>
                            <td class="font-bold text-slate-900">
                                @if($coupon->type === 'percentage')
                                    {{ number_format($coupon->value, 0) }}% OFF
                                @else
                                    ${{ number_format($coupon->value, 2) }} OFF
                                @endif
                            </td>
                            <td>
                                <div class="font-semibold text-slate-700 text-xs mb-1">{{ $coupon->used_count }} / {{ $coupon->max_uses }} Uses</div>
                                <div class="progress" style="height: 6px; width: 100px;">
                                    <div class="progress-bar bg-purple-500" role="progressbar" style="width: {{ min(100, ($coupon->used_count / max(1, $coupon->max_uses)) * 100) }}%"></div>
                                </div>
                            </td>
                            <td>
                                @if($coupon->status === 'active')
                                    <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-pill px-3 py-1">Active</span>
                                @elseif($coupon->status === 'expired')
                                    <span class="badge bg-amber-50 text-amber-600 border border-amber-200 rounded-pill px-3 py-1">Expired</span>
                                @else
                                    <span class="badge bg-slate-100 text-slate-500 border border-slate-200 rounded-pill px-3 py-1">Disabled</span>
                                @endif
                            </td>
                            <td class="text-xs text-slate-500">{{ $coupon->expires_at ? $coupon->expires_at->format('M d, Y') : 'Never' }}</td>
                            <td class="text-center pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm border-0 rounded-circle" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" title="Actions">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('coupons.show', $coupon->id) }}">
                                                <i class="bi bi-eye text-primary me-2"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('coupons.edit', $coupon->id) }}">
                                                <i class="bi bi-pencil text-warning me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
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
                                <i class="bi bi-ticket-perforated display-6 d-block mb-2"></i>
                                No coupons found. Click "Create Coupon" to add a promotional discount.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($coupons->hasPages())
            <div class="p-3 border-t border-slate-200">
                {{ $coupons->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
