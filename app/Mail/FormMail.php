<?php

namespace App\Mail;

use http\Env\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use PhpParser\Node\Scalar\String_;

class FormMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $mensaje, string $subject, string $for)
    {
        //
        $this->mensaje = $mensaje;
        $this->subject = $subject;
        $this->para = $for;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mensaje = $this->mensaje;
        $subject = $this->subject;
        $for = $this->para;
        return $this->from('example@example.com')
            ->subject($subject)
            ->view('calendario', compact('mensaje'));
    }
}
