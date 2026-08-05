<?php

namespace Modules\Support\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Support\App\Models\Ticket;

class SupportSeeder extends Seeder
{
    public function run(): void
    {
        Ticket::firstOrCreate(
            ['ticket_number' => 'TICK-984321'],
            [
                'tenant_id' => 2,
                'user_id'   => 2,
                'subject'   => 'Custom Subdomain SSL Configuration Assistance',
                'priority'  => 'high',
                'status'    => 'open',
                'message'   => 'Need help setting up custom domain SSL certificate for alpha.com.',
            ]
        );

        Ticket::firstOrCreate(
            ['ticket_number' => 'TICK-123456'],
            [
                'tenant_id' => 3,
                'user_id'   => 4,
                'subject'   => 'Billing Invoice Receipt Download Query',
                'priority'  => 'low',
                'status'    => 'resolved',
                'message'   => 'Where can I download past PDF billing invoices?',
            ]
        );
    }
}
