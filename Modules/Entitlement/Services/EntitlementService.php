<?php

namespace Modules\Entitlement\Services;

use Modules\Entitlement\App\Models\Entitlement;

class EntitlementService
{
    public function getAll()
    {
        return Entitlement::with('plan')->latest()->paginate(10);
    }

    public function findById(int $id): Entitlement
    {
        return Entitlement::with('plan')->findOrFail($id);
    }

    public function create(array $data): Entitlement
    {
        return Entitlement::create([
            'plan_id'      => $data['plan_id'],
            'feature_key'  => $data['feature_key'],
            'feature_name' => $data['feature_name'] ?? ucfirst(str_replace('_', ' ', $data['feature_key'])),
            'limit_value'  => $data['limit_value'] ?? 0,
            'unit'         => $data['unit'] ?? 'Count',
            'is_unlimited' => isset($data['is_unlimited']) ? (bool)$data['is_unlimited'] : false,
        ]);
    }

    public function update(Entitlement $entitlement, array $data): Entitlement
    {
        $entitlement->update([
            'plan_id'      => $data['plan_id'],
            'feature_key'  => $data['feature_key'],
            'feature_name' => $data['feature_name'] ?? $entitlement->feature_name,
            'limit_value'  => $data['limit_value'] ?? $entitlement->limit_value,
            'unit'         => $data['unit'] ?? $entitlement->unit,
            'is_unlimited' => isset($data['is_unlimited']) ? (bool)$data['is_unlimited'] : false,
        ]);

        return $entitlement;
    }

    public function delete(Entitlement $entitlement): bool
    {
        return $entitlement->delete();
    }
}
