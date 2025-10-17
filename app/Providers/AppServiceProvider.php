<?php

namespace App\Providers;

use App\Models\Employe;
use App\Observers\EmployeObserver;
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
        // /Employe::observe(EmployeObserver::class);
    }
}
