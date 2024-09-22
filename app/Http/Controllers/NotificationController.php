<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reject;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

        $service_title = $notification->data['service_title'];
        $service_price = $notification->data['service_price'];
        // return $service_title;

        return redirect()->route('messages.bidshow', ['service_price' => $service_price, 'service_title' => $service_title, 'user_id' => $user_id, 'biddername' => $biddername, 'bidder_id' => $bidder_id, 'service_id' => $service_id, 'freelancer_id' => $freelancer_id, 'notification_id' => $id]);
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
        $service_title = $notification->data['service_title'];




        //return redirect("/viewservice/{{ $id}}/{{ $gig_id }}");
        return redirect()->route('messages.bidshow', ['title' => $service_title, 'user_id' => $user_id, 'biddername' => $biddername, 'bidder_id' => $bidder_id, 'service_id' => $service_id, 'freelancer_id' => $freelancer_id, 'notification_id' => $id]);
    }

    public function markRejectNotification($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $data = $notification->data;

        // Assuming your notification data contains a `result_id`
        $resultId = $data['result_id'] ?? null;

        $latestRejection = null;
        $rejectOwnerName = null;

        // Fetch the latest rejection details if resultId exists
        if ($resultId) {
            $latestRejection = DB::table('rejects')
                ->join('results', 'rejects.result_id', '=', 'results.id')
                ->join('users', 'users.id', '=', 'results.bidder_id')
                ->select('rejects.id as reject_id', 'rejects.reason', 'rejects.user_id', 'results.*', 'users.name', 'rejects.created_at')
                ->where('rejects.result_id', $resultId)
                ->orderBy('rejects.created_at', 'desc')
                ->first(); // Get the latest rejection
        }

        // Check if we found a latest rejection
        if ($latestRejection) {
            $rejectOwnerName = User::find($latestRejection->user_id)->name;
        }

        // Pass the latest rejection and owner name to the view
        return view('messages.rejectMessage', [
            'rejection' => $latestRejection, // Pass the latest rejection
            'rejectOwnerName' => $rejectOwnerName, // Pass the owner name
        ]);
    }



    public function markAsReadForBiddingSuccessUser($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return redirect("/manageResult");

    }
}
