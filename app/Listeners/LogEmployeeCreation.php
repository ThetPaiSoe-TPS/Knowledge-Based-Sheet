<?php

namespace App\Listeners;

use App\Events\EmployeeCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogEmployeeCreation
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
        $employee= $event->employee;

        Log::info("New employee created:", [
            'id'=> $employee->id,
            'name'=> $employee->name,
            'email'=> $employee->email,
            'department'=> $employee->department,
            'time'=> now(),
        ]);
    }
}
