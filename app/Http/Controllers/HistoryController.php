<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\service;
use App\Models\result;
use App\Models\rating;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function showrating($resultid, $userid)
    {
        // Get all gig data for the freelancer with 100% progress
        $results = Result::leftJoin('services', 'results.gig_id', '=', 'services.id')

            ->select('results.id as resultid', 'services.title', 'services.description', 'services.image_path', 'services.id', 'services.servicetype', 'services.price')
            ->where('results.id', $resultid)
            ->groupBy('services.id', 'results.id', 'services.title', 'services.description', 'services.image_path', 'services.servicetype', 'services.price')
            ->distinct()

            ->get();

        $user_id = $userid;


        //return ($resultid);

        // Pass the gig data to the new Blade view
        return view('operations.rating', ['results' => $results, 'userid' => $user_id]);
        //return $user_id;
    }

    public function index()
    {

        $userId = auth()->id();
        // $userId = auth()->id();
        $results = service::join('ratings', 'ratings.gig_id', '=', 'services.id')
            ->join('users', 'users.id', '=', 'ratings.user_id')
            ->join('results', 'results.gig_id', '=', 'services.id')



            ->select('services.image_path', 'ratings.expectation', 'ratings.suggestion', 'ratings.rating', 'ratings.reason', 'ratings.gig_id', 'users.image_path as userimage', 'results.progress')
            ->where('results.progress', 100)
            ->where('users.id', $userId)
            ->where('results.bidder_id', $userId)
            ->distinct()

            ->get();


        return view('operations.showallhistory', ['results' => $results]);
    }

    public function rating(Request $request, $id, $userid)
    {
        $request->validate([
            'expectation' => 'required',
            'reason' => 'required',
            'suggestion' => 'required',
            'rating' => 'required',
        ]);
        $rating = new rating();



        $rating->gig_id = $id;
        $rating->user_id = Auth::id();
        $rating->expectation = $request->expectation;
        $rating->reason = $request->reason;
        $rating->suggestion = $request->suggestion;
        $rating->rating = $request->rating;
        $rating->result_id = $request->resultid;
        $rating->service_owner_id = $request->userid;

        $rating->save();

        $updateResultStatus = Result::findOrFail($request->resultid);
        $updateResultStatus->status = 'completed';
        $updateResultStatus->save();

        $setToTrue = User::findOrFail($userid);
        $setToTrue->has_rejected_service = 'false';
        $setToTrue->save();

        return redirect('/history');
    }
}
