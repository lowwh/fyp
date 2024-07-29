<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $senderId = $notification->data['sender_id'];
        $messageId = $notification->data['message_id'];

        return redirect()->route('messages.show', ['user' => $senderId, 'message' => $messageId]);
    }


    public function markBidNotificationAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $biddername = $notification->data['bidder_name'];
        $bidder_id = $notification->data['bidder_id'];
        $user_id = $notification->data['user_id'];


        $service_id = $notification->data['service_id'];
        $freelancer_id = $notification->data['freelancer_id'];
        $service_price = $notification->data['service_price'];


        return redirect()->route('messages.bidshow', ['user_id' => $user_id, 'biddername' => $biddername, 'bidder_id' => $bidder_id, 'service_id' => $service_id, 'freelancer_id' => $freelancer_id, 'notification_id' => $id]);
    }




    public function markBidNotificationAsReadUser($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $biddername = $notification->data['bidder_name'];
        $bidder_id = $notification->data['bidder_id'];
        $user_id = $notification->data['user_id'];

        $service_id = $notification->data['service_id'];
        $freelancer_id = $notification->data['freelancer_id'];

        //return redirect("/viewservice/{{ $id}}/{{ $gig_id }}");
        return redirect()->route('messages.bidshow', ['user_id' => $user_id, 'biddername' => $biddername, 'bidder_id' => $bidder_id, 'service_id' => $service_id, 'freelancer_id' => $freelancer_id, 'notification_id' => $id]);
    }


    public function markAsReadForBiddingSuccessUser($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return redirect("/home");

    }
}
