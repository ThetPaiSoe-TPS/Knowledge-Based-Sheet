<?php

namespace App\Http\Controllers;

use App\Jobs\SendNewsletterEmail;
use App\Models\Newsletter;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    // Create and send newsletter
    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        // Get all active subscribers
        $subscribers = Subscriber::active()->get();

        if ($subscribers->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No active subscribers found'
            ], 400);
        }

        // Create newsletter record
        $newsletter = Newsletter::create([
            'subject' => $request->subject,
            'content' => $request->content,
            'total_recipients' => $subscribers->count(),
            'status' => 'processing'
        ]);

        // Create jobs for each subscriber
        $jobs = [];
        foreach ($subscribers as $subscriber) {
            $jobs[] = new SendNewsletterEmail($subscriber, $newsletter);
        }

        // Dispatch batch
        $batch = Bus::batch($jobs)
            ->then(function () use ($newsletter) {
                // All jobs completed
                $newsletter->update([
                    'status' => 'completed',
                    'completed_at' => now()
                ]);
            })
            ->catch(function ($batch, $e) use ($newsletter) {
                // Some jobs failed
                $newsletter->update(['status' => 'failed']);
                Log::error("❌ Newsletter batch failed: " . $e->getMessage());
            })
            ->finally(function () use ($newsletter) {
                // Done regardless of success/failure
                Log::info("📊 Newsletter #{$newsletter->id} batch finished");
            })
            ->dispatch();

        return response()->json([
            'success' => true,
            'message' => 'Newsletter sending started!',
            'data' => [
                'newsletter_id' => $newsletter->id,
                'total_recipients' => $subscribers->count(),
                'batch_id' => $batch->id,
                'status' => 'processing'
            ]
        ]);
    }

    // Check newsletter status
    public function status($id)
    {
        $newsletter = Newsletter::find($id);

        if (!$newsletter) {
            return response()->json([
                'success' => false,
                'message' => 'Newsletter not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $newsletter->id,
                'subject' => $newsletter->subject,
                'status' => $newsletter->status,
                'total_recipients' => $newsletter->total_recipients,
                'sent_count' => $newsletter->sent_count,
                'failed_count' => $newsletter->failed_count,
                'progress' => $newsletter->progress . '%',
                'created_at' => $newsletter->created_at,
                'completed_at' => $newsletter->completed_at
            ]
        ]);
    }

    // Get all newsletters
    public function index()
    {
        $newsletters = Newsletter::latest()->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $newsletters->map(function ($newsletter) {
                return [
                    'id' => $newsletter->id,
                    'subject' => $newsletter->subject,
                    'status' => $newsletter->status,
                    'progress' => $newsletter->progress . '%',
                    'total' => $newsletter->total_recipients,
                    'sent' => $newsletter->sent_count,
                    'failed' => $newsletter->failed_count,
                    'created_at' => $newsletter->created_at->diffForHumans()
                ];
            }),
            'pagination' => [
                'current_page' => $newsletters->currentPage(),
                'per_page' => $newsletters->perPage(),
                'total' => $newsletters->total(),
                'last_page' => $newsletters->lastPage()
            ]
        ]);
    }

    // Create subscriber
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'name' => 'nullable|string|max:255'
        ]);

        $subscriber = Subscriber::create([
            'email' => $request->email,
            'name' => $request->name,
            'is_active' => true,
            'subscribed_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscribed successfully!',
            'data' => $subscriber
        ], 201);
    }

    // Unsubscribe
    public function unsubscribe(Request $request, $id)
    {
        $subscriber = Subscriber::find($id);

        if (!$subscriber) {
            return response()->json([
                'success' => false,
                'message' => 'Subscriber not found'
            ], 404);
        }

        $subscriber->update([
            'is_active' => false,
            'unsubscribed_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Unsubscribed successfully!'
        ]);
    }

    // Get all subscribers
    public function subscribers()
    {
        $subscribers = Subscriber::latest()->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $subscribers,
            'total' => $subscribers->total()
        ]);
    }
}
