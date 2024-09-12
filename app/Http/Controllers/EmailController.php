<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\SendUserEmail;
class EmailController extends Controller
{
    public function sendEmail(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'emailContent' => 'required|string|max:5000',
        ]);

        // Fetch the user or other data you need
        $user = User::findOrFail($id);

        // Send the email using Laravel's Mail facade
        Mail::to($user->email)->send(new SendUserEmail($user, $request->input('emailContent')));

        // Flash message to session
        $request->session()->flash('status', 'Email sent successfully!');

        return redirect()->back();
    }
}
