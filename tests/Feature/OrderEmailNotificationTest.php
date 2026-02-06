<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Models\User;
use App\Mail\OrderStatusChanged;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class OrderEmailNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_sent_when_order_status_changes()
    {
        Mail::fake();

        $user = User::factory()->create(['role' => 'buyer']);
        $order = Order::create([
            'order_number' => 'TEST-001',
            'user_id' => $user->id,
            'status' => 'pending',
            'total_amount' => 99.99,
            'shipping_address' => ['name' => 'Test User', 'address' => '123 Test St'],
        ]);

        // Update order status
        $order->update(['status' => 'processing']);

        // Assert email was sent
        Mail::assertSent(OrderStatusChanged::class, function ($mail) use ($order) {
            return $mail->order->id === $order->id &&
                   $mail->oldStatus === 'pending' &&
                   $mail->newStatus === 'processing';
        });
    }

    public function test_no_email_sent_when_status_unchanged()
    {
        Mail::fake();

        $user = User::factory()->create(['role' => 'buyer']);
        $order = Order::create([
            'order_number' => 'TEST-002',
            'user_id' => $user->id,
            'status' => 'pending',
            'total_amount' => 99.99,
            'shipping_address' => ['name' => 'Test User', 'address' => '123 Test St'],
        ]);

        // Update order with same status
        $order->update(['status' => 'pending']);

        // Assert no email was sent
        Mail::assertNotSent(OrderStatusChanged::class);
    }
}