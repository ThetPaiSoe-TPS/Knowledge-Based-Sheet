<?php

namespace App\Listeners;

use App\Events\EmployeeCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EmployeeCreated $event): void
    {
        $employee = $event->employee;

        Log::info("Welcome email send to:{$employee->email}");
        Log::info("   Subject: Welcome to the team, {$employee->name}!");
        Log::info("   Message: We're excited to have you join us!");
    }
}
