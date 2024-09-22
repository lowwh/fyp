<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceRejectedNotification extends Notification
{
    use Queueable;

    public $userid;
    public $resultid;

    public $bidderName;

    public function __construct($userid, $resultid, $bidderName)
    {
        $this->userid = $userid;
        $this->resultid = $resultid;
        $this->bidderName = $bidderName;
    }

    public function via($notifiable)
    {
        return ['database'];  // You can add more channels like mail, SMS, etc.
        //    '' mail',
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('A service you provided has been rejected.')
            ->action('View Service', url('/gig/' . $this->resultid))
            ->line('Thank you for using our platform!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your service has been rejected by ' . $this->bidderName,
            'user_id' => $this->userid,
            'result_id' => $this->resultid,
        ];
    }
}
