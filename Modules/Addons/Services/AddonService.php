<?php

namespace Modules\Addons\Services;

use Illuminate\Support\Str;
use Modules\Addons\App\Models\Addon;

class AddonService
{
    public function getAll()
    {
        return Addon::latest()->paginate(10);
    }

    public function findById(int $id): Addon
    {
        return Addon::findOrFail($id);
    }

    public function create(array $data): Addon
    {
        return Addon::create([
            'name'          => $data['name'],
            'code'          => Str::slug($data['code'] ?? $data['name']),
            'price_monthly' => $data['price_monthly'] ?? 0,
            'status'        => $data['status'] ?? 'active',
            'description'   => $data['description'] ?? null,
        ]);
    }

    public function update(Addon $addon, array $data): Addon
    {
        $addon->update([
            'name'          => $data['name'],
            'code'          => Str::slug($data['code'] ?? $data['name']),
            'price_monthly' => $data['price_monthly'] ?? $addon->price_monthly,
            'status'        => $data['status'] ?? $addon->status,
            'description'   => $data['description'] ?? $addon->description,
        ]);

        return $addon;
    }

    public function delete(Addon $addon): bool
    {
        return $addon->delete();
    }
}
