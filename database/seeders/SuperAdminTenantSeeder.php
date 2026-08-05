<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Modules\Auth\App\Enums\UserStatusEnum;
use Modules\Auth\App\Models\User;
use Modules\Tenant\App\Models\Tenant;
use Modules\Tenant\App\Models\Domain;
use Modules\Subscription\App\Models\SubscriptionPlan;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * SuperAdminTenantSeeder
 *
 * Proper ordered seeder that:
 *  1. Flushes Spatie permission cache
 *  2. Seeds subscription plans  (needed for tenant plan_id FK)
 *  3. Seeds the system tenant   (platform HQ — tenant_id = 1)
 *  4. Seeds Spatie roles & core permissions
 *  5. Seeds the Super Admin user (linked to system tenant, role = Super Admin)
 *  6. Seeds two demo client tenants
 *  7. Seeds tenant admin users for those tenants
 */
class SuperAdminTenantSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────────────────────────────────────────────────────────
        // 0. Flush Spatie permission cache
        // ─────────────────────────────────────────────────────────────
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('');
        $this->command->info('╔══════════════════════════════════════════════════╗');
        $this->command->info('║     SaaSStater — Super Admin & Tenant Seeder     ║');
        $this->command->info('╚══════════════════════════════════════════════════╝');
        $this->command->info('');

        // ─────────────────────────────────────────────────────────────
        // 1. SUBSCRIPTION PLANS  (required before tenants)
        // ─────────────────────────────────────────────────────────────
        $this->command->info('▶  [1/6] Seeding subscription plans...');

        $freePlan = SubscriptionPlan::firstOrCreate(
            ['slug' => 'free-starter'],
            [
                'name'          => 'Free Starter',
                'description'   => 'Ideal for small projects and individual trials.',
                'price_monthly' => 0.00,
                'price_yearly'  => 0.00,
                'max_users'     => 3,
                'is_popular'    => false,
                'status'        => 'active',
            ]
        );

        $growthPlan = SubscriptionPlan::firstOrCreate(
            ['slug' => 'growth-pro'],
            [
                'name'          => 'Growth Pro',
                'description'   => 'Best for growing businesses requiring high limits and priority support.',
                'price_monthly' => 29.00,
                'price_yearly'  => 290.00,
                'max_users'     => 25,
                'is_popular'    => true,
                'status'        => 'active',
            ]
        );

        $enterprisePlan = SubscriptionPlan::firstOrCreate(
            ['slug' => 'enterprise-scale'],
            [
                'name'          => 'Enterprise Scale',
                'description'   => 'Unlimited capabilities for large enterprise deployment.',
                'price_monthly' => 99.00,
                'price_yearly'  => 990.00,
                'max_users'     => 500,
                'is_popular'    => false,
                'status'        => 'active',
            ]
        );

        $this->command->info("   ✔  Plans: Free Starter (ID:{$freePlan->id}), Growth Pro (ID:{$growthPlan->id}), Enterprise (ID:{$enterprisePlan->id})");

        // ─────────────────────────────────────────────────────────────
        // 2. SYSTEM TENANT (Platform HQ — always ID 1)
        // ─────────────────────────────────────────────────────────────
        $this->command->info('');
        $this->command->info('▶  [2/6] Seeding System Tenant (Platform HQ)...');

        $systemTenant = Tenant::firstOrCreate(
            ['subdomain' => 'main'],
            [
                'name'         => 'SaaSStater Platform HQ',
                'email'        => 'admin@saas.local',
                'company_name' => 'SaaSStater Inc.',
                'status'       => 'active',
                'plan_id'      => $enterprisePlan->id,
                'onboarded_at' => now(),
            ]
        );

        Domain::firstOrCreate(
            ['domain' => 'main.saas.local'],
            [
                'tenant_id'  => $systemTenant->id,
                'is_primary' => true,
            ]
        );

        $this->command->info("   ✔  System Tenant  →  '{$systemTenant->name}'  (ID:{$systemTenant->id}, subdomain: main)");

        // ─────────────────────────────────────────────────────────────
        // 3. SPATIE ROLES & PERMISSIONS
        // ─────────────────────────────────────────────────────────────
        $this->command->info('');
        $this->command->info('▶  [3/6] Seeding Spatie Roles & Permissions...');

        // Core roles
        $superAdminRole  = Role::firstOrCreate(['name' => 'Super Admin',   'guard_name' => 'web']);
        $tenantAdminRole = Role::firstOrCreate(['name' => 'Tenant Admin',  'guard_name' => 'web']);
        $userRole        = Role::firstOrCreate(['name' => 'User',          'guard_name' => 'web']);

        // Core permissions matrix
        $modules = [
            'tenants', 'subscriptions', 'entitlements', 'billings',
            'addons', 'coupons', 'rolepermissions', 'notifications',
            'apikeys', 'tickets', 'users', 'products',
        ];

        foreach ($modules as $module) {
            foreach (['view', 'create', 'edit', 'delete'] as $action) {
                Permission::firstOrCreate([
                    'name'       => "{$module}.{$action}",
                    'guard_name' => 'web',
                ]);
            }
        }

        // Give Super Admin ALL permissions (wildcard via syncPermissions)
        $superAdminRole->syncPermissions(Permission::all());

        // Tenant Admin gets view + create + edit on their own data
        $tenantAdminPerms = Permission::whereIn('name', collect($modules)->flatMap(fn($m) => [
            "{$m}.view", "{$m}.create", "{$m}.edit",
        ])->toArray())->get();
        $tenantAdminRole->syncPermissions($tenantAdminPerms);

        // Regular User gets view only
        $userPerms = Permission::where('name', 'like', '%.view')->get();
        $userRole->syncPermissions($userPerms);

        $this->command->info("   ✔  Roles: Super Admin, Tenant Admin, User");
        $this->command->info("   ✔  Permissions: " . Permission::count() . " total across " . count($modules) . " modules");

        // ─────────────────────────────────────────────────────────────
        // 4. SUPER ADMIN USER
        // ─────────────────────────────────────────────────────────────
        $this->command->info('');
        $this->command->info('▶  [4/6] Seeding Super Admin User...');

        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@saas.local'],
            [
                'tenant_id'         => $systemTenant->id,
                'name'              => 'SaaS Super Admin',
                'password'          => Hash::make('AdminPass123!'),
                'phone'             => '+1234567890',
                'status'            => UserStatusEnum::Active,
                'is_admin'          => true,
                'email_verified_at' => now(),
            ]
        );

        // Force Super Admin flag and tenant link in case record already existed
        $superAdmin->forceFill([
            'tenant_id' => $systemTenant->id,
            'is_admin'  => true,
        ])->save();

        $superAdmin->syncRoles([$superAdminRole]);

        $this->command->info("   ✔  Super Admin  →  '{$superAdmin->name}'");
        $this->command->info("     Email    : admin@saas.local");
        $this->command->info("     Password : AdminPass123!");
        $this->command->info("     Tenant   : {$systemTenant->name} (ID:{$systemTenant->id})");
        $this->command->info("     Role     : Super Admin (full permissions)");

        // ─────────────────────────────────────────────────────────────
        // 5. DEMO CLIENT TENANTS
        // ─────────────────────────────────────────────────────────────
        $this->command->info('');
        $this->command->info('▶  [5/6] Seeding demo client tenants...');

        // Tenant: Alpha Corp
        $alphaTenant = Tenant::firstOrCreate(
            ['subdomain' => 'alpha'],
            [
                'name'         => 'Alpha Corp',
                'email'        => 'admin@alphacorp.com',
                'company_name' => 'Alpha Corporation Pvt. Ltd.',
                'status'       => 'active',
                'plan_id'      => $growthPlan->id,
                'onboarded_at' => now(),
            ]
        );
        Domain::firstOrCreate(
            ['domain' => 'alpha.saas.local'],
            ['tenant_id' => $alphaTenant->id, 'is_primary' => true]
        );

        // Tenant: Beta Solutions
        $betaTenant = Tenant::firstOrCreate(
            ['subdomain' => 'beta'],
            [
                'name'         => 'Beta Solutions',
                'email'        => 'contact@betasolutions.com',
                'company_name' => 'Beta Solutions LLC',
                'status'       => 'active',
                'plan_id'      => $freePlan->id,
                'onboarded_at' => now(),
            ]
        );
        Domain::firstOrCreate(
            ['domain' => 'beta.saas.local'],
            ['tenant_id' => $betaTenant->id, 'is_primary' => true]
        );

        // Tenant: Gamma Tech (trial/pending)
        $gammaTenant = Tenant::firstOrCreate(
            ['subdomain' => 'gamma'],
            [
                'name'         => 'Gamma Tech',
                'email'        => 'hello@gammatech.io',
                'company_name' => 'Gamma Technologies Inc.',
                'status'       => 'trial',
                'plan_id'      => $freePlan->id,
                'onboarded_at' => null,
            ]
        );
        Domain::firstOrCreate(
            ['domain' => 'gamma.saas.local'],
            ['tenant_id' => $gammaTenant->id, 'is_primary' => true]
        );

        $this->command->info("   ✔  Alpha Corp     (ID:{$alphaTenant->id}, plan: Growth Pro)");
        $this->command->info("   ✔  Beta Solutions  (ID:{$betaTenant->id}, plan: Free Starter)");
        $this->command->info("   ✔  Gamma Tech      (ID:{$gammaTenant->id}, status: trial)");

        // ─────────────────────────────────────────────────────────────
        // 6. TENANT USERS
        // ─────────────────────────────────────────────────────────────
        $this->command->info('');
        $this->command->info('▶  [6/6] Seeding Tenant Admin & Demo Users...');

        // Alpha Tenant Admin
        $alphaAdmin = User::firstOrCreate(
            ['email' => 'tenant1@saas.local'],
            [
                'tenant_id'         => $alphaTenant->id,
                'name'              => 'Alpha Admin',
                'password'          => Hash::make('TenantPass123!'),
                'phone'             => '+1987654321',
                'status'            => UserStatusEnum::Active,
                'is_admin'          => false,
                'email_verified_at' => now(),
            ]
        );
        $alphaAdmin->forceFill(['tenant_id' => $alphaTenant->id])->save();
        $alphaAdmin->syncRoles([$tenantAdminRole]);

        // Alpha Regular User
        $alphaUser = User::firstOrCreate(
            ['email' => 'user@saas.local'],
            [
                'tenant_id'         => $alphaTenant->id,
                'name'              => 'Alpha Demo User',
                'password'          => Hash::make('UserPass123!'),
                'phone'             => '+1555555555',
                'status'            => UserStatusEnum::Active,
                'is_admin'          => false,
                'email_verified_at' => now(),
            ]
        );
        $alphaUser->forceFill(['tenant_id' => $alphaTenant->id])->save();
        $alphaUser->syncRoles([$userRole]);

        // Beta Tenant Admin
        $betaAdmin = User::firstOrCreate(
            ['email' => 'tenant2@saas.local'],
            [
                'tenant_id'         => $betaTenant->id,
                'name'              => 'Beta Admin',
                'password'          => Hash::make('TenantPass123!'),
                'phone'             => '+1444444444',
                'status'            => UserStatusEnum::Active,
                'is_admin'          => false,
                'email_verified_at' => now(),
            ]
        );
        $betaAdmin->forceFill(['tenant_id' => $betaTenant->id])->save();
        $betaAdmin->syncRoles([$tenantAdminRole]);

        // Pending unverified user
        $pendingUser = User::firstOrCreate(
            ['email' => 'pending@saas.local'],
            [
                'tenant_id'         => $gammaTenant->id,
                'name'              => 'Gamma Pending User',
                'password'          => Hash::make('UserPass123!'),
                'status'            => UserStatusEnum::Pending,
                'is_admin'          => false,
                'email_verified_at' => null,
            ]
        );
        $pendingUser->forceFill(['tenant_id' => $gammaTenant->id])->save();
        $pendingUser->syncRoles([$userRole]);

        $this->command->info("   ✔  tenant1@saas.local  → Alpha Admin   (Tenant Admin role)");
        $this->command->info("   ✔  user@saas.local     → Alpha Demo User  (User role)");
        $this->command->info("   ✔  tenant2@saas.local  → Beta Admin    (Tenant Admin role)");
        $this->command->info("   ✔  pending@saas.local  → Gamma Pending (unverified)");

        // ─────────────────────────────────────────────────────────────
        // SUMMARY
        // ─────────────────────────────────────────────────────────────
        $this->command->info('');
        $this->command->info('╔═══════════════════════════════════════════════════════════╗');
        $this->command->info('║              ✅  Seeding Complete — Login Credentials      ║');
        $this->command->info('╠═══════════════════════════════════════════════════════════╣');
        $this->command->info('║  Role         │ Email                 │ Password           ║');
        $this->command->info('║─────────────────────────────────────────────────────────║');
        $this->command->info('║  Super Admin  │ admin@saas.local      │ AdminPass123!      ║');
        $this->command->info('║  Tenant Admin │ tenant1@saas.local    │ TenantPass123!     ║');
        $this->command->info('║  Tenant Admin │ tenant2@saas.local    │ TenantPass123!     ║');
        $this->command->info('║  User         │ user@saas.local       │ UserPass123!       ║');
        $this->command->info('║  Pending      │ pending@saas.local    │ UserPass123!       ║');
        $this->command->info('╚═══════════════════════════════════════════════════════════╝');
        $this->command->info('');
    }
}
