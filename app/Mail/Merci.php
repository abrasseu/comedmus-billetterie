<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Merci extends Mailable
{
    use Queueable, SerializesModels;

    protected $mail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail = 'No-Mail', $etu = false) {
        $this->mail = $mail;
        $this->etu = $etu;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('notification@lacomutc.fr', config('app.name'))
                    ->subject('Marée Haute, Messes Basses, Merci!')
                    ->view('vendor.mail.merci')
                    ->with([
                        'mail' => $this->mail,
                        'etu'  => $this->etu
                    ]);
    }
}
