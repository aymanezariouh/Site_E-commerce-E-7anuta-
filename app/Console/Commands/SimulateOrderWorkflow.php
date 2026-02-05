<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;

class SimulateOrderWorkflow extends Command
{
    protected $signature = 'simulate:order-workflow {order_id}';
    protected $description = 'Simulate complete order workflow with email notifications';

    public function handle()
    {
        $orderId = $this->argument('order_id');
        $order = Order::with('user')->find($orderId);
        
        if (!$order) {
            $this->error("Order with ID {$orderId} not found.");
            return 1;
        }

        $this->info("Starting order workflow simulation for Order #{$order->order_number}");
        $this->info("Customer: {$order->user->name} ({$order->user->email})");
        
        $statuses = ['pending', 'processing', 'shipped', 'delivered'];
        $currentIndex = array_search($order->status, $statuses);
        
        if ($currentIndex === false) {
            $currentIndex = 0;
        }
        
        for ($i = $currentIndex + 1; $i < count($statuses); $i++) {
            $newStatus = $statuses[$i];
            $this->info("Updating status to: {$newStatus}");
            
            $order->update(['status' => $newStatus]);
            
            $this->info("✅ Email notification sent for status: {$newStatus}");
            sleep(2); // Simulate time between status changes
        }
        
        $this->info("Order workflow completed!");
        return 0;
    }
}