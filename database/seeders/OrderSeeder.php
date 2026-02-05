<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $buyer = User::role('buyer')->first();
        $products = Product::take(3)->get();

        if (!$buyer || $products->isEmpty()) {
            return;
        }

        // Create sample orders with different statuses
        $statuses = ['pending', 'processing', 'shipped', 'delivered'];
        
        foreach ($statuses as $index => $status) {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $buyer->id,
                'status' => $status,
                'total_amount' => rand(50, 500),
                'shipping_address' => [
                    'name' => $buyer->name,
                    'address' => '123 Main Street',
                    'city' => 'Sample City',
                    'phone' => '+1234567890'
                ],
                'billing_address' => [
                    'name' => $buyer->name,
                    'address' => '123 Main Street',
                    'city' => 'Sample City',
                    'phone' => '+1234567890'
                ],
                'created_at' => now()->subDays($index * 2),
            ]);

            // Add sample order items
            foreach ($products->take(rand(1, 2)) as $product) {
                $quantity = rand(1, 3);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'total_price' => $quantity * $product->price,
                ]);
            }
        }
    }
}