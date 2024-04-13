<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\notices;

class noticeController extends Controller
{
    function shownotice()
    {
        $data = notices::paginate(5);
        return view('operations.managenotice',['notices'=>$data]);
    }

    function addnotice(Request $req)
    {
        $Notice = new notices;
        $Notice->notice_title = $req->notice_title;
        $Notice->notice_content = $req->notice_content;
        $Notice->save();
        return redirect("addnotice");
    }

    function deletenotice($id)
    {
        $data = notices::find($id);
        $data->delete();
        return redirect("managenotice");
    }

    function editnotice(Request $req)
    {
        $data = notices::find($req->id);
        $data->notice_title = $req->notice_title;
        $data->notice_content = $req->notice_content;
        $data->save();
        return redirect("managenotice");
    }
}
