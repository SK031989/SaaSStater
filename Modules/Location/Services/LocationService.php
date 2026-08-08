<?php

namespace Modules\Location\Services;

use Modules\Location\App\Models\Location;
use Illuminate\Pagination\LengthAwarePaginator;

class LocationService
{
    /**
     * Get paginated locations with optional search and filters.
     */
    public function getPaginatedLocations(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Location::with('tenant')->latest();

        // Tenant Scoping
        if (auth()->check() && !auth()->user()->is_admin) {
            $query->forTenant(auth()->user()->tenant_id);
        } elseif (!empty($filters['tenant_id'])) {
            $query->forTenant($filters['tenant_id']);
        }

        // Search Filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Status Filter
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Primary Filter
        if (isset($filters['is_primary']) && $filters['is_primary'] !== '') {
            $query->where('is_primary', (bool) $filters['is_primary']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Create a new location.
     */
    public function createLocation(array $data): Location
    {
        if (auth()->check() && !auth()->user()->is_admin && empty($data['tenant_id'])) {
            $data['tenant_id'] = auth()->user()->tenant_id;
        }

        // If this location is marked primary, reset existing primary flags for the tenant
        if (!empty($data['is_primary'])) {
            $this->resetPrimaryFlag($data['tenant_id'] ?? null);
        }

        return Location::create($data);
    }

    /**
     * Update an existing location.
     */
    public function updateLocation(Location $location, array $data): Location
    {
        if (!empty($data['is_primary']) && !$location->is_primary) {
            $this->resetPrimaryFlag($location->tenant_id, $location->id);
        }

        $location->update($data);
        return $location->fresh();
    }

    /**
     * Delete a location.
     */
    public function deleteLocation(Location $location): bool
    {
        return $location->delete();
    }

    /**
     * Toggle location status.
     */
    public function toggleStatus(Location $location): Location
    {
        $location->status = $location->status === 'active' ? 'inactive' : 'active';
        $location->save();

        return $location;
    }

    /**
     * Reset primary flag for other locations in the tenant scope.
     */
    protected function resetPrimaryFlag(?int $tenantId, ?int $exceptId = null): void
    {
        $query = Location::query();
        if ($tenantId) {
            $query->where('tenant_id', $tenantId);
        } else {
            $query->whereNull('tenant_id');
        }

        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        $query->update(['is_primary' => false]);
    }
}
