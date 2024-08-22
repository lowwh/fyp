<?php

// app/Http/Controllers/MessageController.php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rating;
use App\Models\Result;
use App\Notifications\NewMessageNotification;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function receivedMessageIndex()
    {
        $receivedMessages = Message::select('messages.*', 'users.name as receiver_name', 'users.image_path as userimage', 'users.name as username')
            ->join('users', 'messages.receiver_id', '=', 'users.id')
            ->where('messages.receiver_id', Auth::id())
            ->orderBy('messages.created_at', 'desc')
            ->get();


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


    //this method is use for the send message button in show blade 
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
            'sender_name' => Auth::user()->name,
            'sender_image' => Auth::user()->image_path
        ]);

        $receiver = User::find($request->receiver_id);
        $receiver->notify(new NewMessageNotification($message));

        $messages = Message::where(function ($query) use ($request) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $request->receiver_id)
                ->orWhere('sender_id', $request->receiver_id)->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();

        $messages->load('sender');

        $view = view('operations.message-list', compact('messages'))->render();

        return response()->json([
            'success' => true,
            'messages' => $view,
        ]);
    }

    //this method is use for the send message button in home blade 
    public function sendMessage(Request $request)
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

        $messages = Message::where(function ($query) use ($user, $message) {
            $query->where('sender_id', $user->id)->where('receiver_id', Auth::id())
                ->orWhere('sender_id', Auth::id())->where('receiver_id', $user->id);
        })->orderBy('created_at')->get();

        $receiver = $user; //  user you are having a conversation with

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
        return view('messages.bidshow', compact('biddername', 'bidder_id', 'service_id', 'freelancer_id', 'status', 'notification_id', 'user_id'));
    }

    public function showRatings()
    {

        $userId = auth()->id();

        // Fetch project status counts from the database
        $statuses = Result::selectRaw('
        status,
        COUNT(*) as count
    ')
            ->where('user_id', $userId)
            ->orWhere('bidder_id', $userId)
            ->groupBy('status')
            ->orderByRaw("FIELD(status, 'pending', 'completed', 'rejected')") // Ensure order: pending, completed, rejected
            ->get();

        // Define colors for the statuses in the correct order
        $colors = [
            'rgba(255, 159, 64, 0.2)', // Color for Pending
            'rgba(25, 206, 8, 0.2)', // Color for Rejected
            'rgba(255, 99, 132, 0.2)', // Color for Completed
        ];

        // Define an array of border colors for the pie chart segments
        $borderColors = [
            'rgba(255, 159, 64, 1)', // Border color for Pending
            'rgba(25, 206, 8, 1)', // Border color for Rejected
            'rgba(255, 99, 132, 1)', // Border color for Completed
        ];

        // Prepare data for Chart.js
        $statusesArray = $statuses->pluck('status')->toArray();
        $chartData = [
            'labels' => $statusesArray,
            'datasets' => [
                [
                    'label' => 'Project Status Count',
                    'data' => $statuses->pluck('count')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $statuses->count()),
                    'borderColor' => array_slice($borderColors, 0, $statuses->count()),
                    'borderWidth' => 1,
                ]
            ]
        ];

        $pieChartData = [
            'labels' => $statusesArray,
            'datasets' => [
                [
                    'data' => $statuses->pluck('count')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $statuses->count()),
                    'borderColor' => array_slice($borderColors, 0, $statuses->count()),
                    'borderWidth' => 1,
                ]
            ]
        ];



        return view('operations.graph', ['chartData' => $chartData, 'pieChartData' => $pieChartData]);

    }
}

