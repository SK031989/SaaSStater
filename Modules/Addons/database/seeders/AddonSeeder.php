<?php

namespace Modules\Addons\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Addons\App\Models\Addon;

class AddonSeeder extends Seeder
{
    public function run(): void
    {
        Addon::firstOrCreate(
            ['code' => 'custom-domain-ssl'],
            [
                'name'          => 'Custom Subdomain SSL',
                'price_monthly' => 10.00,
                'status'        => 'active',
                'description'   => 'Dedicated SSL cert & custom CNAME mapping.',
            ]
        );

        Addon::firstOrCreate(
            ['code' => 'advanced-audit-logs'],
            [
                'name'          => 'Advanced Audit & Security Logs',
                'price_monthly' => 15.00,
                'status'        => 'active',
                'description'   => '1-year retention of user actions & IP audit trails.',
            ]
        );
    }
}
