<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>#</th>

                <th>Status</th>
                <th>Created</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $item)
            <tr>
                <td class="text-muted small">{{ $item->id }}</td>

                <td>
                    <span class="badge bg-{{ $item->status === 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>
                <td class="text-muted small">{{ $item->created_at?->format('d M Y') }}</td>
                <td class="text-end">
                    @include('invoices::partials.actions', ['item' => $item])
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