<?php

// app/Http/Controllers/MessageController.php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewMessageNotification;

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

        return redirect()->route('sendmessages')->with('success', 'Message sent successfully.');
    }


    public function show(User $user, Message $message)
    {
        // Ensure the user is either the sender or the receiver of the message
        if (Auth::id() !== $message->sender_id && Auth::id() !== $message->receiver_id) {
            abort(403);
        }

        return view('messages.show', compact('user', 'message'));
    }


    public function bidshow($biddername, $user_id, $service_id)
    {
        $user = User::findOrFail($user_id);

        if (Auth::id() !== $user->id) {
            abort(403);
        }

        return view('messages.bidshow', compact('biddername', 'user_id', 'service_id'));
    }




}

