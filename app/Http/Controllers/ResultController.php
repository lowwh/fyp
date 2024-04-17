<?php

namespace App\Http\Controllers;

use App\Models\Result;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResultController extends Controller
{
    public function index()
    {
        $results = Result::leftJoin('students', 'results.student_id', '=', 'students.student_id')
            ->select('results.*', 'students.name')
            ->get();

        return response()->json($results);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'student_id' => 'required',
            'course' => 'required|string',
            'result_score' => 'required|numeric',
        ]);

        // Check if a result with the same student ID and course already exists
        $existingResult = Result::where('student_id', $validatedData['student_id'])
            ->where('course', $validatedData['course'])
            ->first();

        if ($existingResult) {
            return response()->json(['error' => 'Result already exists for this student and course.'], 400);
        }

        // Store the result in the database
        $result = new Result();
        $result->student_id = $validatedData['student_id'];
        $result->course = $validatedData['course'];
        $result->result_score = $validatedData['result_score'];
        $result->save();

        return response()->json(['message' => 'Result added successfully', 'result' => $result], 201);
    }

    // ResultController.php
    public function search(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'student_id' => 'required',
        ]);

        // Search for the results by student ID
        $results = Result::leftJoin('students', 'results.student_id', '=', 'students.student_id')
            ->select('results.course', 'results.result_score', 'students.name', 'results.student_id')
            ->where('results.student_id', $validatedData['student_id'])
            ->get();

        if ($results->isEmpty()) {
            // No results found
            $errorMessage = 'No results found for this student ID';
            return view('operations.showresult', ['error' => $errorMessage]);
        } else {
            // Results found
            return view('operations.showresult', ['results' => $results]);
        }
    }



    public function update(Request $request, $id)
    {
        $result = Result::findOrFail($id);
        $result->result_score = $request->input('result_score');
        $result->save();

        return response()->json(['message' => 'Result updated successfully', 'result' => $result], 200);
    }

    public function destroy($id)
    {
        $result = Result::findOrFail($id);
        $result->delete();

        return response()->json(['message' => 'Result deleted successfully'], 200);
    }
}
