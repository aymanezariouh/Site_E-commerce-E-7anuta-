<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $seller = User::role('seller')->first() ?? User::first();

        $products = [
            ['name' => 'Smartphone', 'category' => 'Electronics', 'price' => 599.99, 'description' => 'Latest smartphone with advanced features'],
            ['name' => 'Laptop', 'category' => 'Electronics', 'price' => 999.99, 'description' => 'High-performance laptop for work and gaming'],
            ['name' => 'T-Shirt', 'category' => 'Clothing', 'price' => 29.99, 'description' => 'Comfortable cotton t-shirt'],
            ['name' => 'Jeans', 'category' => 'Clothing', 'price' => 79.99, 'description' => 'Classic denim jeans'],
            ['name' => 'Programming Book', 'category' => 'Books', 'price' => 49.99, 'description' => 'Learn programming fundamentals'],
            ['name' => 'Garden Tools Set', 'category' => 'Home & Garden', 'price' => 89.99, 'description' => 'Complete set of gardening tools'],
            ['name' => 'Basketball', 'category' => 'Sports', 'price' => 39.99, 'description' => 'Professional basketball'],
        ];

        foreach ($products as $productData) {
            $category = $categories->where('name', $productData['category'])->first();
            
            Product::firstOrCreate(
                ['name' => $productData['name']],
                [
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock_quantity' => rand(10, 100),
                    'sku' => 'SKU-' . strtoupper(substr($productData['name'], 0, 3)) . '-' . rand(1000, 9999),
                    'category_id' => $category?->id,
                    'user_id' => $seller?->id,
                    'is_active' => true,
                ]
            );
        }
    }
}