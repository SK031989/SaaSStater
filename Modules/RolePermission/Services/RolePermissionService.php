<?php

namespace Modules\RolePermission\Services;

use Modules\RolePermission\App\Models\RolePermission;
use Spatie\Permission\Models\Role;

class RolePermissionService
{
    public function getAll()
    {
        return RolePermission::latest()->paginate(10);
    }

    public function findById(int $id): RolePermission
    {
        return RolePermission::findOrFail($id);
    }

    public function create(array $data): RolePermission
    {
        $rolePermission = RolePermission::create([
            'role_name'   => $data['role_name'],
            'guard_name'  => $data['guard_name'] ?? 'web',
            'description' => $data['description'] ?? null,
            'is_system'   => isset($data['is_system']) ? (bool)$data['is_system'] : false,
        ]);

        Role::firstOrCreate([
            'name'       => $data['role_name'],
            'guard_name' => $data['guard_name'] ?? 'web',
        ]);

        return $rolePermission;
    }

    public function update(RolePermission $rolePermission, array $data): RolePermission
    {
        $rolePermission->update([
            'role_name'   => $data['role_name'],
            'guard_name'  => $data['guard_name'] ?? $rolePermission->guard_name,
            'description' => $data['description'] ?? $rolePermission->description,
            'is_system'   => isset($data['is_system']) ? (bool)$data['is_system'] : false,
        ]);

        return $rolePermission;
    }

    public function delete(RolePermission $rolePermission): bool
    {
        return $rolePermission->delete();
    }
}
