<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user_name;
    public $user_token;

    public $subject = "Mail doğrulama";

    public function __construct($name, $token)
    {
        $this->user_name = $name;
        $this->user_token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = $this->user_name;
        $token = $this->user_token;
        /*return $this->view('admin.authentication.email-verified', compact('name', 'token'));*/
        return $this->markdown('admin.authentication.email-verified', compact('name', 'token'));
    }
}
