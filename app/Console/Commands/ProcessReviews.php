<?php

namespace App\Console\Commands;

use App\Models\Review;
use Illuminate\Console\Command;

class ProcessReviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-reviews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Processing reviews with lazy()...');

        $processed = 0;
        $approved = 0;
        $pending = 0;

        // ✅ Using lazy() - streams one review at a time
        foreach (Review::lazy() as $review) {
            // ✅ Full Eloquent model available
            // Can use model methods
            if ($review->isPending()) {
                $pending++;

                // Auto-approve reviews with rating >= 4
                if ($review->rating >= 4) {
                    $review->approve(); // ✅ Using model method
                    $approved++;
                    $this->line("Approved review #{$review->id} (Rating: {$review->rating}⭐)");
                }
            }

            $processed++;

            if ($processed % 100 == 0) {
                $this->info("Processed {$processed} reviews...");
            }
        }

        $this->info("\n✅ Summary:");
        $this->info("   Total reviews: {$processed}");
        $this->info("   Auto-approved: {$approved}");
        $this->info("   Still pending: " . ($pending - $approved));

        return 0;
    }
}
