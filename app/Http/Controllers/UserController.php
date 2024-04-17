<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function indexLecturers()
    {
        $lecturers = User::where('role', 'lecturer')->paginate(10);
        return view('operations.managelectureruser', ['lecturers' => $lecturers]);
    }

    public function indexAdmins()
    {
        $admins = User::where('role', 'admin')->paginate(10);
        return view('operations.manageadminuser', compact('admins'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $updated = $user->update($request->except('password'));

    if ($updated) {
        return redirect()->back()->with('success', 'User details updated successfully.');
    } else {
        return redirect()->back()->with('error', 'Failed to update user details.');
    }
}

public function changePassword(Request $request, $id)
{
    $user = User::findOrFail($id);

    $user->password = Hash::make($request->password);
    $updated = $user->save();

    if ($updated) {
        return redirect()->back()->with('success', 'Password changed successfully.');
    } else {
        return redirect()->back()->with('error', 'Failed to change password.');
    }
}

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
