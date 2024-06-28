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
        $user_id = $notification->data['user_id'];

        $service_id = $notification->data['service_id'];

        //return redirect("/viewservice/{{ $id}}/{{ $gig_id }}");
        return redirect()->route('messages.bidshow', ['biddername' => $biddername, 'user_id' => $user_id, 'service_id' => $service_id]);
    }
}
