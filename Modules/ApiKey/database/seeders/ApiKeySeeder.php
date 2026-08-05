<?php

namespace Modules\ApiKey\database\seeders;

use Illuminate\Database\Seeder;
use Modules\ApiKey\App\Models\ApiKey;

class ApiKeySeeder extends Seeder
{
    public function run(): void
    {
        ApiKey::firstOrCreate(
            ['name' => 'Production Webhook Endpoint Key'],
            [
                'tenant_id'    => 1,
                'key'          => 'sk_live_demo_9876543210abcdefghijklmn',
                'status'       => 'active',
                'last_used_at' => now(),
            ]
        );

        ApiKey::firstOrCreate(
            ['name' => 'Stripe Checkout Integration Key'],
            [
                'tenant_id'    => 2,
                'key'          => 'sk_live_alpha_1234567890abcdefghijklm',
                'status'       => 'active',
                'last_used_at' => now(),
            ]
        );
    }
}
