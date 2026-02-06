<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $buyers = User::where('role', 'buyer')->get();
        $products = Product::all();

        if ($buyers->isEmpty() || $products->isEmpty()) {
            return;
        }

        $statuses = ['pending', 'processing', 'shipped', 'delivered'];
        
        foreach ($buyers as $buyer) {
            // Create 2-4 orders per buyer
            $orderCount = rand(2, 4);
            
            for ($i = 0; $i < $orderCount; $i++) {
                $status = $statuses[array_rand($statuses)];
                $orderDate = now()->subDays(rand(1, 30));
                
                $order = Order::create([
                    'order_number' => Order::generateOrderNumber(),
                    'user_id' => $buyer->id,
                    'status' => $status,
                    'total_amount' => 0, // Will be calculated below
                    'shipping_address' => [
                        'name' => $buyer->name,
                        'address' => fake()->streetAddress(),
                        'city' => fake()->city(),
                        'phone' => fake()->phoneNumber(),
                    ],
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                    'shipped_at' => in_array($status, ['shipped', 'delivered']) ? $orderDate->addDays(rand(1, 3)) : null,
                    'delivered_at' => $status === 'delivered' ? $orderDate->addDays(rand(4, 7)) : null,
                ]);

                // Add 1-3 items to each order
                $itemCount = rand(1, 3);
                $totalAmount = 0;
                
                for ($j = 0; $j < $itemCount; $j++) {
                    $product = $products->random();
                    $quantity = rand(1, 3);
                    $unitPrice = $product->price;
                    $totalPrice = $unitPrice * $quantity;
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_price' => $totalPrice,
                    ]);
                    
                    $totalAmount += $totalPrice;
                }
                
                // Update order total
                $order->update(['total_amount' => $totalAmount]);
            }
        }
    }
}