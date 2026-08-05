@extends('dashboard::layouts.admin')

@section('title', 'Coupon Details')

@section('content')
<div class="container-fluid max-w-4xl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex items-center gap-3">
            <a href="{{ route('coupons.index') }}" class="btn btn-sm btn-light rounded-circle p-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-0">Coupon Details — {{ $coupon->code }}</h1>
        </div>
        <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-warning text-white rounded-pill px-3">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Coupon Code</small>
                        <div class="font-bold text-purple-600 fs-4 font-mono">{{ $coupon->code }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Discount Type</small>
                        <div class="font-semibold text-slate-800 fs-6">{{ ucfirst($coupon->type) }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Discount Value</small>
                        <div class="font-bold text-slate-900 fs-5">
                            @if($coupon->type === 'percentage')
                                {{ number_format($coupon->value, 0) }}% OFF
                            @else
                                ${{ number_format($coupon->value, 2) }} OFF
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Max Uses Limit</small>
                        <div class="font-semibold text-slate-800">{{ $coupon->max_uses }} Times</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Total Times Used</small>
                        <div class="font-semibold text-slate-800">{{ $coupon->used_count }} Times</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Status</small>
                        @if($coupon->status === 'active')
                            <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-pill px-3 py-1 fs-6">Active</span>
                        @elseif($coupon->status === 'expired')
                            <span class="badge bg-amber-50 text-amber-600 border border-amber-200 rounded-pill px-3 py-1 fs-6">Expired</span>
                        @else
                            <span class="badge bg-slate-100 text-slate-500 border border-slate-200 rounded-pill px-3 py-1 fs-6">Disabled</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Expires Date</small>
                        <div class="font-semibold text-slate-800">{{ $coupon->expires_at ? $coupon->expires_at->format('F d, Y') : 'Never' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
