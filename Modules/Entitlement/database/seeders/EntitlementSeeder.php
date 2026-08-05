<?php

namespace Modules\Entitlement\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Entitlement\App\Models\Entitlement;

class EntitlementSeeder extends Seeder
{
    public function run(): void
    {
        Entitlement::firstOrCreate(
            ['plan_id' => 1, 'feature_key' => 'max_storage'],
            [
                'feature_name' => 'Storage Quota',
                'limit_value'  => 5,
                'unit'         => 'GB',
                'is_unlimited' => false,
            ]
        );

        Entitlement::firstOrCreate(
            ['plan_id' => 2, 'feature_key' => 'max_storage'],
            [
                'feature_name' => 'Storage Quota',
                'limit_value'  => 50,
                'unit'         => 'GB',
                'is_unlimited' => false,
            ]
        );

        Entitlement::firstOrCreate(
            ['plan_id' => 3, 'feature_key' => 'max_storage'],
            [
                'feature_name' => 'Storage Quota',
                'limit_value'  => 0,
                'unit'         => 'GB',
                'is_unlimited' => true,
            ]
        );
    }
}
