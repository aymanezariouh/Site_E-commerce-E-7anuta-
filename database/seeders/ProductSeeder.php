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
        $sellers = User::role('seller')->get();

        if ($sellers->isEmpty()) {
            $this->command->warn('No sellers found. Creating products with first available user.');
            $sellers = collect([User::first()]);
        }

        $products = [
            // Electronics
            ['name' => 'iPhone 15 Pro', 'category' => 'Electronics', 'price' => 1299.99, 'description' => 'Latest iPhone with advanced camera system'],
            ['name' => 'Samsung Galaxy S24', 'category' => 'Electronics', 'price' => 899.99, 'description' => 'Flagship Android smartphone'],
            ['name' => 'MacBook Air M2', 'category' => 'Electronics', 'price' => 1199.99, 'description' => 'Powerful and lightweight laptop'],
            ['name' => 'Dell XPS 13', 'category' => 'Electronics', 'price' => 999.99, 'description' => 'Ultra-portable business laptop'],
            ['name' => 'iPad Air', 'category' => 'Electronics', 'price' => 599.99, 'description' => 'Versatile tablet for work and play'],
            ['name' => 'AirPods Pro', 'category' => 'Electronics', 'price' => 249.99, 'description' => 'Wireless earbuds with noise cancellation'],
            ['name' => 'Sony WH-1000XM4', 'category' => 'Electronics', 'price' => 349.99, 'description' => 'Premium noise-canceling headphones'],
            ['name' => 'Nintendo Switch', 'category' => 'Electronics', 'price' => 299.99, 'description' => 'Portable gaming console'],
            
            // Clothing
            ['name' => 'Nike Air Force 1', 'category' => 'Clothing', 'price' => 109.99, 'description' => 'Classic white sneakers'],
            ['name' => 'Levi\'s 501 Jeans', 'category' => 'Clothing', 'price' => 89.99, 'description' => 'Original fit denim jeans'],
            ['name' => 'Adidas Hoodie', 'category' => 'Clothing', 'price' => 69.99, 'description' => 'Comfortable cotton hoodie'],
            ['name' => 'Ralph Lauren Polo', 'category' => 'Clothing', 'price' => 79.99, 'description' => 'Classic polo shirt'],
            ['name' => 'North Face Jacket', 'category' => 'Clothing', 'price' => 199.99, 'description' => 'Waterproof outdoor jacket'],
            ['name' => 'Zara Dress', 'category' => 'Clothing', 'price' => 49.99, 'description' => 'Elegant summer dress'],
            ['name' => 'H&M Basic T-Shirt', 'category' => 'Clothing', 'price' => 12.99, 'description' => 'Essential cotton t-shirt'],
            
            // Books
            ['name' => 'Clean Code', 'category' => 'Books', 'price' => 39.99, 'description' => 'A handbook of agile software craftsmanship'],
            ['name' => 'Design Patterns', 'category' => 'Books', 'price' => 54.99, 'description' => 'Elements of reusable object-oriented software'],
            ['name' => 'The Algorithm Design Manual', 'category' => 'Books', 'price' => 49.99, 'description' => 'Comprehensive guide to algorithms'],
            ['name' => 'Eloquent JavaScript', 'category' => 'Books', 'price' => 34.99, 'description' => 'A modern introduction to programming'],
            ['name' => 'You Don\'t Know JS', 'category' => 'Books', 'price' => 29.99, 'description' => 'Book series on JavaScript'],
            
            // Home & Garden
            ['name' => 'Dyson V11 Vacuum', 'category' => 'Home & Garden', 'price' => 599.99, 'description' => 'Cordless vacuum cleaner'],
            ['name' => 'Ninja Blender', 'category' => 'Home & Garden', 'price' => 99.99, 'description' => 'High-performance blender'],
            ['name' => 'Instant Pot', 'category' => 'Home & Garden', 'price' => 79.99, 'description' => 'Multi-use pressure cooker'],
            ['name' => 'Plant Pot Set', 'category' => 'Home & Garden', 'price' => 24.99, 'description' => 'Ceramic plant pots with drainage'],
            ['name' => 'LED String Lights', 'category' => 'Home & Garden', 'price' => 19.99, 'description' => 'Warm white decorative lights'],
            
            // Sports
            ['name' => 'Wilson Tennis Racket', 'category' => 'Sports', 'price' => 129.99, 'description' => 'Professional tennis racket'],
            ['name' => 'Spalding Basketball', 'category' => 'Sports', 'price' => 39.99, 'description' => 'Official size basketball'],
            ['name' => 'Yoga Mat', 'category' => 'Sports', 'price' => 29.99, 'description' => 'Non-slip exercise mat'],
            ['name' => 'Dumbbells Set', 'category' => 'Sports', 'price' => 149.99, 'description' => 'Adjustable dumbbells 5-50lbs'],
            ['name' => 'Resistance Bands', 'category' => 'Sports', 'price' => 24.99, 'description' => 'Set of exercise resistance bands'],
        ];

        foreach ($products as $productData) {
            $category = $categories->where('name', $productData['category'])->first();
            $seller = $sellers->random();
            
            Product::firstOrCreate(
                ['name' => $productData['name']],
                [
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock_quantity' => rand(5, 150),
                    'sku' => 'SKU-' . strtoupper(substr(str_replace(' ', '', $productData['name']), 0, 3)) . '-' . rand(1000, 9999),
                    'category_id' => $category?->id,
                    'user_id' => $seller?->id,
                    'is_active' => rand(1, 10) > 1, // 90% chance of being active
                    'status' => rand(1, 10) > 2 ? 'approved' : 'pending', // 80% approved
                    'images' => [
                        'https://via.placeholder.com/300x300/007bff/ffffff?text=' . urlencode(substr($productData['name'], 0, 10)),
                        'https://via.placeholder.com/300x300/28a745/ffffff?text=' . urlencode(substr($productData['name'], 0, 10)),
                    ],
                    'weight' => rand(100, 5000) / 100, // Weight between 1-50kg
                    'dimensions' => json_encode([
                        'length' => rand(10, 50),
                        'width' => rand(10, 50), 
                        'height' => rand(5, 30)
                    ]),
                    'created_at' => now()->subDays(rand(1, 180)),
                ]
            );
        }

        $this->command->info('Products seeded successfully!');
        $this->command->info('Total products: ' . Product::count());
        $this->command->info('Active products: ' . Product::where('is_active', true)->count());
        $this->command->info('Approved products: ' . Product::where('status', 'approved')->count());
    }
}