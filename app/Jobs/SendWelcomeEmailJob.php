<?php

namespace App\Jobs;

use App\Models\Welcome;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Mail;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */

    public $welcome;
    public function __construct(Welcome $welcome)
    {
        $this->welcome = $welcome;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->welcome->update(['status' => 'sending']);
        try {
            Mail::raw("Welcome {$this->welcome->name}!\n\nThank you for joining us. We're excited to have you!", function ($message) {
                $message->to($this->welcome->email, $this->welcome->name)
                    ->subject('Welcome to Our Platform!');
            });
            $this->welcome->update([
                'status' => 'sent',
                'sent_at' => now()
            ]);
            Log::info("✅ Welcome email sent to: " . $this->welcome->email);
        } catch (Exception $e) {
            $this->welcome->update(['status' => 'failed']);
            Log::error("❌ Welcome email failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function failed(\Throwable $e): void
    {
        $this->welcome->update(['status' => 'failed']);
        Log::error("❌ Welcome job failed: " . $e->getMessage());
    }
}
