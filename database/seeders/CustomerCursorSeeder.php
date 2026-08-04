<?php

namespace Database\Seeders;

use App\Models\CustomerCursor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerCursorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = ['New York', 'London', 'Paris', 'Tokyo', 'Sydney', 'Berlin', 'Dubai', 'Singapore'];
        $countries = ['USA', 'UK', 'France', 'Japan', 'Australia', 'Germany', 'UAE', 'Singapore'];
        
        for ($i = 1; $i <= 1000; $i++) {
            CustomerCursor::create([
                'name' => "Customer {$i}",
                'email' => "customer{$i}@example.com",
                'city' => $cities[array_rand($cities)],
                'country' => $countries[array_rand($countries)],
                'balance' => rand(0, 9999) + .99,
                'is_active' => rand(0, 1)
            ]);
        }
    }
}
