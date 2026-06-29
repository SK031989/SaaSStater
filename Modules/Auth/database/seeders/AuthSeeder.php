<?php

namespace Modules\Auth\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\App\Enums\UserStatusEnum;
use Modules\Auth\App\Models\User;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding Auth users...');

        // 1. Super Admin (Global Admin)
        User::firstOrCreate(
            ['email' => 'admin@saas.local'],
            [
                'tenant_id'          => 1,
                'name'               => 'SaaS Super Admin',
                'password'           => Hash::make('AdminPass123!'),
                'phone'              => '+1234567890',
                'status'             => UserStatusEnum::Active,
                'is_admin'           => true,
                'email_verified_at'  => now(),
            ]
        );

        // 2. Tenant 1 Admin
        User::firstOrCreate(
            ['email' => 'tenant1@saas.local'],
            [
                'tenant_id'          => 1,
                'name'               => 'Tenant One Admin',
                'password'           => Hash::make('TenantPass123!'),
                'phone'              => '+1987654321',
                'status'             => UserStatusEnum::Active,
                'is_admin'           => false,
                'email_verified_at'  => now(),
            ]
        );

        // 3. Demo Tenant User
        User::firstOrCreate(
            ['email' => 'user@saas.local'],
            [
                'tenant_id'          => 1,
                'name'               => 'Demo User',
                'password'           => Hash::make('UserPass123!'),
                'phone'              => '+1555555555',
                'status'             => UserStatusEnum::Active,
                'is_admin'           => false,
                'email_verified_at'  => now(),
            ]
        );

        // 4. Pending Verification User
        User::firstOrCreate(
            ['email' => 'pending@saas.local'],
            [
                'tenant_id'          => 1,
                'name'               => 'Pending User',
                'password'           => Hash::make('UserPass123!'),
                'status'             => UserStatusEnum::Pending,
                'is_admin'           => false,
                'email_verified_at'  => null,
            ]
        );

        $this->command->info('Auth users seeded successfully!');
    }
}
