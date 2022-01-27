<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ordmail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ordmail)
    {
        $this->ordmail = $ordmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("E-Shopper - New Order")->view("admin.pages.mails.order-mail");
    }
}
