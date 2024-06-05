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
        $users = User::where('role', 'user')->paginate(10);
        return view('operations.managelectureruser', ['users' => $users]);
    }

    public function indexAdmins()
    {
        $admins = User::where('role', 'admin')->paginate(10);
        return view('operations.manageadminuser', compact('admins'));
    }

    public function indexFreelancer()
    {
        $freelancers = User::where('role', 'freelancer')->paginate(10);
        return view('operations.managefreelanceruser', ['freelancers' => $freelancers]);
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

    public function changePassword(Request $request)
    {
        $user = User::findOrFail($request->id);

        $user->password = Hash::make($request->password);
        $updated = $user->save();

        if ($updated) {
            return redirect()->back()->with('success', 'User details updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update user details.');
        }
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
