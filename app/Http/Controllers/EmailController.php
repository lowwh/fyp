<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class EmailController extends Controller
{
    public function sendEmail(Request $request, $id)
    {
        // Fetch the user or other data you need
        $user = User::findOrFail($id);

        // Send the email using Laravel's Mail facade
        Mail::to($user->email)->send(new \App\Mail\SendUserEmail($user));

        $request->session()->flash('status', 'Email sent successfully!');

        return redirect()->back();
    }
}
