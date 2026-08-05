@extends('dashboard::layouts.admin')

@section('title', 'Subscription Plan Details')

@section('content')
<div class="container-fluid max-w-4xl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex items-center gap-3">
            <a href="{{ route('subscriptions.index') }}" class="btn btn-sm btn-light rounded-circle p-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-0">Plan Details — {{ $plan->name }}</h1>
        </div>
        <a href="{{ route('subscriptions.edit', $plan->id) }}" class="btn btn-warning text-white rounded-pill px-3">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Plan Name</small>
                        <div class="font-bold text-slate-900 fs-5">{{ $plan->name }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Slug Code</small>
                        <div class="font-mono text-purple-600 font-semibold">{{ $plan->slug }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Monthly Price</small>
                        <div class="font-bold text-slate-900 fs-5">${{ number_format($plan->price_monthly, 2) }} / month</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Yearly Price</small>
                        <div class="font-bold text-slate-900 fs-5">${{ number_format($plan->price_yearly, 2) }} / year</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Max Users Limit</small>
                        <div class="font-semibold text-slate-800">{{ $plan->max_users }} Users</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Popular Status</small>
                        @if($plan->is_popular)
                            <span class="badge bg-amber-50 text-amber-600 border border-amber-200 rounded-pill px-3 py-1">⭐ Popular Plan</span>
                        @else
                            <span class="text-slate-600 font-medium">Standard Plan</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Status</small>
                        @if($plan->status === 'active')
                            <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-pill px-3 py-1">Active</span>
                        @else
                            <span class="badge bg-slate-100 text-slate-500 border border-slate-200 rounded-pill px-3 py-1">Inactive</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Created At</small>
                        <div class="font-semibold text-slate-800">{{ $plan->created_at ? $plan->created_at->format('F d, Y h:i A') : 'N/A' }}</div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-slate-500 font-semibold d-block uppercase text-xs mb-1">Description</small>
                        <div class="text-slate-800">{{ $plan->description ?? 'No description provided.' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
