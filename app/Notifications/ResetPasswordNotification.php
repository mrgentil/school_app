<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('/password/reset/' . $this->token . '?email=' . urlencode($notifiable->email));

        return (new MailMessage)
            ->subject('Définir votre mot de passe')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Un compte a été créé pour vous dans notre application.')
            ->action('Définir votre mot de passe', $url)
            ->line('Ce lien expirera après un certain temps. Si vous n\'avez pas demandé cela, veuillez ignorer cet email.');
    }

}
