<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    public function upbalance(Request $req)
    {
        $userid = Auth::user()->id;

        $balance = User::findOrFail($userid);
        $balance->balance = $req->amount;
        $balance->save();

        return redirect('/manageprofile');

    }


    public function index()
    {
        $user = Auth::user();
        $userId = Auth::id();


        $spend = DB::table('invoices')
            ->join('services', 'services.id', '=', 'invoices.service_id')
            ->join('users', 'users.id', '=', 'invoices.user_id')
            ->select('invoices.amount as amountSpend')
            ->where('invoices.user_id', $userId)
            ->get();



        $earn = DB::table('invoices')
            ->join('services', 'services.id', '=', 'invoices.service_id')
            ->join('users', 'users.id', '=', 'services.user_id')
            ->select('invoices.amount as amountEarn')
            ->where('invoices.serviceOwnerId', $userId)
            ->get();

        $totalSpend = $spend->sum('amountSpend');
        $totalEarn = $earn->sum('amountEarn');

        $pastTransactions = Invoice::where('user_id', Auth::id())->get();
        return view('operations.manageprofile', ['user' => $user, 'totalSpend' => $totalSpend, 'totalEarn' => $totalEarn, 'pastTransactions' => $pastTransactions]);

    }



    public function show($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        return view('operations.showupdateprofile', ["users" => $user]);


    }

    public function update(Request $request)
    {
        // Define validation rules
        $validate = [
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'email' => 'required|email|unique:users,email,',
            'gender' => 'required|string|in:male,female,other',
            'serviceType' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // Optional image validation
        ];

        // Validate the request data
        $validatedData = $request->validate($validate);

        // Find the user by ID
        $user = User::findOrFail($request->id);

        // Update user details
        $user->name = $validatedData['name'];
        $user->age = $validatedData['age'];
        $user->email = $validatedData['email'];
        $user->gender = $validatedData['gender'];
        $user->serviceType = $validatedData['serviceType'];

        // Check if the request has an image file
        if ($request->hasFile('image')) {
            // Store the new image and get its path
            $imagepath = $request->file('image')->store('images', 'public');

            // Update the user's image_path
            $user->image_path = $imagepath;
        }

        // Save the changes to the user
        $user->save();

        return redirect('/manageprofile')->with('success', 'Profile updated successfully!');
    }



}
