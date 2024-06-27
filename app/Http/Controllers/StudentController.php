<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\service;
use App\Models\rating;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the 'state' parameter from the request
        $state = $request->input('state');

        // Initialize the query
        $query = DB::table('users')
            ->leftJoin('services', 'services.user_id', '=', 'users.id')
            ->select('users.state', 'users.id as main_id', 'services.id as serviceid', 'services.title', 'services.servicetype', 'services.price', 'services.image_path as serviceimage', 'services.image_path2 as serviceimage2', 'users.name', 'users.email', 'users.age', 'users.gender', 'users.image_path', 'users.freelancer_id')
            ->where('users.role', 'freelancer')
            ->whereNotNull('services.title')
            ->whereNotNull('services.description');

        // Apply the state filter if provided
        if ($state) {
            $query->where('users.state', $state);
        }

        // Execute the query and paginate the results
        $freelancers = $query->paginate(6);

        // Fetch distinct states for the filter dropdown
        $states = DB::table('users')
            ->where('role', 'freelancer')
            ->distinct()
            ->pluck('state');

        // Return the view with freelancers and states data
        return view('home', ['freelancers' => $freelancers, 'states' => $states]);
    }


    public function viewprofile($id)
    {
        $user = DB::table('users')
            ->leftJoin('services', 'services.user_id', '=', 'users.id')
            ->select('users.*', 'services.id as service_id', 'services.title', 'services.description')
            ->where('users.id', $id)
            ->get();

        return view('operations.viewprofile', ['user' => $user]);
    }


    public function viewservice($id, $gig_id)
    {
        $users = User::join('services', 'users.id', '=', 'services.user_id')


            ->select('users.*', 'services.title', 'services.description', 'services.price', 'users.image_path as userimage', 'services.image_path as serviceimage', DB::raw("DATE(users.created_at) as user_created_date"))
            ->where('services.user_id', $id)
            ->where('services.id', $gig_id) // Assuming gig_id is the ID of the service
            ->get();




        $comments = Rating::leftJoin('users', 'users.id', '=', 'ratings.user_id')


            ->select('users.*', 'ratings.rating', 'ratings.reason')
            ->where('ratings.gig_id', $gig_id)


            ->get();

        return view('operations.viewservice', compact('users', 'comments'));
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
        $freelancer = User::findOrFail($id);

        return view('operations.showfreelancerupdate', ['freelancers' => $freelancer]);
    }

    public function update(Request $request)
    {

        // return $request ->id;
        $freelancer = User::findOrFail($request->id);
        if (Gate::allows('isAdmin')) {
            $freelancer->update($request->all());
            //  return response()->json(['status'=> 'success']);
            return redirect('/managestudent');
        } else {
            // User is not authorized, handle accordingly (e.g., redirect with error)
            return redirect()->back()->withErrors(['error' => 'Unauthorized action.']);
        }
    }


    public function destroy($id)
    {
        $freelancer = User::findOrFail($id);
        // Check if the user is authorized to delete the result
        if (Gate::allows('isAdmin')) {
            $freelancer->delete();
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


    public function sort(Request $request)
    {
        $state = $request->input('state');
        $query = User::query();

        if ($state) {
            $query->where('state', $state);
        }

        $freelancers = $query->paginate(10);

        // Fetch distinct states
        $states = User::select('state')->distinct()->pluck('state');

        return view('home', compact('freelancers', 'states'));
    }


}
