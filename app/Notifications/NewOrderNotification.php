<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Order $order;
    protected float $sellerTotal;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, float $sellerTotal)
    {
        $this->order = $order;
        $this->sellerTotal = $sellerTotal;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle commande reçue - ' . $this->order->order_number)
            ->greeting('Bonjour ' . $notifiable->name . '!')
            ->line('Vous avez reçu une nouvelle commande.')
            ->line('Numéro de commande: ' . $this->order->order_number)
            ->line('Client: ' . $this->order->user->name)
            ->line('Montant de vos produits: ' . number_format($this->sellerTotal, 2) . ' €')
            ->action('Voir la commande', url('/seller/orders/' . $this->order->id))
            ->line('Merci d\'utiliser LocalMart!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_order',
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'customer_name' => $this->order->user->name,
            'seller_total' => $this->sellerTotal,
            'message' => 'Nouvelle commande #' . $this->order->order_number . ' de ' . $this->order->user->name,
        ];
    }
}
