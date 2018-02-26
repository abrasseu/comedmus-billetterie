<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BilletAvailable extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from('notification@lacomutc.fr', config('app.name'))
                    ->subject('Vos billets sont disponibles')
                    ->line('Vos billets sont disponibles !')
                    ->action('Télécharger les billets ici ', route('show'))
                    ->line('Il n\'est désormais plus absolument nécessaire de les imprimer, vous pouvez soit télécharger votre place sur votre smartphone, soit l\'imprimer pour présenter le QR code le jour de la représentation.')
                    ->line('Nous vous rappelons qu\'il est en revanche nécessaire d\'être **présent 20 minutes avant le début du spectacle** et que **le placement est libre**.')
                    ->line('Rendez vous le 14, 15 et 16 Décembre au Théâtre Impérial !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
