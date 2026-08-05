<?php

namespace Modules\ApiKey\Services;

use Illuminate\Support\Str;
use Modules\ApiKey\App\Models\ApiKey;

class ApiKeyService
{
    public function getAll()
    {
        return ApiKey::with('tenant')->latest()->paginate(10);
    }

    public function findById(int $id): ApiKey
    {
        return ApiKey::with('tenant')->findOrFail($id);
    }

    public function create(array $data): ApiKey
    {
        return ApiKey::create([
            'tenant_id' => $data['tenant_id'] ?? 1,
            'name'      => $data['name'],
            'key'       => 'sk_live_' . Str::random(32),
            'status'    => $data['status'] ?? 'active',
        ]);
    }

    public function update(ApiKey $apiKey, array $data): ApiKey
    {
        $apiKey->update([
            'tenant_id' => $data['tenant_id'] ?? $apiKey->tenant_id,
            'name'      => $data['name'] ?? $apiKey->name,
            'status'    => $data['status'] ?? $apiKey->status,
        ]);

        return $apiKey;
    }

    public function delete(ApiKey $apiKey): bool
    {
        return $apiKey->delete();
    }
}
