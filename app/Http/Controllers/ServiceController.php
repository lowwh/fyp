<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\service;
use App\Models\user;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('operations.uploadService');
    }

    public function show()
    {

        $userid = Auth::id();
        //$service = service::all();
        $service = service::leftJoin('users', 'users.id', '=', 'services.user_id')

            ->select('services.*', 'users.image_path as userimage')
            ->where('services.user_id', $userid)

            ->get();

        return view('operations.manageService', ['service' => $service]);
    }

    public function store(Request $request)
    {

        $user = Auth::user();
        // Validate the incoming request data
        $this->validator($request->all())->validate();

        $imagepath = null;
        if ($request->hasFile('image')) {
            $imagepath = $request->file('image')->store('images', 'public'); // Save image to 'storage/app/public/images'
        }

        //$service = service::create($request->all());
        $service = Service::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'servicetype' => $request->input('servicetype'),
            'price' => $request->input('price'),
            'image_path' => $imagepath,

        ]);
        $service->user_id = Auth::id();
        $service->user_name = $user->name;

        $service->save();


        return redirect('/manageService');


    }



    public function validator(array $data)
    {

        return Validator::make($data, [
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'servicetype' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',


        ]);
    }

    public function showupdate($id)
    {
        $update = service::findOrFail($id);
        return view('operations.showupdate', ['update' => $update]);
    }

    public function edit(Request $req)
    {
        // Find the service by ID or fail
        $update = Service::findOrFail($req->id);

        // Update the basic fields
        $update->title = $req->title;
        $update->price = $req->price;
        $update->description = $req->description;
        $update->servicetype = $req->servicetype;

        if ($req->hasFile('image')) {
            // Store the new image and get its path
            $imagepath = $req->file('image')->store('images', 'public');

            // Update the user's image_path
            $update->image_path = $imagepath;

            // Save the changes to the user




        }

        // Save the changes to the service
        $update->save();

        // Redirect back to the manage service page
        return redirect("/manageService");
    }


    public function destroy(Request $request)
    {
        $service = service::findOrFail($request->id);
        $service->delete();
        return redirect('/manageService');
    }



    public function acceptService($id)
    {
        if (Auth::user()->has_rejected_service) {
            return redirect()->route('home')->with('error', 'You cannot accept a new service after rejecting one.');
        }

        $service = Service::find($id);
        $service->status = 'Accepted';
        $service->save();

        return redirect()->route('services.index')->with('status', 'Service accepted.');
    }



}
