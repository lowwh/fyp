<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    public function index()
    {

        //show using Freelancer.js
        // Fetch all users where the role is 'freelancer'
        $freelancers = User::where('role', 'freelancer')->get();

        // Return the fetched freelancers
        return $freelancers;

        // If you want to pass the data to a view, you can uncomment the following line:
        // return view('operations.managestudent', ['students' => $freelancers]);
    }



    public function managefreelancer()
    {
        //using to show under freelancer -> managefreelancer
        $freelancers = User::where('role', 'freelancer')->get();
        return view('operations.managestudent', ['students' => $freelancers]);

    }






    public function store(Request $request)
    {


        // Validate the incoming request data
        $this->validator($request->all())->validate();


        $existingResult = Student::where('student_id', $request['student_id'])->first();

        if ($existingResult) {
            return response()->json(['Error' => 'Student ID already exists. Please try again'], 400);
        } else {
            $student = new Student($request->all());
            // Associate the student with the currently authenticated user
            $student->user_id = Auth::id();
            $student->save();

            return redirect('/managestudent');
        }
    }


    public function show($id)
    {
        $student = Student::findOrFail($id);

        return view('operations.showupdate', ['student' => $student]);
    }

    public function update(Request $request)
    {

        // return $request ->id;
        $student = Student::findOrFail($request->id);
        if (Gate::allows('isAdmin')) {
            $student->update($request->all());
            //  return response()->json(['status'=> 'success']);
            return redirect('/managestudent');
        } else {
            // User is not authorized, handle accordingly (e.g., redirect with error)
            return redirect()->back()->withErrors(['error' => 'Unauthorized action.']);
        }
    }


    public function destroy($id)
    {
        $post = Student::findOrFail($id);
        // Check if the user is authorized to delete the result
        if (Gate::allows('isAdmin')) {
            $post->delete();
            return redirect()->back()->with('success', 'Result deleted successfully.');
        } else {
            // User is not authorized, handle accordingly (e.g., redirect with error)
            return redirect()->back()->withErrors(['error' => 'Unauthorized action.']);
        }
    }


    public function validator(array $data)
    {

        return Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
            'age' => 'required',
            'gender' => 'required',
            'student_id' => 'required',

        ]);
    }
}
