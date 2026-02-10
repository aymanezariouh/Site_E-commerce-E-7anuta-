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
        $order = $this->order->loadMissing(['items.product', 'user']);
        $shippingAddress = is_array($order->shipping_address) ? $order->shipping_address : [];

        $customerName = $shippingAddress['name'] ?? ($order->user->name ?? 'Customer');
        $customerEmail = $shippingAddress['email'] ?? $this->customerEmail ?? ($order->user->email ?? 'N/A');

        $mail = (new MailMessage)
            ->subject('Order Confirmation - Order #' . $order->order_number)
            ->greeting('Hello ' . $customerName . '!')
            ->line('Thank you for your order. Your order has been received and is being processed.')
            ->line('Order Number: ' . $order->order_number)
            ->line('Customer Name: ' . $customerName)
            ->line('Customer Email: ' . $customerEmail)
            ->line('Total Amount: $' . number_format((float) $order->total_amount, 2))
            ->line('Status: ' . ucfirst($order->status));

        if ($order->items->isNotEmpty()) {
            $mail->line('Items:');
            foreach ($order->items as $item) {
                $itemName = $item->product_name ?: ($item->product->name ?? 'Product');
                $mail->line('- ' . $itemName . ' x' . $item->quantity . ' ($' . number_format((float) $item->unit_price, 2) . ')');
            }
        }

        return $mail
            ->action('View Order Details', url('/buyer/orders/' . $order->id))
            ->line('We will notify you when your order is shipped.')
            ->line('Thank you for shopping with us!');
    }
}
