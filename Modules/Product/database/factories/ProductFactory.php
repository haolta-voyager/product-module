<?php

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\Product;
use Modules\Product\Models\Category;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $categories = Category::pluck('id')->toArray();
        
        return [
            'name' => fake()->words(rand(2, 4), true),
            'description' => fake()->sentence(rand(10, 20)),
            'price' => fake()->randomFloat(2, 9.99, 999.99),
            'category_id' => fake()->randomElement($categories),
        ];
    }
}
