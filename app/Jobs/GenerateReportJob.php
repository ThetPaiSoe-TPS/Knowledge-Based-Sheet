<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Report;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class GenerateReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $report;
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Update status to processing
        $this->report->update(['status' => 'processing']);
        // Get order data
        $orders = Order::where('user_id', $this->report->user_id)->get();
        $totalOrders = $orders->count();
        $totalRevenue = $orders->sum('total');

        // Create report content
        $content = "========================================\n";
        $content .= "       REPORT: " . $this->report->title . "\n";
        $content .= "========================================\n\n";
        $content .= "Generated: " . now() . "\n";
        $content .= "User ID: " . $this->report->user_id . "\n\n";
        $content .= "----------------------------------------\n";
        $content .= "SUMMARY\n";
        $content .= "----------------------------------------\n";
        $content .= "Total Orders: " . $totalOrders . "\n";
        $content .= "Total Revenue: $" . number_format($totalRevenue, 2) . "\n\n";
        $content .= "----------------------------------------\n";
        $content .= "ORDER DETAILS\n";
        $content .= "----------------------------------------\n\n";

        foreach ($orders as $order) {
            $content .= "Order #" . $order->id . "\n";
            $content .= "  Total: $" . number_format($order->total, 2) . "\n";
            $content .= "  Address: " . $order->address . "\n";
            $content .= "  Status: " . $order->status . "\n";
            $content .= "  Date: " . $order->created_at . "\n\n";
        }

        // Save report
        $fileName = 'report_' . $this->report->id . '_' . now()->format('Y-m-d') . '.txt';
        $path = 'reports/' . $fileName;

        if (!File::exists(storage_path('app/public/reports'))) {
            File::makeDirectory(storage_path('app/public/reports'), 0777, true);
        }

        File::put(storage_path('app/public/' . $path), $content);

        // Update database
        $this->report->update([
            'file_path' => $path,
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'status' => 'completed',
            'completed_at' => now()
        ]);

        Log::info("✅ Report generated: " . $this->report->title);
    }

    public function failed(\Throwable $e): void
    {
        $this->report->update(['status' => 'failed']);
        Log::error("❌ Report job failed: " . $e->getMessage());
    }
}
