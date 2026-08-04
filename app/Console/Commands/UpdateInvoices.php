<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;

class UpdateInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-invoices';

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
        $this->info('🔄 Updating invoices...');
        // ✅ Process 50 invoices at a time
        Invoice::chunk(50, function ($invoices) use (&$totalUpdated) {
            foreach ($invoices as $invoice) {
                // Mark overdue if due date passed
                if ($invoice->status === 'pending' && $invoice->due_date < now()) {
                    $invoice->update(['status' => 'overdue']);
                }
                $totalUpdated++;
            }

            $this->info("Processed {$totalUpdated} invoices so far...");
        });
        $this->info("✅ Updated {$totalUpdated} invoices!");
        return 0;
    }
}
