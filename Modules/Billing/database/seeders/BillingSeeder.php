<?php

namespace Modules\Billing\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Billing\App\Models\Invoice;

class BillingSeeder extends Seeder
{
    public function run(): void
    {
        Invoice::firstOrCreate(
            ['invoice_number' => 'INV-20260801-01'],
            [
                'tenant_id' => 1,
                'amount'    => 29.00,
                'currency'  => 'USD',
                'status'    => 'paid',
                'due_date'  => now()->addDays(7),
                'paid_at'   => now(),
            ]
        );

        Invoice::firstOrCreate(
            ['invoice_number' => 'INV-20260801-02'],
            [
                'tenant_id' => 2,
                'amount'    => 0.00,
                'currency'  => 'USD',
                'status'    => 'paid',
                'due_date'  => now()->addDays(14),
                'paid_at'   => now(),
            ]
        );
    }
}
