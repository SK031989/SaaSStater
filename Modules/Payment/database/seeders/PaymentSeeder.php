<?php

namespace Modules\Payment\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Payment\App\Models\PaymentGateway;
use Modules\Payment\App\Models\PaymentTransaction;
use Modules\Tenant\App\Models\Tenant;
use Modules\Auth\App\Models\User;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Payment Gateways
        $stripe = PaymentGateway::firstOrCreate(
            ['code' => 'stripe'],
            [
                'name'         => 'Stripe Credit & Debit Cards',
                'mode'         => 'sandbox',
                'credentials'  => [
                    'publishable_key' => 'pk_test_51MzSaaSStaterKeyExample12345',
                    'secret_key'      => 'sk_test_51MzSaaSStaterSecretExample12345',
                    'webhook_secret'  => 'whsec_ExampleWebhookSecret12345',
                ],
                'is_active'    => true,
                'is_default'   => true,
                'instructions' => 'Supports Visa, Mastercard, AMEX, Apple Pay, and Google Pay via Stripe Checkout.',
            ]
        );

        $paypal = PaymentGateway::firstOrCreate(
            ['code' => 'paypal'],
            [
                'name'         => 'PayPal Checkout',
                'mode'         => 'sandbox',
                'credentials'  => [
                    'client_id' => 'AY_PayPalSandboxClientIdExample12345',
                    'secret'    => 'EG_PayPalSandboxSecretKeyExample12345',
                ],
                'is_active'    => true,
                'is_default'   => false,
                'instructions' => 'Fast and secure checkout via PayPal Wallet & Express Checkout.',
            ]
        );

        $razorpay = PaymentGateway::firstOrCreate(
            ['code' => 'razorpay'],
            [
                'name'         => 'Razorpay Online Payments',
                'mode'         => 'sandbox',
                'credentials'  => [
                    'key_id'     => 'rzp_test_ExampleKeyId12345',
                    'key_secret' => 'rzp_test_ExampleSecret12345',
                ],
                'is_active'    => true,
                'is_default'   => false,
                'instructions' => 'Popular gateway supporting NetBanking, UPI, and local wallets.',
            ]
        );

        $bankTransfer = PaymentGateway::firstOrCreate(
            ['code' => 'bank_transfer'],
            [
                'name'         => 'Direct Bank Wire Transfer',
                'mode'         => 'live',
                'credentials'  => [
                    'bank_name'      => 'Silicon Valley Commercial Bank',
                    'account_number' => '9876543210',
                    'routing_number' => '121000358',
                    'swift_code'     => 'SVCBUS33XXX',
                ],
                'is_active'    => true,
                'is_default'   => false,
                'instructions' => 'Transfer payments directly to Bank Account. Upload proof of transfer to confirm.',
            ]
        );

        // Seed Payment Transactions
        $alphaTenant = Tenant::where('subdomain', 'alpha')->first();
        $betaTenant  = Tenant::where('subdomain', 'beta')->first();
        $alphaAdmin  = User::where('email', 'tenant1@saas.local')->first();
        $betaAdmin   = User::where('email', 'tenant2@saas.local')->first();

        $demoTransactions = [
            [
                'tenant_id'      => $alphaTenant?->id,
                'user_id'        => $alphaAdmin?->id,
                'gateway_id'     => $stripe->id,
                'transaction_id' => 'TXN-STRIPE-8942',
                'amount'         => 29.00,
                'currency'       => 'USD',
                'status'         => 'completed',
                'payment_method' => 'card_visa',
                'metadata'       => ['plan' => 'Growth Pro Monthly'],
            ],
            [
                'tenant_id'      => $alphaTenant?->id,
                'user_id'        => $alphaAdmin?->id,
                'gateway_id'     => $stripe->id,
                'transaction_id' => 'TXN-STRIPE-8941',
                'amount'         => 290.00,
                'currency'       => 'USD',
                'status'         => 'completed',
                'payment_method' => 'card_mastercard',
                'metadata'       => ['plan' => 'Growth Pro Annual'],
            ],
            [
                'tenant_id'      => $betaTenant?->id,
                'user_id'        => $betaAdmin?->id,
                'gateway_id'     => $paypal->id,
                'transaction_id' => 'TXN-PAYPAL-7412',
                'amount'         => 99.00,
                'currency'       => 'USD',
                'status'         => 'completed',
                'payment_method' => 'paypal_account',
                'metadata'       => ['plan' => 'Enterprise Scale Monthly'],
            ],
            [
                'tenant_id'      => $betaTenant?->id,
                'user_id'        => $betaAdmin?->id,
                'gateway_id'     => $bankTransfer->id,
                'transaction_id' => 'TXN-BANK-1002',
                'amount'         => 990.00,
                'currency'       => 'USD',
                'status'         => 'pending',
                'payment_method' => 'wire_transfer',
                'metadata'       => ['plan' => 'Enterprise Scale Annual'],
            ],
        ];

        foreach ($demoTransactions as $t) {
            PaymentTransaction::firstOrCreate(
                ['transaction_id' => $t['transaction_id']],
                $t
            );
        }
    }
}
