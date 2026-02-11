<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected Order $order;
    protected float $sellerTotal;
public function __construct(Order $order, float $sellerTotal)
    {
        $this->order = $order;
        $this->sellerTotal = $sellerTotal;
    }
public function via(object $notifiable): array
    {
        return ['mail'];
    }
public function toMail(object $notifiable): MailMessage
    {
        $this->order->loadMissing('user');
        $shippingAddress = is_array($this->order->shipping_address) ? $this->order->shipping_address : [];
        $customerName = $shippingAddress['name'] ?? ($this->order->user->name ?? 'N/A');
        $customerEmail = $shippingAddress['email'] ?? ($this->order->user->email ?? 'N/A');

        return (new MailMessage)
            ->subject('New order received - ' . $this->order->order_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You received a new order for your products.')
            ->line('Order number: ' . $this->order->order_number)
            ->line('Customer: ' . $customerName)
            ->line('Customer email: ' . $customerEmail)
            ->line('Total for your products: ' . number_format($this->sellerTotal, 2) . ' EUR')
            ->action('View order', url('/seller/orders/' . $this->order->id))
            ->line('Please prepare shipment as soon as possible.');
    }
public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_order',
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'customer_name' => $this->order->user->name,
            'seller_total' => $this->sellerTotal,
            'message' => 'New order #' . $this->order->order_number . ' from ' . $this->order->user->name,
        ];
    }
}
