<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        return view('operations.manageprofile', ['user' => $user]);


    }



    public function show($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        return view('operations.showupdateprofile', ["users" => $user]);


    }

    public function update(Request $request)
    {


        $user = User::findOrFail($request->id);
        // Check if the request has an image file

        $user->name = $request->name;
        $user->age = $request->age;
        $user->email = $request->email;
        $user->save();
        if ($request->hasFile('image')) {
            // Store the new image and get its path
            $imagepath = $request->file('image')->store('images', 'public');

            // Update the user's image_path
            $user->image_path = $imagepath;

            // Save the changes to the user
            $user->save();

            return redirect('/manageprofile');
        } else {
            return redirect('/manageprofile');
        }
    }

}
