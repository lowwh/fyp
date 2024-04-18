<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AttendanceController extends Controller
{
    //
    public function index()
    {
        try {
            // Fetch all attendance records joined with student names
            $attendances = Attendance::leftJoin('students', 'attendances.student_id', '=', 'students.student_id')
                ->select('attendances.*', 'students.name')
                ->get();

            // Pass the attendance data to the view
            return view("operations.manageattendance", compact('attendances'));
        } catch (\Exception $e) {
            // Log or handle the exception
            dd($e->getMessage()); // Output the error message for debugging
        }
    }


    public function showAddAttendanceForm()
    {
        $students = Student::all(); // Fetch all students from the database

        return view("operations.addattendance", compact('students'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'student_id' => 'required',
            'attendance' => 'required|numeric',
        ]);

        // Create new attendance if no existing attendance found
        $attendance = new Attendance();
        $attendance->student_id = $validatedData['student_id'];
        $attendance->attendance = $validatedData['attendance'];
        $attendance->save();

        return redirect()->back()->with('success', 'Attendance added successfully');
    }

    public function update(Request $request, $id)
    {
        $result = Attendance::findOrFail($id);
        $result->attendance = $request->input('attendance');
        $result->save();

        return redirect('/manageattendance');
    }

    public function destroy($id)
    {
        $result = Attendance::findOrFail($id);
        // Check if the user is authorized to delete the result
        if (Gate::allows('isAdmin')) {
            $result->delete();
            return redirect()->back()->with('success', 'Result deleted successfully.');
        } else {
            // User is not authorized, handle accordingly (e.g., redirect with error)
            return redirect()->back()->withErrors(['error' => 'Unauthorized action.']);
        }
    }
}
