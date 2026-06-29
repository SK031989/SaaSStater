<div class="d-flex justify-content-end gap-1">
    @can('invoices.view')
    <a href="{{ route('invoices.show', $item) }}"
       class="btn btn-sm btn-outline-info" title="View">
        <i class="bi bi-eye"></i>
    </a>
    @endcan

    @can('invoices.update')
    <a href="{{ route('invoices.edit', $item) }}"
       class="btn btn-sm btn-outline-primary" title="Edit">
        <i class="bi bi-pencil"></i>
    </a>
    @endcan

    @can('invoices.delete')
    <form action="{{ route('invoices.destroy', $item) }}" method="POST" class="d-inline"
          onsubmit="return confirm('Delete this record?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
            <i class="bi bi-trash"></i>
        </button>
    </form>
    @endcan
</div>