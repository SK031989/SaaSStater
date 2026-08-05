<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Execution order matters:
     *  1. SuperAdminTenantSeeder  — Plans → System Tenant → Roles/Perms → Super Admin → Demo Tenants → Users
     *  2. Module seeders          — Entitlements, Billing samples, Addons, Coupons, etc.
     *  3. Platform tool seeders   — Activity logs, API Keys, Support tickets
     */
    public function run(): void
    {
        // ── Step 1: Core foundation (Tenants + Super Admin + Roles) ──
        $this->call(SuperAdminTenantSeeder::class);

        // ── Step 2: SaaS module sample data ──
        $this->call([
            \Modules\Entitlement\database\seeders\EntitlementSeeder::class,
            \Modules\Billing\database\seeders\BillingSeeder::class,
            \Modules\Addons\database\seeders\AddonSeeder::class,
            \Modules\Coupons\database\seeders\CouponSeeder::class,
            \Modules\RolePermission\database\seeders\RolePermissionSeeder::class,
        ]);

        // ── Step 3: Platform tool sample data ──
        $this->call([
            \Modules\Notification\database\seeders\NotificationSeeder::class,
            \Modules\ApiKey\database\seeders\ApiKeySeeder::class,
            \Modules\Support\database\seeders\SupportSeeder::class,
        ]);
    }
}
