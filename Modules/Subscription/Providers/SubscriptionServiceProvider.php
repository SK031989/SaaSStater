<?php

namespace Modules\Subscription\Providers;

use Illuminate\Support\ServiceProvider;

class SubscriptionServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('Modules/Subscription/routes/web.php'));
        $this->loadRoutesFrom(base_path('Modules/Subscription/routes/api.php'));

        // Dual view namespace registration
        $this->loadViewsFrom(base_path('Modules/Subscription/resources/views'), 'Subscription');
        $this->loadViewsFrom(base_path('Modules/Subscription/resources/views'), 'subscription');

        $this->loadMigrationsFrom(base_path('Modules/Subscription/database/migrations'));
    }

    public function register(): void
    {
        //
    }
}
