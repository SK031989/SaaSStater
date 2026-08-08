@extends('dashboard::layouts.admin')

@section('title', 'Roles & Permissions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">Roles & Permissions</h1>
            <p class="text-sm text-slate-500 mb-0">Multi-Tenant RBAC role definitions and access control mapping.</p>
        </div>
        <a href="{{ route('rolepermissions.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i> Define New Role
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Role Title</th>
                            <th>Guard Name</th>
                            <th>System Role</th>
                            <th>Description</th>
                            <th class="text-center pe-4" style="width: 80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($roles as $r)
                        <tr>
                            <td class="ps-4 font-semibold text-slate-600">#{{ $r->id }}</td>
                            <td>
                                <span class="badge bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-500/15 dark:text-indigo-300 dark:border-indigo-500/30 rounded-pill px-3 py-1 font-bold text-sm">
                                    {{ $r->role_name }}
                                </span>
                            </td>
                            <td class="font-mono text-xs text-slate-600 dark:text-slate-300">{{ $r->guard_name }}</td>
                            <td>
                                @if($r->is_system)
                                    <span class="badge bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-500/15 dark:text-rose-300 dark:border-rose-500/30 rounded-pill px-3 py-1 font-medium">Core System</span>
                                @else
                                    <span class="badge bg-slate-100 text-slate-700 border border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 rounded-pill px-3 py-1 font-medium">Custom Role</span>
                                @endif
                            </td>
                            <td class="text-xs text-slate-500">{{ Str::limit($r->description ?? 'No description', 50) }}</td>
                            <td class="text-center pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm border-0 rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('rolepermissions.show', $r->id) }}">
                                                <i class="bi bi-eye text-primary me-2"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('rolepermissions.edit', $r->id) }}">
                                                <i class="bi bi-pencil text-warning me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form action="{{ route('rolepermissions.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');">
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
                            <td colspan="6" class="text-center py-5 text-slate-400">
                                <i class="bi bi-shield-check display-6 d-block mb-2"></i>
                                No roles found. Click "Define New Role" to create one.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($roles->hasPages())
            <div class="p-3 border-t border-slate-200">
                {{ $roles->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
