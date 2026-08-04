<?php

namespace Database\Seeders;

use App\Models\CustomerCursor;
use App\Models\OrderCursor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderCursorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $paymentMethods = ['credit_card', 'paypal', 'bank_transfer'];

        $customers = CustomerCursor::all();

        foreach ($customers as $customer) {
            // Each customer has 5-15 orders
            $orderCount = rand(5, 15);

            for ($i = 0; $i < $orderCount; $i++) {
                OrderCursor::create([
                    'customer_id' => $customer->id,
                    'total' => rand(10, 999) + .99,
                    'status' => $statuses[array_rand($statuses)],
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'ordered_at' => now()->subDays(rand(0, 365)),
                    'shipped_at' => rand(0, 1) ? now()->subDays(rand(0, 30)) : null,
                    'delivered_at' => rand(0, 1) ? now()->subDays(rand(0, 10)) : null
                ]);
            }
        }
    }
}
