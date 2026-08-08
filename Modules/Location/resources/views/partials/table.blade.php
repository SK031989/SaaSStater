<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-xs">
            <tr>
                <th class="ps-4">ID</th>
                <th>Location Name</th>
                <th>City & Country</th>
                <th>Contact</th>
                <th>Primary</th>
                <th>Status</th>
                <th>Created</th>
                <th class="text-center pe-4" style="width: 80px;">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
            @forelse($locations as $location)
            <tr>
                <td class="ps-4 font-semibold text-slate-600 dark:text-slate-400">#{{ $location->id }}</td>
                <td>
                    <div class="font-bold text-slate-900 dark:text-white">{{ $location->name }}</div>
                    <div class="text-xs text-slate-500 font-mono">{{ $location->code ?? 'NO-CODE' }}</div>
                </td>
                <td>
                    <div class="font-medium text-slate-800 dark:text-slate-200">{{ $location->city }}, {{ $location->country }}</div>
                    <div class="text-xs text-slate-500">{{ Str::limit($location->address_line_1, 35) }}</div>
                </td>
                <td>
                    <div class="text-xs text-slate-700 dark:text-slate-300">{{ $location->email ?? '—' }}</div>
                    <div class="text-xs text-slate-500">{{ $location->phone ?? '—' }}</div>
                </td>
                <td>
                    @if($location->is_primary)
                        <span class="badge badge-purple rounded-pill px-3 py-1 font-medium"><i class="bi bi-star-fill me-1"></i>Primary</span>
                    @else
                        <span class="text-xs text-slate-400 dark:text-slate-500">Secondary</span>
                    @endif
                </td>
                <td>
                    @if($location->status === 'active')
                        <span class="badge badge-emerald rounded-pill px-3 py-1 font-medium">Active</span>
                    @else
                        <span class="badge badge-slate rounded-pill px-3 py-1 font-medium">Inactive</span>
                    @endif
                </td>
                <td class="text-xs text-slate-500 dark:text-slate-400">{{ $location->created_at?->format('M d, Y') }}</td>
                <td class="text-center pe-4">
                    @include('locations::partials.actions', ['location' => $location])
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-5 text-slate-400">
                    <i class="bi bi-geo-alt fs-2 d-block mb-2 opacity-50"></i>
                    No locations found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
