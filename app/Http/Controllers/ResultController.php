<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Models\Result;
use App\Models\Student;
use App\Models\service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ResultController extends Controller
{
    public function index()
    {
        try {
            // Fetch all results joined with student names
            $results = Result::leftJoin('users', 'results.freelancer_id', '=', 'users.freelancer_id')
                ->select('results.*', 'users.name')
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
        $coursesOptions = ["Chemistry", "Mathematics", "Fundamentals of Programming", "Project Management"]; // Example courses options, replace with your actual data

        return view("operations.addresult", compact('freelancers', 'coursesOptions'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'selectFreelancerId' => 'required',
            'selectCourse' => 'required|string',
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
        $result->course = $validatedData['selectCourse'];
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

        // Search for the results by student ID
        // $results = DB::table('students') // Ensure you're using the correct table name here
        //     ->leftJoin('services', 'services.user_id', '=', 'students.user_id')
        //     ->select('services.servicetype', 'services.description', 'students.name', 'students.age')
        //     ->where('services.servicetype', $validatedData['servicetype'])
        //     ->distinct()
        //     ->get();

        $results = DB::table('services') // Ensure you're using the correct table name here
            ->select('services.servicetype', 'services.description', 'services.price', 'services.title')
            ->where('services.servicetype', $validatedData['servicetype'])
            ->distinct()
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
}
