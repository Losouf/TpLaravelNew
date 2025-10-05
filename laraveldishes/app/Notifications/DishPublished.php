<?php
namespace App\Notifications;

use App\Models\Dish;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DishPublished extends Notification
{
    use Queueable;

    public function __construct(public Dish $dish) {}

    public function via(object $notifiable): array { return ['mail']; }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Ta recette est en ligne')
            ->line('Ton plat "'.$this->dish->name.'" est publié.')
            ->action('Voir le plat', route('dishes.show', $this->dish));
    }
}
