<?php

namespace Modules\Notification\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Notification\App\Models\ActivityLog;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        ActivityLog::firstOrCreate(
            ['action' => 'SuperAdmin System Initialization'],
            [
                'user_id'     => 1,
                'tenant_id'   => 1,
                'log_type'    => 'info',
                'description' => 'SaaSStater system started and initialized successfully.',
                'ip_address'  => '127.0.0.1',
            ]
        );

        ActivityLog::firstOrCreate(
            ['action' => 'Tenant Onboarding Completed'],
            [
                'user_id'     => 2,
                'tenant_id'   => 2,
                'log_type'    => 'success',
                'description' => 'Alpha Corp registered and completed onboarding.',
                'ip_address'  => '127.0.0.1',
            ]
        );
    }
}
