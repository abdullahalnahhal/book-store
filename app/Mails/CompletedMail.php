<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {
            return $this->from('example@example.com')
            ->view('emails.index', [
                'msg' =>'completed',
            ]);
        } catch (Exception $e) {
            return null;
        }
    }
}