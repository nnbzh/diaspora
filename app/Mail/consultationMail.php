<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class consultationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function build()
    {
        $input = array(
            'login'     => $this->mailData['login'],
            'text'     => $this->mailData['text'],
        );
        return $this->from('diaspora.noreply@gmail.com')
                    ->subject('Новое письмо в техподдержку')
                    ->markdown('mail')
                    ->with([
                        'input' => $input,
                    ]);
    }
}
