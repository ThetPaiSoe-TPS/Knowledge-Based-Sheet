<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = ['New York', 'London', 'Paris', 'Tokyo', 'Sydney', 'Berlin', 'Moscow', 'Dubai'];
        $countries = ['USA', 'UK', 'France', 'Japan', 'Australia', 'Germany', 'Russia', 'UAE'];

        for ($i = 1; $i <= 10000; $i++) {
            Customer::create([
                'name' => "Customer {$i}",
                'email' => "customer{$i}@example.com",
                'city' => $cities[array_rand($cities)],
                'country' => $countries[array_rand($countries)],
                'balance' => rand(0, 9999) + .99,
                'is_active' => rand(0, 1),
                'last_purchase_at' => now()->subDays(rand(0, 365))
            ]);
        }
    }
}
