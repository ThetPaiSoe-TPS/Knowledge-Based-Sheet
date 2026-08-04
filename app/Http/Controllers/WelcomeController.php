<?php

namespace App\Http\Controllers;

use App\Jobs\SendWelcomeEmail;
use App\Jobs\SendWelcomeEmailJob;
use App\Models\Welcome;
use Illuminate\Http\Request;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;

class WelcomeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string'
        ]);

        $welcome = Welcome::create([
            'email' => $request->email,
            'name' => $request->name,
            'status' => 'pending'
        ]);

        SendWelcomeEmailJob::dispatch($welcome);

        return response()->json([
            'success' => true,
            'message' => 'Welcome email queued!',
            'data' => $welcome
        ]);
    }

    public function status($id)
    {
        $welcome = Welcome::find($id);

        if (!$welcome) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $welcome
        ]);
    }
}
