<?php

namespace App\Notifications;

use App\Models\Bid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BidPlacedNotification extends Notification
{
    use Queueable;

    protected $bid;

    public function __construct(Bid $bid)
    {
        $this->bid = $bid;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Your bid has been placed successfully.')
            ->action('View Bid', url('/bids/' . $this->bid->id))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your bid has been placed successfully.',
            'bidder_id' => auth()->id(),
            'user_id' => $this->bid->user_id,
            'bidder_name' => $this->bid->bidder_name,
            'service_id' => $this->bid->service_id,
            'freelancer_id' => $this->bid->freelancer_id,
            'service_price' => $this->bid->service_price,

        ];
    }
}
