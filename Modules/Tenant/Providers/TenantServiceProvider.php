<?php

namespace Modules\Tenant\Providers;

use Illuminate\Support\ServiceProvider;

class TenantServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('Modules/Tenant/routes/web.php'));
        $this->loadRoutesFrom(base_path('Modules/Tenant/routes/api.php'));

        // Dual view namespace registration
        $this->loadViewsFrom(base_path('Modules/Tenant/resources/views'), 'Tenant');
        $this->loadViewsFrom(base_path('Modules/Tenant/resources/views'), 'tenant');

        $this->loadMigrationsFrom(base_path('Modules/Tenant/database/migrations'));
    }

    public function register(): void
    {
        //
    }
}
