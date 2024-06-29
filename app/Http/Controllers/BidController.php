<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bid;
use App\Notifications\BidPlacedNotification;
use Auth;

class BidController extends Controller
{
    public function store($id, Request $request, $serviceid, $freelancerid)
    {
        $user = User::findOrFail($id);


        $bid = new Bid();
        $bid->user_id = $user->id;
        $bid->bidder_id = auth()->id();
        $bid->bidder_name = Auth::user()->name;
        $bid->service_id = $serviceid;
        $bid->freelancer_id = $freelancerid;

        $bid->save();


        $user->notify(new BidPlacedNotification($bid));

        return back()->with('bid', 'Your bidding is pending!');
    }
}
