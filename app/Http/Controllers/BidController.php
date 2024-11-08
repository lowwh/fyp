<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bid;
use App\Notifications\BidPlacedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class BidController extends Controller
{
    public function store($id, Request $request, $serviceid, $freelancerid, $serviceprice)
    {
        $user = User::findOrFail($id);


        $bid = new Bid();
        $bid->user_id = $user->id;
        $bid->bidder_id = auth()->id();
        $bid->bidder_name = Auth::user()->name;
        $bid->service_id = $serviceid;
        $bid->freelancer_id = $freelancerid;
        $bid->service_price = $serviceprice;

        $bid->save();


        $user->notify(new BidPlacedNotification($bid));

        return back()->with('bid', 'Your bid is pending. Please wait for the freelancer to review and confirm your bid. You will be notified once the freelancer has made a decision');
    }



}
