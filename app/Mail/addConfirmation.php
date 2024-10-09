<?php

namespace App\mail;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class addConfirmation extends  Mailable
{
    /**
     * Create a new class instance.
     */
    public function __construct(private $groupName)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "vous êtes ajouté au groupe",
            from: new Address('accounts@unetah.net', 'no reply '),
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'mail.addConfirmation',
            with: [
        'group_name' => $this->groupName],

        );
    }

}
