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
        // Retrieve the authenticated user's ID
        $userid = Auth::user()->id;

        // Find the user record
        $user = User::findOrFail($userid);

        // Add the requested amount to the existing balance
        $user->balance += $req->amount;

        // Save the updated balance
        $user->save();

        // Redirect to the manage profile page
        return redirect('/manageprofile');
    }



    public function index()
    {
        $user = Auth::user();
        $userId = Auth::id();


        $spend = service::join('ratings', 'ratings.gig_id', '=', 'services.id', )
            ->join('users', 'users.id', '=', 'ratings.user_id')
            ->join('results', 'results.gig_id', '=', 'services.id')



            ->select('services.price', 'services.image_path', 'ratings.expectation', 'ratings.suggestion', 'ratings.rating', 'ratings.reason', 'ratings.gig_id', 'users.image_path as userimage', 'results.progress')
            ->where('results.progress', 100)
            ->where('users.id', $userId)
            ->where('results.bidder_id', $userId)
            ->distinct()

            ->get();



        $earn = DB::table('invoices')
            ->join('services', 'services.id', '=', 'invoices.service_id')
            ->join('users', 'users.id', '=', 'services.user_id')
            ->select('invoices.amount as amountEarn')
            ->where('invoices.serviceOwnerId', $userId)
            ->get();

        $service = DB::table('users')
            ->leftJoin('services', 'services.user_id', '=', 'users.id')
            ->select('users.*', 'services.id as service_id', 'services.title', 'services.description', 'services.servicetype', 'users.state', 'users.language')
            ->where('users.id', $userId)
            ->get();

        // $totalSpend = $spend->sum('price');
        $totalSpend = $user->total_earn;
        $totalEarn = $user->total_earn;




        $pastTransactions = Invoice::where('user_id', Auth::id())->get();
        return view('operations.manageprofile', ['user' => $user, 'totalSpend' => $totalSpend, 'totalEarn' => $totalEarn, 'pastTransactions' => $pastTransactions, 'service' => $service]);

    }



    public function show($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        return view('operations.showupdateprofile', ["users" => $user]);


    }

    public function update(Request $request, $id)
    {
        // Define validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'email' => 'required|email|unique:users,email,' . $id,
            'gender' => 'required|string|in:male,female,other', // Example gender options
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'serviceType' => 'required|string|max:255',
        ]);

        // Find the user by ID
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Update user details
        $user->name = $request->input('name');
        $user->age = $request->input('age');
        $user->email = $request->input('email');
        $user->gender = $request->input('gender');
        $user->serviceType = $request->input('serviceType');

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
            $user->image_path = $imagePath;
        }

        // Save changes
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }



}
