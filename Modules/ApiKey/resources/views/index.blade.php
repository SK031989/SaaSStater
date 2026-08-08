@extends('dashboard::layouts.admin')

@section('title', 'API Keys & Webhooks')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">API Keys & Tokens</h1>
            <p class="text-sm text-slate-500 mb-0">Manage Sanctum API tokens and secret keys for tenant integration.</p>
        </div>
        <a href="{{ route('apikeys.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i> Generate New Token
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Token Label</th>
                            <th>Tenant Organization</th>
                            <th>Secret Key Prefix</th>
                            <th>Status</th>
                            <th>Last Used</th>
                            <th class="text-center pe-4" style="width: 80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($apiKeys as $key)
                        <tr>
                            <td class="ps-4 font-semibold text-slate-600">#{{ $key->id }}</td>
                            <td class="font-bold text-slate-900 dark:text-white">{{ $key->name }}</td>
                            <td class="font-semibold text-slate-800 dark:text-slate-200">{{ $key->tenant->name ?? 'Tenant #'.$key->tenant_id }}</td>
                            <td>
                                <span class="badge bg-purple-50 text-purple-700 border border-purple-200 dark:bg-purple-500/15 dark:text-purple-300 dark:border-purple-500/30 rounded-pill px-3 py-1 font-mono text-xs">
                                    {{ Str::limit($key->key, 20) }}
                                </span>
                            </td>
                            <td>
                                @if($key->status === 'active')
                                    <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-300 dark:border-emerald-500/30 rounded-pill px-3 py-1 font-medium">Active</span>
                                @else
                                    <span class="badge bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-500/15 dark:text-rose-300 dark:border-rose-500/30 rounded-pill px-3 py-1 font-medium">Revoked</span>
                                @endif
                            </td>
                            <td class="text-xs text-slate-500">{{ $key->last_used_at ? $key->last_used_at->diffForHumans() : 'Never' }}</td>
                            <td class="text-center pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm border-0 rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('apikeys.show', $key->id) }}">
                                                <i class="bi bi-eye text-primary me-2"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('apikeys.edit', $key->id) }}">
                                                <i class="bi bi-pencil text-warning me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form action="{{ route('apikeys.destroy', $key->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to revoke this API key?');">
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
                                <i class="bi bi-key display-6 d-block mb-2"></i>
                                No API keys generated yet. Click "Generate New Token" to issue one.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($apiKeys->hasPages())
            <div class="p-3 border-t border-slate-200">
                {{ $apiKeys->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
