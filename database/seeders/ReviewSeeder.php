<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('Please create users first!');
            return;
        }

        $comments = [
            'Great product! Highly recommended.',
            'Not bad, but could be better.',
            'Excellent quality and service.',
            'Disappointed with the quality.',
            'Perfect! Exactly what I needed.',
            'Good value for money.',
            'Would not buy again.',
            'Amazing! Will order again.',
            'Average product, nothing special.',
            'Best purchase ever!'
        ];

        foreach ($users as $user) {
            // Each user writes 5-15 reviews
            $reviewCount = rand(5, 15);

            for ($i = 0; $i < $reviewCount; $i++) {
                $rating = rand(1, 5);

                Review::create([
                    'user_id' => $user->id,
                    'rating' => $rating,
                    'comment' => $comments[array_rand($comments)],
                    'is_approved' => rand(0, 1),
                    'approved_at' => rand(0, 1) ? now()->subDays(rand(0, 30)) : null
                ]);
            }
        }
    }
}
