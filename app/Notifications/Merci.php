<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Merci extends Notification
{
	use Queueable;

	public function __construct($mail) {
		$this->mail = $mail;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable) {
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
			->subject('Marée Haute, Messes Basses, Merci!')

			->greeting("Madame, Monsieur,")
			->line("Il y a maintenant 2 mois, vous étiez 1800 à venir au Théâtre Impérial de Compiègne assister à Marée Haute, Messes Basses, et c'est pour nous la plus belle des récompenses.")
			->line("Nous espérons que vous aurez pris autant de plaisir à voir ce spectacle que nous en avons pris à le préparer et à le jouer.")
			->line("Pour notre équipe, le moment est venu de passer le flambeau, mais l'association et son aventure, elles, continuent. La prochaine Comédie Musicale aura lieu en Décembre 2019, et nous espérons avoir le plaisir de vous compter parmi ses futurs spectateurs!")
			->line("Un immense merci, de la part de toute l'équipe de Marée Haute, Messes Basses")

			// photo
			->line("Pour ne plus recevoir les informations liées à la Comédie Musicale de l'UTC, cliquez sur le bouton ci-dessus.")
			->action("Se désinscrire", route('unsubscribe', ['mail' => $this->mail]))
					;
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
