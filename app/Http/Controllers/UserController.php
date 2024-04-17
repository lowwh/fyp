<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function update(Request $req, $id)
{
    $user = User::findOrFail($id);

    $updated = $user->update($req->all());

    if ($updated) {
        return redirect()->back()->with('success', 'User updated successfully.');
    } else {
        return redirect()->back()->with('error', 'Failed to update user.');
    }
}

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    
}
