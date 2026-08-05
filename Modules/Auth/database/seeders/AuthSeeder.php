<?php

namespace Modules\Auth\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\App\Enums\UserStatusEnum;
use Modules\Auth\App\Models\User;
use Modules\Tenant\App\Models\Tenant;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding Core Spatie Roles & Super Admin User with Tenants...');

        // 1. Create Core Spatie Roles
        $superAdminRole  = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $tenantAdminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Tenant Admin', 'guard_name' => 'web']);
        $userRole        = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'User', 'guard_name' => 'web']);

        // Fetch System Main Tenant (Default to ID 1)
        $mainTenant  = Tenant::where('subdomain', 'main')->first();
        $alphaTenant = Tenant::where('subdomain', 'alpha')->first();
        $betaTenant  = Tenant::where('subdomain', 'beta')->first();

        $mainTenantId  = $mainTenant?->id ?? 1;
        $alphaTenantId = $alphaTenant?->id ?? 2;
        $betaTenantId  = $betaTenant?->id ?? 3;

        // 2. Global Super Admin User
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@saas.local'],
            [
                'tenant_id'          => $mainTenantId,
                'name'               => 'SaaS Super Admin',
                'password'           => Hash::make('AdminPass123!'),
                'phone'              => '+1234567890',
                'status'             => UserStatusEnum::Active,
                'is_admin'           => true,
                'email_verified_at'  => now(),
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        // 3. Alpha Tenant Admin
        $alphaTenantAdmin = User::firstOrCreate(
            ['email' => 'tenant1@saas.local'],
            [
                'tenant_id'          => $alphaTenantId,
                'name'               => 'Alpha Corp Admin',
                'password'           => Hash::make('TenantPass123!'),
                'phone'              => '+1987654321',
                'status'             => UserStatusEnum::Active,
                'is_admin'           => false,
                'email_verified_at'  => now(),
            ]
        );
        $alphaTenantAdmin->assignRole($tenantAdminRole);

        // 4. Alpha Demo User
        $demoUser = User::firstOrCreate(
            ['email' => 'user@saas.local'],
            [
                'tenant_id'          => $alphaTenantId,
                'name'               => 'Alpha Demo User',
                'password'           => Hash::make('UserPass123!'),
                'phone'              => '+1555555555',
                'status'             => UserStatusEnum::Active,
                'is_admin'           => false,
                'email_verified_at'  => now(),
            ]
        );
        $demoUser->assignRole($userRole);

        // 5. Beta Tenant Admin
        $betaTenantAdmin = User::firstOrCreate(
            ['email' => 'tenant2@saas.local'],
            [
                'tenant_id'          => $betaTenantId,
                'name'               => 'Beta Solutions Admin',
                'password'           => Hash::make('TenantPass123!'),
                'phone'              => '+1444444444',
                'status'             => UserStatusEnum::Active,
                'is_admin'           => false,
                'email_verified_at'  => now(),
            ]
        );
        $betaTenantAdmin->assignRole($tenantAdminRole);

        // 6. Pending Verification User
        $pendingUser = User::firstOrCreate(
            ['email' => 'pending@saas.local'],
            [
                'tenant_id'          => $alphaTenantId,
                'name'               => 'Pending User',
                'password'           => Hash::make('UserPass123!'),
                'status'             => UserStatusEnum::Pending,
                'is_admin'           => false,
                'email_verified_at'  => null,
            ]
        );
        $pendingUser->assignRole($userRole);

        $this->command->info('Super Admin and Tenant users seeded successfully!');
    }
}
