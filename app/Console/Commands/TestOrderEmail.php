<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;

class TestOrderEmail extends Command
{
    protected $signature = 'test:order-email {order_id} {new_status}';
    protected $description = 'Test order status change email notification';

    public function handle()
    {
        $orderId = $this->argument('order_id');
        $newStatus = $this->argument('new_status');

        $order = Order::with('user')->find($orderId);

        if (!$order) {
            $this->error("Order with ID {$orderId} not found.");
            return 1;
        }

        $oldStatus = $order->status;
        $order->update(['status' => $newStatus]);

        $this->info("Order #{$order->order_number} status changed from {$oldStatus} to {$newStatus}");
        $this->info("Email notification sent to: {$order->user->email}");

        return 0;
    }
}