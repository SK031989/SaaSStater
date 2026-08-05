<?php

namespace Modules\Entitlement\Providers;

use Illuminate\Support\ServiceProvider;

class EntitlementServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('Modules/Entitlement/routes/web.php'));
        $this->loadRoutesFrom(base_path('Modules/Entitlement/routes/api.php'));

        // Dual view namespace registration
        $this->loadViewsFrom(base_path('Modules/Entitlement/resources/views'), 'Entitlement');
        $this->loadViewsFrom(base_path('Modules/Entitlement/resources/views'), 'entitlement');

        $this->loadMigrationsFrom(base_path('Modules/Entitlement/database/migrations'));
    }

    public function register(): void
    {
        //
    }
}
