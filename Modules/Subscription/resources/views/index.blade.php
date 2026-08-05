@extends('dashboard::layouts.admin')

@section('title', 'Subscription Plans')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">Subscription Plans</h1>
            <p class="text-sm text-slate-500 mb-0">Define SaaS pricing tiers, feature quotas, and popular badges.</p>
        </div>
        <a href="{{ route('subscriptions.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i> Create New Plan
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Plan Name</th>
                            <th>Monthly Price</th>
                            <th>Yearly Price</th>
                            <th>Max Users</th>
                            <th>Popular Badge</th>
                            <th>Status</th>
                            <th class="text-center pe-4" style="width: 80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($plans as $plan)
                        <tr>
                            <td class="ps-4 font-semibold text-slate-600">#{{ $plan->id }}</td>
                            <td>
                                <div class="font-bold text-slate-900 dark:text-white">{{ $plan->name }}</div>
                                <div class="text-xs text-slate-500 font-mono">{{ $plan->slug }}</div>
                            </td>
                            <td class="font-semibold text-slate-900">${{ number_format($plan->price_monthly, 2) }}/mo</td>
                            <td class="font-semibold text-slate-900">${{ number_format($plan->price_yearly, 2) }}/yr</td>
                            <td>
                                <span class="badge bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 rounded-pill px-3 py-1">
                                    {{ $plan->max_users }} Users
                                </span>
                            </td>
                            <td>
                                @if($plan->is_popular)
                                    <span class="badge bg-amber-50 text-amber-600 border border-amber-200 rounded-pill px-3 py-1">⭐ Popular</span>
                                @else
                                    <span class="text-xs text-slate-400">Standard</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->status === 'active')
                                    <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-pill px-3 py-1">Active</span>
                                @else
                                    <span class="badge bg-slate-100 text-slate-500 border border-slate-200 rounded-pill px-3 py-1">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm border-0 rounded-circle" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" title="Actions">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('subscriptions.show', $plan->id) }}">
                                                <i class="bi bi-eye text-primary me-2"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('subscriptions.edit', $plan->id) }}">
                                                <i class="bi bi-pencil text-warning me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form action="{{ route('subscriptions.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subscription plan?');">
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
                                <i class="bi bi-credit-card display-6 d-block mb-2"></i>
                                No subscription plans found. Click "Create New Plan" to get started.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($plans->hasPages())
            <div class="p-3 border-t border-slate-200">
                {{ $plans->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
