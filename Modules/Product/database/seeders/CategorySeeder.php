<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Product\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics'],
            ['name' => 'Clothing', 'slug' => 'clothing'],
            ['name' => 'Books', 'slug' => 'books'],
            ['name' => 'Home & Garden', 'slug' => 'home-garden'],
            ['name' => 'Sports & Outdoors', 'slug' => 'sports-outdoors'],
            ['name' => 'Toys & Games', 'slug' => 'toys-games'],
            ['name' => 'Beauty & Health', 'slug' => 'beauty-health'],
            ['name' => 'Food & Beverages', 'slug' => 'food-beverages'],
            ['name' => 'Automotive', 'slug' => 'automotive'],
            ['name' => 'Office Supplies', 'slug' => 'office-supplies'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name']]
            );
        }
    }
}
