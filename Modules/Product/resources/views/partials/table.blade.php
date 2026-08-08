<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Description</th>
                <th>Price</th>
                <th>Status</th>
                <th>Created</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $item)
            <tr>
                <td class="text-muted small">{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->sku }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->price }}</td>
                <td>
                    @if($item->status === 'active')
                        <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-300 dark:border-emerald-500/30 rounded-pill px-3 py-1 font-medium">Active</span>
                    @else
                        <span class="badge bg-slate-100 text-slate-700 border border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 rounded-pill px-3 py-1 font-medium">Inactive</span>
                    @endif
                </td>
                <td class="text-muted small">{{ $item->created_at?->format('d M Y') }}</td>
                <td class="text-end">
                    @include('products::partials.actions', ['item' => $item])
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="99" class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                    No records found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>