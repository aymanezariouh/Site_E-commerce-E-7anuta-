<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

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

        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat['name']]);
        }

        // Créer un vendeur
        $seller = User::firstOrCreate(
            ['email' => 'seller@example.com'],
            ['name' => 'Seller User', 'password' => bcrypt('password'), 'role' => 'seller']
        );
        $seller->assignRole('seller');

        // Créer quelques produits
        $products = [
            [
                'name' => 'Smartphone Samsung',
                'description' => 'Smartphone dernière génération avec écran OLED',
                'price' => 2500.00,
                'compare_at_price' => 2800.00,
                'stock_quantity' => 10,
                'sku' => 'PHONE001',
                'status' => 'published',
                'published_at' => now(),
                'is_active' => true,
                'category_id' => Category::where('name', 'Électronique')->first()->id,
                'user_id' => $seller->id,
            ],
            [
                'name' => 'T-shirt Coton',
                'description' => 'T-shirt 100% coton, confortable et durable',
                'price' => 150.00,
                'compare_at_price' => null,
                'stock_quantity' => 25,
                'sku' => 'TSHIRT001',
                'status' => 'published',
                'published_at' => now(),
                'is_active' => true,
                'category_id' => Category::where('name', 'Vêtements')->first()->id,
                'user_id' => $seller->id,
            ],
            [
                'name' => 'Lampe de Bureau',
                'description' => 'Lampe LED avec variateur d\'intensité',
                'price' => 300.00,
                'compare_at_price' => 350.00,
                'stock_quantity' => 15,
                'sku' => 'LAMP001',
                'status' => 'published',
                'published_at' => now(),
                'is_active' => true,
                'category_id' => Category::where('name', 'Maison')->first()->id,
                'user_id' => $seller->id,
            ],
        ];

        foreach ($products as $product) {
            $product['slug'] = Str::slug($product['name']);
            Product::firstOrCreate(['sku' => $product['sku']], $product);
        }

        $this->command->info('Products seeded successfully!');
        $this->command->info('Total products: ' . Product::count());
        $this->command->info('Active products: ' . Product::where('is_active', true)->count());
        $this->command->info('Approved products: ' . Product::where('status', 'approved')->count());
    }
}
