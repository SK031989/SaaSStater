<?php

namespace Modules\Coupons\Providers;

use Illuminate\Support\ServiceProvider;

class CouponServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('Modules/Coupons/routes/web.php'));
        $this->loadRoutesFrom(base_path('Modules/Coupons/routes/api.php'));

        // Dual view namespace registration
        $this->loadViewsFrom(base_path('Modules/Coupons/resources/views'), 'Coupons');
        $this->loadViewsFrom(base_path('Modules/Coupons/resources/views'), 'coupons');

        $this->loadMigrationsFrom(base_path('Modules/Coupons/database/migrations'));
    }

    public function register(): void
    {
        //
    }
}
