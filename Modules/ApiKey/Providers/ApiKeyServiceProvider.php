<?php

namespace Modules\ApiKey\Providers;

use Illuminate\Support\ServiceProvider;

class ApiKeyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('Modules/ApiKey/routes/web.php'));
        $this->loadRoutesFrom(base_path('Modules/ApiKey/routes/api.php'));

        // Dual view namespace registration
        $this->loadViewsFrom(base_path('Modules/ApiKey/resources/views'), 'ApiKey');
        $this->loadViewsFrom(base_path('Modules/ApiKey/resources/views'), 'apikey');

        $this->loadMigrationsFrom(base_path('Modules/ApiKey/database/migrations'));
    }

    public function register(): void
    {
        //
    }
}
