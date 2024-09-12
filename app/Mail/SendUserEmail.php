<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $emailContent;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $emailContent
     */
    public function __construct($user, $emailContent)
    {
        $this->user = $user;
        $this->emailContent = $emailContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email Notification: ' . $this->user['name'] . ' Sent You a Message')
            ->view('operations.send_user_email')
            ->with([
                'user' => $this->user,
                'emailContent' => $this->emailContent,
            ]);
    }
}

