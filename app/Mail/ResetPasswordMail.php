<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function build()
    {
        $input = [
            'code'     => $this->mailData['code'],
        ];
        return $this->from('info@nextin.me')
                    ->subject('My-portfel - сброс пароля')
                    ->markdown('emails.reset_password')
                    ->with([
                        'input' => $input,
                    ]);
    }
}
