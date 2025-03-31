<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Xác nhận tài khoản của bạn')
                    ->view('emails.verify-email')
                    ->with([
                        'user' => $this->user,
                        'verifyUrl' => route('verify.email', ['token' => $this->user->verification_token]),
                    ]);
    }
}