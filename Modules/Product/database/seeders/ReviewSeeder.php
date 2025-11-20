<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Product\Models\Review;
use Modules\Product\Models\Product;
use Modules\Product\Enums\Rating;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Please run ProductSeeder first.');
            return;
        }

        $reviews = [
            [
                'product_id' => $products->first()->id,
                'author_name' => 'John Doe',
                'rating' => Rating::FIVE->value,
                'comment' => 'Excellent product! Highly recommended. The quality exceeded my expectations.',
            ],
            [
                'product_id' => $products->first()->id,
                'author_name' => 'Jane Smith',
                'rating' => Rating::FOUR->value,
                'comment' => 'Very good product, fast delivery. Minor issue with packaging but overall satisfied.',
            ],
            [
                'product_id' => $products->skip(1)->first()?->id,
                'author_name' => 'Bob Johnson',
                'rating' => Rating::FIVE->value,
                'comment' => 'Perfect for my needs. Great value for money!',
            ],
        ];

        foreach ($reviews as $review) {
            if ($review['product_id']) {
                Review::create($review);
            }
        }
    }
}
