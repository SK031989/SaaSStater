<?php

namespace Modules\RolePermission\database\seeders;

use Illuminate\Database\Seeder;
use Modules\RolePermission\App\Models\RolePermission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        RolePermission::firstOrCreate(
            ['role_name' => 'Super Admin'],
            [
                'guard_name'  => 'web',
                'description' => 'Global Super Administrator with full platform control.',
                'is_system'   => true,
            ]
        );

        RolePermission::firstOrCreate(
            ['role_name' => 'Tenant Admin'],
            [
                'guard_name'  => 'web',
                'description' => 'Organization Administrator managing tenant team members.',
                'is_system'   => true,
            ]
        );

        RolePermission::firstOrCreate(
            ['role_name' => 'User'],
            [
                'guard_name'  => 'web',
                'description' => 'Standard user account.',
                'is_system'   => true,
            ]
        );
    }
}
