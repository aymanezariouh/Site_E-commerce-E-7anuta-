<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderConfirmationNotification extends Notification
{
    use Queueable;

    protected $order;
    protected $customerEmail;

    public function __construct(Order $order, $customerEmail)
    {
        $this->order = $order;
        $this->customerEmail = $customerEmail;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Order Confirmation - Order #' . $this->order->order_number)
            ->greeting('Hello ' . $this->order->shipping_address['name'] . '!')
            ->line('Thank you for your order. Your order has been received and is being processed.')
            ->line('Order Number: ' . $this->order->order_number)
            ->line('Total Amount: $' . number_format($this->order->total_amount, 2))
            ->line('Status: ' . ucfirst($this->order->status))
            ->action('View Order Details', url('/buyer/orders/' . $this->order->id))
            ->line('We will notify you when your order is shipped.')
            ->line('Thank you for shopping with us!');
    }
}
