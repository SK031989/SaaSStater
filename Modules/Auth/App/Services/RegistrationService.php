<?php

namespace Modules\Auth\App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\App\Enums\UserStatusEnum;
use Modules\Auth\App\Events\UserRegistered;
use Modules\Auth\App\Models\LoginActivity;
use Modules\Auth\App\Models\User;
use Modules\Auth\App\Repositories\UserRepository;

class RegistrationService
{
    public function __construct(protected UserRepository $userRepo) {}

    /**
     * Register a new user for the SaaS platform.
     * Creates user + optionally creates tenant.
     */
    public function register(array $data): User
    {
        return DB::transaction(function () use ($data) {

            // Determine tenant_id
            $tenantId = $data['tenant_id'] ?? $this->resolveTenantId($data);

            // Set initial status
            $status = config('auth-module.registration.email_verification', true)
                ? UserStatusEnum::Pending
                : UserStatusEnum::Active;

            $user = $this->userRepo->create([
                'tenant_id'  => $tenantId,
                'name'       => $data['name'],
                'email'      => $data['email'],
                'password'   => Hash::make($data['password']),
                'phone'      => $data['phone'] ?? null,
                'status'     => $status,
                'is_admin'   => false,
            ]);

            // Log activity
            LoginActivity::record('register', 'success', $user->id, $tenantId);

            // Fire event — triggers welcome email + (optionally) tenant creation
            Event::dispatch(new UserRegistered($user));

            return $user;
        });
    }

    /**
     * Complete Public Tenant Onboarding & Checkout Registration Flow.
     */
    public function registerTenantCheckout(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $plan = \Modules\Subscription\App\Models\SubscriptionPlan::findOrFail($data['plan_id']);
            $gateway = \Modules\Payment\App\Models\PaymentGateway::findOrFail($data['gateway_id']);
            $interval = $data['billing_interval'] ?? 'monthly';

            // Base price + Addons calculation
            $baseAmount = $interval === 'yearly' ? ($plan->price * 10) : $plan->price;
            $addonsTotal = 0;
            if (!empty($data['addons']) && is_array($data['addons'])) {
                $addonsTotal = \Modules\Addons\App\Models\Addon::whereIn('id', $data['addons'])->sum('price');
                if ($interval === 'yearly') {
                    $addonsTotal = $addonsTotal * 10;
                }
            }

            // Coupon discount calculation
            $couponCode = strtoupper(trim($data['coupon_code'] ?? ''));
            $discount = 0;
            if ($couponCode === 'SAVE20' || $couponCode === 'WELCOME20') {
                $discount = ($baseAmount + $addonsTotal) * 0.20;
            } elseif ($couponCode === 'HALFOFF' || $couponCode === 'SAAS50') {
                $discount = ($baseAmount + $addonsTotal) * 0.50;
            }

            $finalAmount = max(0, ($baseAmount + $addonsTotal) - $discount);

            // 1. Create Tenant Organization
            $subdomain = \Illuminate\Support\Str::slug($data['subdomain']);
            $tenant = \Modules\Tenant\App\Models\Tenant::create([
                'name'      => $data['company_name'],
                'subdomain' => $subdomain,
                'email'     => $data['email'],
                'plan_id'   => $plan->id,
                'status'    => 'active',
            ]);

            // 2. Create Tenant Admin User Account
            $user = $this->userRepo->create([
                'tenant_id'         => $tenant->id,
                'name'              => $data['name'],
                'email'             => $data['email'],
                'password'          => Hash::make($data['password']),
                'status'            => UserStatusEnum::Active,
                'is_admin'          => false,
                'email_verified_at' => now(),
            ]);

            // 3. Assign Spatie Tenant Admin Role
            if (class_exists(\Spatie\Permission\Models\Role::class)) {
                $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Tenant Admin', 'guard_name' => 'web']);
                $user->assignRole($role);
            }

            // 4. Create Paid Billing Invoice Record
            if (class_exists(\Modules\Billing\App\Models\Invoice::class)) {
                \Modules\Billing\App\Models\Invoice::create([
                    'tenant_id'      => $tenant->id,
                    'invoice_number' => 'INV-' . strtoupper(\Illuminate\Support\Str::random(8)),
                    'amount'         => $finalAmount,
                    'currency'       => 'USD',
                    'status'         => 'paid',
                    'due_date'       => now()->addYear(),
                ]);
            }

            // 5. Create Payment Transaction Audit Record
            if (class_exists(\Modules\Payment\App\Models\PaymentTransaction::class)) {
                \Modules\Payment\App\Models\PaymentTransaction::create([
                    'tenant_id'      => $tenant->id,
                    'user_id'        => $user->id,
                    'gateway_id'     => $gateway->id,
                    'transaction_id' => 'TXN-' . strtoupper(\Illuminate\Support\Str::random(10)),
                    'amount'         => $finalAmount,
                    'currency'       => 'USD',
                    'status'         => 'completed',
                    'payment_method' => $gateway->code,
                    'metadata'       => [
                        'plan_name'      => $plan->name,
                        'interval'       => $interval,
                        'coupon_applied' => $couponCode ?: 'NONE',
                        'addons_selected'=> $data['addons'] ?? [],
                    ],
                ]);
            }

            // Log activity
            LoginActivity::record('register', 'success', $user->id, $tenant->id);

            return $user;
        });
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Resolve the tenant_id for a new registration.
     * If auto-create is on, creates a new tenant record.
     */
    private function resolveTenantId(array $data): int
    {
        if (!config('auth-module.tenant.auto_create', false)) {
            return 1; // default tenant
        }

        // If Tenant module is available, create a new tenant
        if (class_exists(\Modules\Tenant\App\Models\Tenant::class)) {
            $tenant = \Modules\Tenant\App\Models\Tenant::create([
                'name'   => $data['company_name'] ?? $data['name'] . "'s Organization",
                'slug'   => \Illuminate\Support\Str::slug($data['company_name'] ?? $data['name']),
                'email'  => $data['email'],
                'plan'   => config('auth-module.tenant.default_plan', 'trial'),
                'status' => 'trial',
                'trial_ends_at' => now()->addDays(config('auth-module.tenant.trial_days', 14)),
                'tenant_id' => 0,
            ]);

            return $tenant->id;
        }

        return 1;
    }
}
