<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register module middlewares at application level
        $router = $this->app['router'];

        $router->aliasMiddleware('check.user.role', \Modules\Product\Http\Middleware\CheckUserRole::class);
        $router->aliasMiddleware('check.customer.role', \Modules\Product\Http\Middleware\CheckCustomerRole::class);
    }
}
