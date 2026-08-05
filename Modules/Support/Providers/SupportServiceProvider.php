<?php

namespace Modules\Support\Providers;

use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('Modules/Support/routes/web.php'));
        $this->loadRoutesFrom(base_path('Modules/Support/routes/api.php'));

        // Dual view namespace registration
        $this->loadViewsFrom(base_path('Modules/Support/resources/views'), 'Support');
        $this->loadViewsFrom(base_path('Modules/Support/resources/views'), 'support');

        $this->loadMigrationsFrom(base_path('Modules/Support/database/migrations'));
    }

    public function register(): void
    {
        //
    }
}
