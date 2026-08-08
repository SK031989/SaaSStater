<div class="dropdown">
    <button class="btn btn-light btn-sm border-0 rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
        <i class="bi bi-three-dots-vertical"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
        <li>
            <a class="dropdown-item py-2 rounded-2" href="{{ route('locations.show', $location->id) }}">
                <i class="bi bi-eye text-primary me-2"></i> View Details
            </a>
        </li>
        <li>
            <a class="dropdown-item py-2 rounded-2" href="{{ route('locations.edit', $location->id) }}">
                <i class="bi bi-pencil text-warning me-2"></i> Edit
            </a>
        </li>
        <li><hr class="dropdown-divider my-1"></li>
        <li>
            <form action="{{ route('locations.destroy', $location->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete location {{ $location->name }}?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item py-2 rounded-2 text-danger">
                    <i class="bi bi-trash me-2"></i> Delete
                </button>
            </form>
        </li>
    </ul>
</div>
