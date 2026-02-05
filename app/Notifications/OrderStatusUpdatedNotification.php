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

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, string $oldStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
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
            ->subject('Statut de commande mis à jour - ' . $this->order->order_number)
            ->greeting('Bonjour ' . $notifiable->name . '!')
            ->line('Le statut de votre commande a changé.')
            ->line('Commande : ' . $this->order->order_number)
            ->line('Ancien statut : ' . $this->oldStatus)
            ->line('Nouveau statut : ' . $this->order->status)
            ->action('Voir vos commandes', url('/orders'))
            ->line('Merci d\'utiliser LocalMart!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'order_status_updated',
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'old_status' => $this->oldStatus,
            'new_status' => $this->order->status,
            'message' => 'Statut de commande mis à jour : ' . $this->oldStatus . ' → ' . $this->order->status,
        ];
    }
}
