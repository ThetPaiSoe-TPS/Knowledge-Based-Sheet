<?php

namespace App\Console\Commands;

use App\Models\OrderCursor;
use Illuminate\Console\Command;

class ExportOrdersCursor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-orders-cursor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all orders to CSV using cursor()';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = storage_path('app/orders_export.csv');

        // Create CSV header
        $csv = fopen($filePath, 'w');
        fputcsv($csv, ['ID', 'Customer ID', 'Total', 'Status', 'Payment Method', 'Ordered At']);

        $count = 0;

        foreach (OrderCursor::cursor() as $order) {
            fputcsv($csv, [
                $order->id,
                $order->customer_id,
                $order->total,
                $order->status,
                $order->payment_method,
                $order->ordered_at
            ]);
            $count++;

            if ($count % 1000 == 0) {
                $this->info("Exported {$count} orders...");
            }
        }

        fclose($csv);
        $this->info("✅ Exported {$count} orders to: " . $filePath);
        return 0;
    }
}
