<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Order $order;
    protected string $oldStatus;
public function __construct(Order $order, string $oldStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
    }
public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }
public function toMail(object $notifiable): MailMessage
    {
        $order = $this->order->loadMissing('user');
        $customerName = $order->user->name ?? $notifiable->name;
        $customerEmail = $order->user->email ?? ($notifiable->email ?? 'N/A');

        return (new MailMessage)
            ->subject('Order Status Updated - ' . $order->order_number)
            ->greeting('Hello ' . $customerName . '!')
            ->line('Your order status has changed.')
            ->line('Order Number: ' . $order->order_number)
            ->line('Customer Name: ' . $customerName)
            ->line('Customer Email: ' . $customerEmail)
            ->line('Previous Status: ' . $this->oldStatus)
            ->line('New Status: ' . $order->status)
            ->line('Order Total: $' . number_format((float) $order->total_amount, 2))
            ->action('View your orders', url('/orders'))
            ->line('Thank you for using LocalMart.');
    }
public function toArray(object $notifiable): array
    {
        return [
            'type' => 'order_status_updated',
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'old_status' => $this->oldStatus,
            'new_status' => $this->order->status,
            'message' => 'Order status updated: ' . $this->oldStatus . ' -> ' . $this->order->status,
        ];
    }
}
