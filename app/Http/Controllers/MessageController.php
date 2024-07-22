<?php

// app/Http/Controllers/MessageController.php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewMessageNotification;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function receivedMessageIndex()
    {
        $receivedMessages = Message::where('receiver_id', Auth::id())->orderBy('created_at', 'desc')->get();


        return view('messages.receivedMessageIndex', compact('receivedMessages'));
    }


    public function sendMessageIndex()
    {
        $sentMessages = Message::where('sender_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('messages.sendMessageIndex', compact('sentMessages'));

    }

    public function create(User $user)
    {
        return view('messages.create', compact('user'));
    }

    //method2

    // public function create($id)
    // {

    //     $user = User::findOrFail($id);
    //     return view('messages.create', compact('user'));
    // }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'sender_name' => Auth::user()->name
        ]);

        $receiver = User::find($request->receiver_id);
        $receiver->notify(new NewMessageNotification($message));

        return redirect()->route('receivedmessages')->with('success', 'Message sent successfully.');
    }


    public function show(User $user, Message $message)
    //TODO:remmeber to do this
    {
        // Assuming Message model has sender_id and receiver_id fields
        $messages = Message::where(function ($query) use ($user, $message) {
            $query->where('sender_id', $user->id)->where('receiver_id', Auth::id())
                ->orWhere('sender_id', Auth::id())->where('receiver_id', $user->id);
        })->orderBy('created_at')->get();

        $receiver = $user; // The user you are having a conversation with

        $messages->load('sender');

        return view('messages.show', compact('messages', 'receiver'));
    }



    public function bidshow($biddername, $bidder_id, $service_id, $freelancer_id, $user_id, $notification_id)
    {
        $user = User::findOrFail($user_id);

        if (Auth::id() !== $user->id) {
            abort(403);
        }

        $status = 'pending';
        $bid = Bid::where('user_id', $user_id)
            ->where('bidder_id', $bidder_id)
            ->first();

        if ($bid && $bid->status === 'completed') {
            $status = 'completed';
        }
        return view('messages.bidshow', compact('biddername', 'bidder_id', 'service_id', 'freelancer_id', 'status', 'notification_id'));
    }




}

