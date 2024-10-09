<?php

namespace App\mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class userNotification extends Mailable


{
    use Queueable, SerializesModels;

    
    /**
     * Create a new class instance.
     */
    public function __construct(  private $groupName)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "bonjour , un membre vient d'être ajouté au groupe",
            from: new Address('accounts@unetah.net', 'no reply '),
        );
    }

    public function content(): Content{
        return new Content(
            view: 'mail.userNotification',
            with: ['groupName' => $this->groupName]
        );}
}
