<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Review $review;

    /**
     * Create a new notification instance.
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
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
        $stars = str_repeat('★', $this->review->rating) . str_repeat('☆', 5 - $this->review->rating);

        return (new MailMessage)
            ->subject('Nouvel avis sur votre produit - ' . $this->review->product->name)
            ->greeting('Bonjour ' . $notifiable->name . '!')
            ->line('Un client a laissé un avis sur votre produit.')
            ->line('Produit : ' . $this->review->product->name)
            ->line('Note : ' . $stars . ' (' . $this->review->rating . '/5)')
            ->line('Commentaire : ' . ($this->review->comment ?: 'Aucun commentaire'))
            ->action('Voir les avis', url('/seller/reviews'))
            ->line('Merci d\'utiliser LocalMart!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_review',
            'review_id' => $this->review->id,
            'product_id' => $this->review->product_id,
            'product_name' => $this->review->product->name,
            'rating' => $this->review->rating,
            'customer_name' => $this->review->user->name,
            'message' => 'Nouvel avis (' . $this->review->rating . '★) sur ' . $this->review->product->name,
        ];
    }
}
