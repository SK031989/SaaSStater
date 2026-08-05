@extends('dashboard::layouts.admin')

@section('title', 'Tenant Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">Tenant Management</h1>
            <p class="text-sm text-slate-500 mb-0">Manage registered SaaS organizations, subdomains, and custom domains.</p>
        </div>
        <a href="{{ route('tenants.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i> Register New Tenant
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Tenant / Company</th>
                            <th>Subdomain</th>
                            <th>Admin Email</th>
                            <th>Status</th>
                            <th>Onboarded</th>
                            <th class="text-center pe-4" style="width: 80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($tenants as $tenant)
                        <tr>
                            <td class="ps-4 font-semibold text-slate-600">#{{ $tenant->id }}</td>
                            <td>
                                <div class="font-bold text-slate-900 dark:text-white">{{ $tenant->name }}</div>
                                <div class="text-xs text-slate-500">{{ $tenant->company_name ?? '—' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-purple-50 text-purple-600 dark:bg-purple-950/30 border border-purple-200 dark:border-purple-800 rounded-pill px-3 py-1 font-mono">
                                    {{ $tenant->subdomain }}.saas.local
                                </span>
                            </td>
                            <td class="text-slate-700 dark:text-slate-300">{{ $tenant->email }}</td>
                            <td>
                                @if($tenant->status === 'active')
                                    <span class="badge bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 border border-emerald-200 rounded-pill px-3 py-1">Active</span>
                                @elseif($tenant->status === 'suspended')
                                    <span class="badge bg-rose-50 text-rose-600 dark:bg-rose-950/30 border border-rose-200 rounded-pill px-3 py-1">Suspended</span>
                                @else
                                    <span class="badge bg-amber-50 text-amber-600 dark:bg-amber-950/30 border border-amber-200 rounded-pill px-3 py-1">Pending</span>
                                @endif
                            </td>
                            <td class="text-xs text-slate-500">
                                {{ $tenant->onboarded_at ? $tenant->onboarded_at->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="text-center pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm border-0 rounded-circle" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" title="Actions">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('tenants.show', $tenant->id) }}">
                                                <i class="bi bi-eye text-primary me-2"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('tenants.edit', $tenant->id) }}">
                                                <i class="bi bi-pencil text-warning me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form action="{{ route('tenants.destroy', $tenant->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tenant?');">
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
                                <i class="bi bi-building display-6 d-block mb-2"></i>
                                No tenants found. Click "Register New Tenant" to create one.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($tenants->hasPages())
            <div class="p-3 border-t border-slate-200">
                {{ $tenants->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
