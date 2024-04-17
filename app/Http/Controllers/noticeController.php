<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;

class noticeController extends Controller
{
    function shownotice()
    {
        $data = Notice::paginate(5);
        return view('operations.managenotice', ['notices' => $data]);
    }

    public function welcome()
    {
        $notices = Notice::all(); // Fetch all notices from the database
        return view('welcome', ['notices' => $notices]); // Pass the notices data to the view
    }

    public function showonenotice($id)
    {
        $notice = Notice::findOrFail($id);
        return view('operations.shownotice', ['notice' => $notice]);
    }

    function addnotice(Request $req)
    {
        $notice = new Notice;
        $notice->user_id = Auth::id();
        $notice->notice_title = $req->notice_title;
        $notice->notice_content = $req->notice_content;
        $notice->save();
        return redirect("managenotice");
    }

    function deletenotice($id)
    {
        $data = Notice::find($id);
        $data->delete();
        return redirect("managenotice");
    }

    function editnotice(Request $req)
    {
        $data = Notice::find($req->id);
        $data->notice_title = $req->notice_title;
        $data->notice_content = $req->notice_content;
        $data->save();
        return redirect("managenotice");
    }
}
