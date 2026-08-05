<?php

namespace Modules\RolePermission\Providers;

use Illuminate\Support\ServiceProvider;

class RolePermissionServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('Modules/RolePermission/routes/web.php'));
        $this->loadRoutesFrom(base_path('Modules/RolePermission/routes/api.php'));

        // Dual view namespace registration
        $this->loadViewsFrom(base_path('Modules/RolePermission/resources/views'), 'RolePermission');
        $this->loadViewsFrom(base_path('Modules/RolePermission/resources/views'), 'rolepermission');

        $this->loadMigrationsFrom(base_path('Modules/RolePermission/database/migrations'));
    }

    public function register(): void
    {
        //
    }
}
