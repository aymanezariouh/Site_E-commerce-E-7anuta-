<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\ProductLike;
use App\Models\User;
use App\Models\Product;

class ReviewLikeSeeder extends Seeder
{
    public function run(): void
    {
        $buyers = User::where('role', 'buyer')->get();
        $products = Product::all();

        if ($buyers->isEmpty() || $products->isEmpty()) {
            return;
        }

        $comments = [
            'Excellent product! Highly recommended.',
            'Great quality and fast delivery.',
            'Good value for money.',
            'Really satisfied with this purchase.',
            'Amazing product, will buy again!',
            'Perfect! Exactly what I was looking for.',
            'Good quality but could be better.',
            'Nice product, good packaging.',
            'Satisfied with the purchase.',
            'Great experience overall.'
        ];

        // Create reviews
        foreach ($products as $product) {
            $reviewCount = min(rand(1, 3), $buyers->count()); // Max reviews = number of buyers
            $reviewers = $buyers->random($reviewCount);
            
            foreach ($reviewers as $buyer) {
                Review::firstOrCreate(
                    [
                        'user_id' => $buyer->id,
                        'product_id' => $product->id,
                    ],
                    [
                        'rating' => rand(3, 5), // Ratings between 3-5
                        'comment' => $comments[array_rand($comments)],
                        'is_approved' => true,
                    ]
                );
            }
        }

        // Create likes
        foreach ($products as $product) {
            $likeCount = min(rand(1, 3), $buyers->count()); // Max likes = number of buyers
            $likers = $buyers->random($likeCount);
            
            foreach ($likers as $buyer) {
                ProductLike::firstOrCreate([
                    'user_id' => $buyer->id,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}