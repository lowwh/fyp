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
