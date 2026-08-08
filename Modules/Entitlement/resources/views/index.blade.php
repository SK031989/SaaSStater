@extends('dashboard::layouts.admin')

@section('title', 'Entitlements & Feature Quotas')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">Entitlements & Quotas</h1>
            <p class="text-sm text-slate-500 mb-0">Configure granular feature limits, storage units, and plan access controls.</p>
        </div>
        <a href="{{ route('entitlements.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i> Add Entitlement Rule
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Subscription Plan</th>
                            <th>Feature Key</th>
                            <th>Feature Name</th>
                            <th>Quota Limit</th>
                            <th>Unlimited</th>
                            <th class="text-center pe-4" style="width: 80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($entitlements as $entitlement)
                        <tr>
                            <td class="ps-4 font-semibold text-slate-600">#{{ $entitlement->id }}</td>
                            <td>
                                <span class="badge bg-purple-50 text-purple-700 border border-purple-200 dark:bg-purple-500/15 dark:text-purple-300 dark:border-purple-500/30 rounded-pill px-3 py-1 font-semibold">
                                    {{ $entitlement->plan->name ?? 'Plan #'.$entitlement->plan_id }}
                                </span>
                            </td>
                            <td class="font-mono text-slate-800 dark:text-slate-200 text-xs">{{ $entitlement->feature_key }}</td>
                            <td class="font-semibold text-slate-900 dark:text-white">{{ $entitlement->feature_name }}</td>
                            <td class="font-semibold text-slate-700 dark:text-slate-300">
                                @if($entitlement->is_unlimited)
                                    <span class="text-emerald-600 dark:text-emerald-400">∞ Unlimited</span>
                                @else
                                    {{ $entitlement->limit_value }} {{ $entitlement->unit }}
                                @endif
                            </td>
                            <td>
                                @if($entitlement->is_unlimited)
                                    <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-300 dark:border-emerald-500/30 rounded-pill px-3 py-1 font-medium">Yes</span>
                                @else
                                    <span class="badge bg-slate-100 text-slate-700 border border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 rounded-pill px-3 py-1 font-medium">No</span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm border-0 rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('entitlements.show', $entitlement->id) }}">
                                                <i class="bi bi-eye text-primary me-2"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('entitlements.edit', $entitlement->id) }}">
                                                <i class="bi bi-pencil text-warning me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form action="{{ route('entitlements.destroy', $entitlement->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this entitlement rule?');">
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
                            <td colspan="7" class="text-center py-5 text-slate-400">
                                <i class="bi bi-sliders display-6 d-block mb-2"></i>
                                No entitlement rules found. Click "Add Entitlement Rule" to configure quotas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($entitlements->hasPages())
            <div class="p-3 border-t border-slate-200">
                {{ $entitlements->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
