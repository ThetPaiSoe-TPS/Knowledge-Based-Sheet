<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;  // ✅ Add this
use Illuminate\Foundation\Bus\DispatchesJobs;               // ✅ Add this
use Illuminate\Foundation\Validation\ValidatesRequests;     // ✅ Add this
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;  // ✅ Add these traits
}
