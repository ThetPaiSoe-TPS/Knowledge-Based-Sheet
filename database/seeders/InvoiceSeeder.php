<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['pending', 'paid', 'overdue', 'cancelled'];
        $customers = Customer::all();

        $invoiceCounter = 1; // ✅ Use counter instead of random

        foreach ($customers as $customer) {
            $invoiceCount = rand(3, 10);

            for ($i = 0; $i < $invoiceCount; $i++) {
                $amount = rand(100, 9999) + .99;
                $tax = $amount * 0.1;
                $total = $amount + $tax;
                $status = $statuses[array_rand($statuses)];

                // ✅ Generate unique invoice number using counter
                $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($invoiceCounter, 6, '0', STR_PAD_LEFT);
                $invoiceCounter++; // ✅ Increment for next invoice

                Invoice::create([
                    'customer_id' => $customer->id,
                    'invoice_number' => $invoiceNumber,
                    'amount' => $amount,
                    'tax' => $tax,
                    'total' => $total,
                    'status' => $status,
                    'due_date' => now()->addDays(rand(0, 90)),
                    'paid_at' => $status === 'paid' ? now()->subDays(rand(0, 30)) : null
                ]);
            }
        }
    }
}
