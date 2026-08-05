<?php

namespace Modules\Addons\Providers;

use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('Modules/Addons/routes/web.php'));
        $this->loadRoutesFrom(base_path('Modules/Addons/routes/api.php'));

        // Dual view namespace registration
        $this->loadViewsFrom(base_path('Modules/Addons/resources/views'), 'Addons');
        $this->loadViewsFrom(base_path('Modules/Addons/resources/views'), 'addons');

        $this->loadMigrationsFrom(base_path('Modules/Addons/database/migrations'));
    }

    public function register(): void
    {
        //
    }
}
