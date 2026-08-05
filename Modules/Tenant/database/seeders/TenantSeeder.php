<?php

namespace Modules\Tenant\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Tenant\App\Models\Tenant;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        // 1. System Main Tenant (Default System HQ)
        $systemTenant = Tenant::firstOrCreate(
            ['subdomain' => 'main'],
            [
                'name'         => 'System Main HQ',
                'email'        => 'superadmin@saas.local',
                'company_name' => 'SaaSStater Platform HQ',
                'status'       => 'active',
                'plan_id'      => 3, // Enterprise
                'onboarded_at' => now(),
            ]
        );

        $systemTenant->domains()->firstOrCreate([
            'domain'     => 'main.saas.local',
            'is_primary' => true,
        ]);

        // 2. Tenant Alpha
        $tenant1 = Tenant::firstOrCreate(
            ['subdomain' => 'alpha'],
            [
                'name'         => 'Alpha Corp',
                'email'        => 'admin@alphacorp.com',
                'company_name' => 'Alpha Corporation',
                'status'       => 'active',
                'plan_id'      => 2, // Growth
                'onboarded_at' => now(),
            ]
        );

        $tenant1->domains()->firstOrCreate([
            'domain'     => 'alpha.saas.local',
            'is_primary' => true,
        ]);

        // 3. Tenant Beta
        $tenant2 = Tenant::firstOrCreate(
            ['subdomain' => 'beta'],
            [
                'name'         => 'Beta Solutions',
                'email'        => 'contact@betasolutions.com',
                'company_name' => 'Beta Solutions LLC',
                'status'       => 'active',
                'plan_id'      => 1, // Free
                'onboarded_at' => now(),
            ]
        );

        $tenant2->domains()->firstOrCreate([
            'domain'     => 'beta.saas.local',
            'is_primary' => true,
        ]);
    }
}
