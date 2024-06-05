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
}
