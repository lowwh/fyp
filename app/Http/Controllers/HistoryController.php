<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\service;
use App\Models\result;
use App\Models\rating;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function showGigs($id)
    {
        // Get all gig data for the freelancer with 100% progress

        $results = Result::leftJoin('services', 'results.gig_id', '=', 'services.id')

            ->select('services.title', 'services.description', 'services.image_path', 'services.id', 'services.servicetype', 'services.price')
            ->where('services.id', $id)
            ->get();



        // Pass the gig data to the new Blade view
        return view('operations.history', ['results' => $results]);
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

    public function rating(Request $request, $id)
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
        $rating->save();

        return redirect('/history');
    }
}
