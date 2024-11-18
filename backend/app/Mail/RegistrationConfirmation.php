<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class RegistrationConfirmation extends Mailable
{
    public $token;
    public $email;

    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Xác nhận đăng ký tài khoản FoxTales')
            ->view('emails.registration')
            ->with([
                'email' => $this->email,
                'token' => $this->token,
            ]);
    }
}