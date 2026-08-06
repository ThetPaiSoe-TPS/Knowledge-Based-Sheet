<?php

namespace App\Providers;

use App\Services\EmployeeService;
use Illuminate\Support\ServiceProvider;

class EmployeeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // ✅ Register as singleton (only one instance)
        $this->app->singleton(EmployeeService::class, function ($app) {
            return new EmployeeService();
        });

        // ✅ Optional: Register with custom name
        $this->app->bind('employee.service', function ($app) {
            return $app->make(EmployeeService::class);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
