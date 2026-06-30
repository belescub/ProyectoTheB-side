<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
         // Esto obliga a que los links usen clases de Bootstrap 5
        Paginator::useBootstrapFive(); 
    // Si usas Bootstrap 4, usa: Paginator::useBootstrapFour();
    }
}
