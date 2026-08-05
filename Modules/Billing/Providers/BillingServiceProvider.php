<?php

namespace Modules\Billing\Providers;

use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('Modules/Billing/routes/web.php'));
        $this->loadRoutesFrom(base_path('Modules/Billing/routes/api.php'));

        // Dual view namespace registration
        $this->loadViewsFrom(base_path('Modules/Billing/resources/views'), 'Billing');
        $this->loadViewsFrom(base_path('Modules/Billing/resources/views'), 'billing');

        $this->loadMigrationsFrom(base_path('Modules/Billing/database/migrations'));
    }

    public function register(): void
    {
        //
    }
}
