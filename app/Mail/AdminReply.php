<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminReply extends Mailable
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
        return $this->subject("E-Shopper: Reply")->view("admin.pages.mails.admin-reply");
    }
}
