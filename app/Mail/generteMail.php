<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class generteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $suject;
    public $tienda;
    public $body;

    public function __construct($suject,$tienda,$body)
    {
        $this->suject = $suject;
        $this->tienda = $tienda;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.sendMailGenerate')
                    ->subject($this->suject);
    }
}
