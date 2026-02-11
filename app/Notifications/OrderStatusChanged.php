<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusChanged extends Notification
{
    use Queueable;

    private $order;

    public function __construct($order)
    {
        $this->order = $order;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Changement de statut de votre commande')
            ->line('Bonjour ' . $notifiable->name . ',')
            ->line('Le statut de votre commande a été modifié.')
            ->line('Nouveau statut : ' . $this->order->status)
            ->line('Merci pour votre confiance.');
    }
}
