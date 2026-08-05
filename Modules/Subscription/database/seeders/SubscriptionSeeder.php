<?php

namespace Modules\Subscription\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Subscription\App\Models\SubscriptionPlan;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        SubscriptionPlan::firstOrCreate(
            ['slug' => 'free-starter'],
            [
                'name'          => 'Free Starter',
                'price_monthly' => 0.00,
                'price_yearly'  => 0.00,
                'max_users'     => 3,
                'is_popular'    => false,
                'status'        => 'active',
                'description'   => 'Ideal for small projects and individual trials.',
            ]
        );

        SubscriptionPlan::firstOrCreate(
            ['slug' => 'growth-pro'],
            [
                'name'          => 'Growth Pro',
                'price_monthly' => 29.00,
                'price_yearly'  => 290.00,
                'max_users'     => 25,
                'is_popular'    => true,
                'status'        => 'active',
                'description'   => 'Best for growing businesses requiring high limits and priority support.',
            ]
        );

        SubscriptionPlan::firstOrCreate(
            ['slug' => 'enterprise-scale'],
            [
                'name'          => 'Enterprise Scale',
                'price_monthly' => 99.00,
                'price_yearly'  => 990.00,
                'max_users'     => 500,
                'is_popular'    => false,
                'status'        => 'active',
                'description'   => 'Unlimited capabilities for large enterprise deployment.',
            ]
        );
    }
}
