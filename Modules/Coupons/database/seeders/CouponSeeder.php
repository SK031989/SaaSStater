<?php

namespace Modules\Coupons\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Coupons\App\Models\Coupon;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        Coupon::firstOrCreate(
            ['code' => 'WELCOME20'],
            [
                'type'       => 'percentage',
                'value'      => 20.00,
                'max_uses'   => 500,
                'used_count' => 12,
                'status'     => 'active',
                'expires_at' => now()->addMonths(6),
            ]
        );

        Coupon::firstOrCreate(
            ['code' => 'LAUNCH50OFF'],
            [
                'type'       => 'fixed',
                'value'      => 50.00,
                'max_uses'   => 50,
                'used_count' => 5,
                'status'     => 'active',
                'expires_at' => now()->addMonth(),
            ]
        );
    }
}
