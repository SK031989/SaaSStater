<?php

namespace Modules\Notification\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Notification\App\Models\ActivityLog;
use Modules\Notification\App\Models\UserNotification;
use Modules\Notification\App\Models\NotificationTemplate;
use Modules\Notification\App\Models\NotificationSetting;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Activity Logs covering ALL 15 SaaSStater Modules
        $moduleLogs = [
            [
                'module'      => 'Auth',
                'action'      => 'User Authentication Success',
                'log_type'    => 'info',
                'description' => 'SuperAdmin authenticated successfully via credentials.',
                'user_id'     => 1,
                'tenant_id'   => 1,
                'ip_address'  => '127.0.0.1',
            ],
            [
                'module'      => 'Tenant',
                'action'      => 'Tenant Onboarding Completed',
                'log_type'    => 'success',
                'description' => 'Tenant "Alpha Corp" registered and provisioned workspace database.',
                'user_id'     => 2,
                'tenant_id'   => 2,
                'ip_address'  => '127.0.0.1',
            ],
            [
                'module'      => 'Subscription',
                'action'      => 'Subscription Plan Upgraded',
                'log_type'    => 'success',
                'description' => 'Alpha Corp upgraded subscription from Starter to Enterprise Plan.',
                'user_id'     => 2,
                'tenant_id'   => 2,
                'ip_address'  => '192.168.1.100',
            ],
            [
                'module'      => 'Billing',
                'action'      => 'Invoice Paid Successfully',
                'log_type'    => 'success',
                'description' => 'Invoice #INV-2026-001 for $299.00 processed via Stripe Gateway.',
                'user_id'     => 2,
                'tenant_id'   => 2,
                'ip_address'  => '192.168.1.100',
            ],
            [
                'module'      => 'Entitlement',
                'action'      => 'Feature Limits Enforced',
                'log_type'    => 'info',
                'description' => 'Tenant API request quota set to 50,000 req/mo according to Enterprise Plan.',
                'user_id'     => 1,
                'tenant_id'   => 2,
                'ip_address'  => '127.0.0.1',
            ],
            [
                'module'      => 'Addons',
                'action'      => 'Addon Module Enabled',
                'log_type'    => 'success',
                'description' => 'Advanced Analytics Addon activated for Alpha Corp tenant workspace.',
                'user_id'     => 2,
                'tenant_id'   => 2,
                'ip_address'  => '192.168.1.100',
            ],
            [
                'module'      => 'Coupons',
                'action'      => 'Discount Coupon Applied',
                'log_type'    => 'info',
                'description' => 'Promo code "LAUNCH2026" applied giving 20% discount on Enterprise renewal.',
                'user_id'     => 2,
                'tenant_id'   => 2,
                'ip_address'  => '192.168.1.100',
            ],
            [
                'module'      => 'RolePermission',
                'action'      => 'Role Privileges Updated',
                'log_type'    => 'warning',
                'description' => 'Tenant Admin granted full access to Billing and Addon settings.',
                'user_id'     => 1,
                'tenant_id'   => 1,
                'ip_address'  => '127.0.0.1',
            ],
            [
                'module'      => 'ApiKey',
                'action'      => 'API Access Token Generated',
                'log_type'    => 'info',
                'description' => 'New REST API key "sk_live_alpha_2026" created with read/write scopes.',
                'user_id'     => 2,
                'tenant_id'   => 2,
                'ip_address'  => '192.168.1.100',
            ],
            [
                'module'      => 'Support',
                'action'      => 'Support Ticket Created',
                'log_type'    => 'info',
                'description' => 'Ticket #TCK-8821 "Webhook Delivery Issue" submitted by Alpha Corp admin.',
                'user_id'     => 2,
                'tenant_id'   => 2,
                'ip_address'  => '192.168.1.100',
            ],
            [
                'module'      => 'Product',
                'action'      => 'SaaS Product Configured',
                'log_type'    => 'info',
                'description' => 'Enterprise Suite product features and tier pricing published.',
                'user_id'     => 1,
                'tenant_id'   => 1,
                'ip_address'  => '127.0.0.1',
            ],
            [
                'module'      => 'ModuleBuilder',
                'action'      => 'Dynamic Module Built',
                'log_type'    => 'success',
                'description' => 'Custom CRUD module "Projects" compiled and integrated into sidebar.',
                'user_id'     => 1,
                'tenant_id'   => 1,
                'ip_address'  => '127.0.0.1',
            ],
            [
                'module'      => 'Notification',
                'action'      => 'Notification System Booted',
                'log_type'    => 'info',
                'description' => 'Multi-table notification channel dispatchers and log monitors online.',
                'user_id'     => 1,
                'tenant_id'   => 1,
                'ip_address'  => '127.0.0.1',
            ],
            [
                'module'      => 'Dashboard',
                'action'      => 'Analytics Cache Refreshed',
                'log_type'    => 'info',
                'description' => 'Platform metrics, monthly recurring revenue (MRR), and tenant counts calculated.',
                'user_id'     => 1,
                'tenant_id'   => 1,
                'ip_address'  => '127.0.0.1',
            ],
            [
                'module'      => 'Location',
                'action'      => 'Geographical Region Synced',
                'log_type'    => 'info',
                'description' => 'Datocenter region US-East (N. Virginia) linked to Alpha Corp tenant.',
                'user_id'     => 1,
                'tenant_id'   => 1,
                'ip_address'  => '127.0.0.1',
            ],
        ];

        foreach ($moduleLogs as $log) {
            ActivityLog::firstOrCreate(
                ['action' => $log['action']],
                $log
            );
        }

        // 2. Seed In-App Notifications
        UserNotification::firstOrCreate(
            ['title' => 'Welcome to SaaSStater!'],
            [
                'tenant_id'  => 1,
                'user_id'    => 1,
                'type'       => 'info',
                'message'    => 'Your SaaS platform instance is ready. Start configuring your tenant settings and products.',
                'action_url' => '/admin/dashboard',
                'is_read'    => false,
            ]
        );

        UserNotification::firstOrCreate(
            ['title' => 'Monthly Billing Invoice Generated'],
            [
                'tenant_id'  => 2,
                'user_id'    => 2,
                'type'       => 'billing',
                'message'    => 'Invoice #INV-2026-001 for $299.00 has been generated for your Enterprise subscription.',
                'action_url' => '/admin/billing',
                'is_read'    => false,
            ]
        );

        UserNotification::firstOrCreate(
            ['title' => 'Security Alert: New IP Login'],
            [
                'tenant_id'  => 1,
                'user_id'    => 1,
                'type'       => 'security',
                'message'    => 'A new sign-in was registered from IP 192.168.1.100.',
                'action_url' => '/admin/settings',
                'is_read'    => true,
                'read_at'    => now(),
            ]
        );

        // 3. Seed Notification Templates
        NotificationTemplate::firstOrCreate(
            ['code' => 'welcome_email'],
            [
                'title'     => 'Welcome Email Template',
                'subject'   => 'Welcome to {{app_name}}, {{user_name}}!',
                'body'      => 'Hello {{user_name}}, welcome to {{app_name}}. We are excited to have you on board!',
                'channel'   => 'email',
                'is_active' => true,
            ]
        );

        NotificationTemplate::firstOrCreate(
            ['code' => 'subscription_renewal'],
            [
                'title'     => 'Subscription Renewal Reminder',
                'subject'   => 'Your {{app_name}} Subscription is Renewing Soon',
                'body'      => 'Hi {{user_name}}, your plan {{plan_name}} is scheduled to auto-renew on {{renewal_date}} for ${{amount}}.',
                'channel'   => 'email',
                'is_active' => true,
            ]
        );

        NotificationTemplate::firstOrCreate(
            ['code' => 'invoice_generated'],
            [
                'title'     => 'Invoice Receipt Template',
                'subject'   => 'New Invoice #{{invoice_number}} Available',
                'body'      => 'Dear {{tenant_name}}, invoice #{{invoice_number}} for {{amount}} has been issued.',
                'channel'   => 'email',
                'is_active' => true,
            ]
        );

        NotificationTemplate::firstOrCreate(
            ['code' => 'security_alert_template'],
            [
                'title'     => 'Security Alert Notification',
                'subject'   => 'Security Alert: Password Changed or New Device',
                'body'      => 'Security Notice: A password update or new login occurred on your account at {{timestamp}}.',
                'channel'   => 'in_app',
                'is_active' => true,
            ]
        );

        // 4. Seed Notification Settings
        NotificationSetting::firstOrCreate(
            ['user_id' => 1],
            [
                'tenant_id'            => 1,
                'email_notifications'  => true,
                'system_notifications' => true,
                'billing_alerts'       => true,
                'security_alerts'      => true,
            ]
        );
    }
}
