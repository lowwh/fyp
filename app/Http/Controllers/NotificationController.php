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
}
