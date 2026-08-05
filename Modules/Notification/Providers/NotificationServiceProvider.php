<?php

namespace Modules\Notification\Providers;

use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('Modules/Notification/routes/web.php'));
        $this->loadRoutesFrom(base_path('Modules/Notification/routes/api.php'));

        // Dual view namespace registration
        $this->loadViewsFrom(base_path('Modules/Notification/resources/views'), 'Notification');
        $this->loadViewsFrom(base_path('Modules/Notification/resources/views'), 'notification');

        $this->loadMigrationsFrom(base_path('Modules/Notification/database/migrations'));
    }

    public function register(): void
    {
        //
    }
}
