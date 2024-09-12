<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Result;
use App\Models\Bid;
use App\Models\service;
use App\Models\rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BiddingSuccessNotification;

class ResultController extends Controller
{
    public function show()
    {
        try {
            $userId = auth()->id();

            $results = Result::leftJoin('users', 'results.freelancer_id', '=', 'users.freelancer_id')
                ->leftJoin('services', 'results.gig_id', '=', 'services.id')
                ->leftJoin('users as bidders', 'results.bidder_id', '=', 'bidders.id')
                ->select('results.*', 'results.id as resultid', 'results.status', 'users.name', 'services.id as serviceid', 'services.title as title', 'bidders.name as biddername', 'users.id as userid', 'results.user_id as userid')
                ->get();

            foreach ($results as $result) {
                $result->exists = Rating::whereExists(function ($query) use ($result) {
                    $query->select(DB::raw(1))
                        ->from('results')
                        ->whereColumn('ratings.result_id', 'results.id')
                        ->where('results.id', $result->resultid);

                })->exists();
            }

            // Fetching summary data
            $totalUsers = Result::where('bidder_id', $userId)
                ->orWhere('user_id', $userId)
                ->count();
            $usercompletedProjects = Result::where('status', 'Completed')
                ->where('bidder_id', $userId)

                ->count();
            $userpendingProjects = Result::where('status', 'Pending')
                ->where('bidder_id', $userId)

                ->count();
            $userrejectedProjects = Result::where('status', 'Rejected')
                ->where('bidder_id', $userId)
                ->count();

            $freelancercompletedProjects = Result::where('status', 'Completed')
                ->where('user_id', $userId)

                ->count();
            $freelancerpendingProjects = Result::where('status', 'Pending')
                ->where('user_id', $userId)

                ->count();
            $freelancerrejectedProjects = Result::where('status', 'Rejected')
                ->where('user_id', $userId)
                ->count();


            //return $result;
            return view("operations.manageresult", compact(
                'results',
                'usercompletedProjects',
                'userpendingProjects',
                'userrejectedProjects',
                'freelancercompletedProjects',
                'freelancerpendingProjects',
                'freelancerrejectedProjects',
                'totalUsers',
            ));
        } catch (\Exception $e) {

            dd($e->getMessage()); // Output the error message for debugging
        }
    }


    public function showAddResultForm()
    {
        $freelancers = user::all();


        return view("operations.addresult", compact('freelancers'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'selectFreelancerId' => 'required',
            //'selectCourse' => 'required|string',
            'progress' => 'required',
            'gigId' => 'required',



        ]);

        // Find existing result based on student ID and course
        $existingResult = Result::where('freelancer_id', $validatedData['selectFreelancerId'])
            ->where('gig_id', $validatedData['gigId'])
            ->first();

        if ($existingResult) {

            return redirect()->back()->withInput()->withErrors(['error' => 'Freelancer ID with the Gig Id  already exists. Please try again.']);
        }

        // Create new result if no existing result found
        $result = new Result();
        $result->freelancer_id = $validatedData['selectFreelancerId'];
        // $result->course = $validatedData['selectCourse'];
        $result->progress = $validatedData['progress'];
        $result->gig_id = $validatedData['gigId'];
        $result->save();

        return redirect()->back()->with('success', 'Result added successfully');
    }


    public function search(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'servicetype' => 'required',
        ]);


        $results = DB::table('services')
            ->join('users', 'services.user_id', '=', 'users.id')
            ->leftJoin('ratings', 'ratings.gig_id', '=', 'services.id')
            ->select(
                'services.image_path as serviceimage',
                'services.servicetype',
                'services.description',
                DB::raw("DATE(services.created_at) as service_created_date"),
                'services.price',
                'services.description',
                'services.title',
                'services.id as serviceid',
                'users.id as userid',
                'users.state',
                'users.image_path',
                DB::raw("COUNT(ratings.gig_id) as gigs_count") // using raw query to count gig_id
            )
            ->where('services.servicetype', $validatedData['servicetype'])
            ->orWhere('services.user_name', $validatedData['servicetype'])
            ->groupBy('users.image_path', 'services.image_path', 'services.servicetype', 'services.description', 'services.created_at', 'services.price', 'services.title', 'services.id', 'users.id', 'users.state')
            ->get();

        if ($results->isEmpty()) {
            // No results found
            $errorMessage = 'No results found';
            return view('operations.showresult', ['error' => $errorMessage]);
        } else {
            // Results found
            return view('operations.showresult', ['results' => $results]);
        }
    }




    public function update(Request $request, $id)
    {
        $result = Result::findOrFail($id);
        $result->progress = $request->input('progress');
        $result->save();

        return redirect('/manageresult');
    }

    public function destroy($id)
    {
        $result = Result::findOrFail($id);
        $result->delete();

        return redirect('/manageresult');
    }

    public function addresult(Request $req)
    {

        $result = new Result();
        $result->freelancer_id = $req->freelancer_id;
        $result->gig_id = $req->service_id;
        $result->bidder_id = $req->bidder_id;
        $result->user_id = $req->user_id;
        $result->save();

        $bid = Bid::where('user_id', $req->bidder_id)
            ->where('service_id', $req->service_id)
            ->where('freelancer_id', $req->freelancer_id)
            ->first();



        if ($bid) {
            $bid->status = 'completed';
            $bid->save();
        }


        // Find the freelancer or user to notify
        $replybackbidder = User::find($req->bidder_id);

        // Send notification
        $replybackbidder->notify(new BiddingSuccessNotification($req->bidder_id, $req->service_id));


        session()->flash('success', 'Bidding successfully added!');


        return redirect('manageresult');



    }


    public function rejectProgress(Request $req, $resultid, $userid)
    {

        $reject = Result::findOrFail($resultid);
        $reject->status = 'Rejected';
        $reject->progress = 0.00;
        $reject->save();

        $setRejected = User::findOrFail($userid);
        $setRejected->has_rejected_service = true;
        $setRejected->save();
        //return redirect()->route('home')->with('status', 'Service rejected.');
        return redirect('manageresult');
    }

    public function updateDeliveryDate($resultid, Request $req)
    {
        $update = Result::findOrFail($resultid);
        $update->estimate_delivery_date = $req->estimatedDeliveryDate;
        $update->save();
        return redirect('manageresult');
    }
}
