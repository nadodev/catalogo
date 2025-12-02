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
        // Configurar paginação para português
        \Illuminate\Pagination\Paginator::defaultView('pagination.custom');
        \Illuminate\Pagination\Paginator::defaultSimpleView('pagination.simple');
    }
}
