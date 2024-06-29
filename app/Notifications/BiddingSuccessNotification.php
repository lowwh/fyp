<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BiddingSuccessNotification extends Notification
{
    use Queueable;

    // Data that will be stored in the notification
    public $bidder_id;
    public $service_id;

    public function __construct($bidder_id, $service_id)
    {
        $this->bidder_id = $bidder_id;
        $this->service_id = $service_id;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'bidder_id' => $this->bidder_id,
            'service_id' => $this->service_id,
            'message' => 'Your bidding has been confirmed!'
        ];
    }
}
