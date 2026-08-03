<?php

namespace App\Jobs;

use App\Models\Newsletter;
use App\Models\Subscriber;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNewsletterEmail implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subscriber;
    public $newsletter;

    // Max attempts
    public $tries = 3;

    // Retry delay (seconds)
    public $backoff = 60;

    public function __construct(Subscriber $subscriber, Newsletter $newsletter)
    {
        $this->subscriber = $subscriber;
        $this->newsletter = $newsletter;
    }

    public function handle(): void
    {
        // Simulate sending email (slowing down to see progress)
        sleep(0.5);

        // Send email
        Mail::raw($this->newsletter->content, function ($message) {
            $message->to($this->subscriber->email, $this->subscriber->name)
                ->subject($this->newsletter->subject);
        });

        // Update newsletter progress
        $this->newsletter->increment('sent_count');

        Log::info("📧 Email sent to: " . $this->subscriber->email);

        // If batch is complete, update newsletter status
        if ($this->batch() && $this->batch()->finished()) {
            $this->newsletter->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);
            Log::info("✅ Newsletter #{$this->newsletter->id} completed!");
        }
    }

    public function failed(\Throwable $e): void
    {
        // Increment failed count
        $this->newsletter->increment('failed_count');

        Log::error("❌ Email failed for: " . $this->subscriber->email . " - " . $e->getMessage());
    }
}
