<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Result;
use App\Models\Bid;
use App\Models\service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BiddingSuccessNotification;

class ResultController extends Controller
{
    public function index()
    {
        try {
            // Fetch all results joined with student names
            $results = Result::leftJoin('users', 'results.freelancer_id', '=', 'users.freelancer_id')
                ->leftJoin('services', 'results.gig_id', '=', 'services.id')
                ->select('results.*', 'users.name', 'services.id as serviceid', )
                ->get();

            // Pass the results data to the view
            return view("operations.manageresult", compact('results'));
        } catch (\Exception $e) {
            // Log or handle the exception
            dd($e->getMessage()); // Output the error message for debugging
        }
    }


    public function showAddResultForm()
    {
        $freelancers = user::all(); // Fetch all students from the database
        // $coursesOptions = ["Chemistry", "Mathematics", "Fundamentals of Programming", "Project Management"]; // Example courses options, replace with your actual data

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
            // If result exists, return back with error message
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

    // ResultController.php
    public function search(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'servicetype' => 'required',
        ]);

        // Perform the query with gig count
        $results = DB::table('services') // Ensure you're using the correct table name here
            ->join('users', 'services.user_id', '=', 'users.id')
            ->leftJoin('ratings', 'ratings.gig_id', '=', 'services.id')
            ->select(
                'services.servicetype',
                'services.description',
                DB::raw("DATE(services.created_at) as service_created_date"),
                'services.price',
                'services.title',
                'services.id as serviceid',
                'users.id as userid',
                'users.state',
                DB::raw("COUNT(ratings.gig_id) as gigs_count") // Count gig_id
            )
            ->where('services.servicetype', $validatedData['servicetype'])
            ->groupBy('services.servicetype', 'services.description', 'services.created_at', 'services.price', 'services.title', 'services.id', 'users.id', 'users.state')
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
        $result->save();

        $bid = Bid::where('user_id', $req->bidder_id)
            ->where('service_id', $req->service_id)
            ->where('freelancer_id', $req->freelancer_id)
            ->first();

        if ($bid) {
            $bid->status = 'completed';
            $bid->save();
        }

        $notification = Auth::user()->notifications()->findOrFail($req->notification_id);
        $notification->markAsRead();
        // Find the freelancer or user to notify
        $replybackbidder = User::find($req->bidder_id);

        // Send notification
        $replybackbidder->notify(new BiddingSuccessNotification($req->bidder_id, $req->service_id));

        // Flash a success message to the session (optional)
        session()->flash('success', 'Bidding successfully added!');

        // Redirect back or to another route
        return redirect()->back();



    }
}
