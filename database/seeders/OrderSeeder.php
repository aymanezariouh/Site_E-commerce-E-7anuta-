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
        $buyers = User::role('buyer')->get();
        $products = Product::where('is_active', true)->get();

        if ($buyers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('No buyers or active products found.');
            return;
        }

        $statuses = [
            'pending' => 15,      // 15%
            'processing' => 25,   // 25%
            'shipped' => 30,      // 30%
            'delivered' => 30,    // 30%
        ];

        $statusDistribution = [];
        foreach ($statuses as $status => $percentage) {
            $statusDistribution = array_merge(
                $statusDistribution, 
                array_fill(0, $percentage, $status)
            );
        }
        
        foreach ($buyers as $buyer) {
            // Create 2-6 orders per buyer over the last 6 months
            $orderCount = rand(2, 6);
            
            for ($i = 0; $i < $orderCount; $i++) {
                $status = $statusDistribution[array_rand($statusDistribution)];
                
                // Distribute orders over the last 6 months, with more recent orders
                $daysAgo = $this->getRandomDaysAgo();
                $orderDate = now()->subDays($daysAgo);
                
                // Ensure order number uniqueness
                do {
                    $orderNumber = 'E7-' . strtoupper(substr($buyer->name, 0, 2)) . '-' . rand(10000, 99999);
                } while (Order::where('order_number', $orderNumber)->exists());
                
                $order = Order::create([
                    'order_number' => $orderNumber,
                    'user_id' => $buyer->id,
                    'status' => $status,
                    'total_amount' => 0, // Will be calculated below
                    'tax_amount' => 0,
                    'shipping_amount' => rand(500, 1500) / 100, // 5-15€ shipping
                    'shipping_address' => [
                        'name' => $buyer->name,
                        'address' => 'Rue ' . rand(1, 100) . ' Quartier ' . fake()->word(),
                        'city' => fake()->randomElement(['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger']),
                        'postal_code' => rand(10000, 99999),
                        'country' => 'Maroc',
                        'phone' => '0' . rand(6, 7) . rand(10000000, 99999999),
                    ],
                    'billing_address' => [
                        'name' => $buyer->name,
                        'address' => 'Rue ' . rand(1, 100) . ' Quartier ' . fake()->word(),
                        'city' => fake()->randomElement(['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger']),
                        'postal_code' => rand(10000, 99999),
                        'country' => 'Maroc',
                    ],
                    'notes' => rand(1, 4) === 1 ? fake()->sentence() : null,
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                    'shipped_at' => in_array($status, ['shipped', 'delivered']) ? 
                        $orderDate->copy()->addDays(rand(1, 3)) : null,
                    'delivered_at' => $status === 'delivered' ? 
                        $orderDate->copy()->addDays(rand(4, 10)) : null,
                ]);

                // Add 1-4 items to each order
                $itemCount = rand(1, 4);
                $totalAmount = 0;
                $usedProducts = collect();
                
                for ($j = 0; $j < $itemCount; $j++) {
                    // Avoid duplicate products in same order
                    $availableProducts = $products->diff($usedProducts);
                    if ($availableProducts->isEmpty()) {
                        break;
                    }
                    
                    $product = $availableProducts->random();
                    $usedProducts->push($product);
                    
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
                
                // Calculate tax (20% VAT)
                $taxAmount = $totalAmount * 0.2;
                $grandTotal = $totalAmount + $taxAmount + $order->shipping_amount;
                
                // Update order totals
                $order->update([
                    'total_amount' => $grandTotal,
                    'tax_amount' => $taxAmount,
                ]);
            }
        }

        $this->command->info('Orders seeded successfully!');
        $this->command->info('Total orders: ' . Order::count());
        $this->command->info('Orders by status:');
        foreach (array_keys($statuses) as $status) {
            $count = Order::where('status', $status)->count();
            $this->command->info("  {$status}: {$count}");
        }
    }

    /**
     * Get random days ago with weighted distribution (more recent orders)
     */
    private function getRandomDaysAgo(): int
    {
        $weightedRanges = [
            30 => [1, 7],      // Last week: 30% chance
            35 => [8, 30],     // Last month: 35% chance  
            25 => [31, 90],    // Last 3 months: 25% chance
            10 => [91, 180],   // Last 6 months: 10% chance
        ];
        
        $distribution = [];
        foreach ($weightedRanges as $weight => $range) {
            for ($i = 0; $i < $weight; $i++) {
                $distribution[] = $range;
            }
        }
        
        $selectedRange = $distribution[array_rand($distribution)];
        return rand($selectedRange[0], $selectedRange[1]);
    }
}