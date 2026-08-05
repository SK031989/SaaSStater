<?php

namespace Modules\Tenant\Services;

use Modules\Tenant\App\Models\Tenant;

class TenantService
{
    public function getAll()
    {
        return Tenant::with('domains')->latest()->paginate(10);
    }

    public function findById(int $id): Tenant
    {
        return Tenant::with('domains')->findOrFail($id);
    }

    public function create(array $data): Tenant
    {
        $tenant = Tenant::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'subdomain'    => $data['subdomain'],
            'company_name' => $data['company_name'] ?? $data['name'],
            'status'       => $data['status'] ?? 'active',
            'plan_id'      => $data['plan_id'] ?? 1,
            'onboarded_at' => now(),
        ]);

        if (!empty($data['custom_domain'])) {
            $tenant->domains()->create([
                'domain'     => $data['custom_domain'],
                'is_primary' => true,
            ]);
        }

        return $tenant;
    }

    public function update(Tenant $tenant, array $data): Tenant
    {
        $tenant->update([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'subdomain'    => $data['subdomain'],
            'company_name' => $data['company_name'] ?? $tenant->company_name,
            'status'       => $data['status'] ?? $tenant->status,
            'plan_id'      => $data['plan_id'] ?? $tenant->plan_id,
        ]);

        if (isset($data['custom_domain'])) {
            $tenant->domains()->delete();
            if (!empty($data['custom_domain'])) {
                $tenant->domains()->create([
                    'domain'     => $data['custom_domain'],
                    'is_primary' => true,
                ]);
            }
        }

        return $tenant;
    }

    public function delete(Tenant $tenant): bool
    {
        $tenant->domains()->delete();
        return $tenant->delete();
    }
}
