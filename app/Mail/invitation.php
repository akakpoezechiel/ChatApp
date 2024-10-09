<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;


class invitation extends Mailable
{
    use Queueable, SerializesModels;

    public $groupName;
    public $groupLink;

    public function __construct($groupName, $groupLink)
    {
        $this->groupName = $groupName;
        $this->groupLink= $groupLink;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation à rejoindre un groupe',
            from: new Address('accounts@unetah.net', 'Message d\'invitation')
        );
    }



    public function content(): Content
    {
        return new Content(
            view: 'mail.invitation',

            with: [
                'name' => $this->groupName,
                'link' => $this->groupLink,
                'date' => now(),
                'time' => now()->format('H:i'),
                'day' => now()->format('d/m/Y'),
                'hour' => now()->format('H:i'),
                
            ]
        );
    }




    public function build()
    {
        return $this->subject('Invitation à rejoindre un groupe')
                    ->view('mail.invitation')
                    ->with([
                        'groupName' => $this->groupName,
                        'registerLink' => $this->groupLink,
                    ]);
    }


}
