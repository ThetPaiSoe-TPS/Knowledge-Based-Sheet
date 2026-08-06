<?php

namespace App\Providers;

use App\Events\EmployeeCreated;
use App\Listeners\LogEmployeeCreation;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     * 
     * ✅ THIS MUST BE THE FIRST PROPERTY AFTER THE CLASS!
     */
    protected $listen = [
        EmployeeCreated::class => [
            SendWelcomeEmail::class,
            LogEmployeeCreation::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function register(): void
    {
        // ✅ Make sure parent is called
        parent::register();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
