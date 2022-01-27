<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $conmail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($conmail)
    {
        $this->conmail = $conmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("New Contact Message")->view("admin.pages.mails.contact-mail");
    }
}
