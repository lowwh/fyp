<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\service;
use Illuminate\Support\Facades\Validator;
use Auth;

class ServiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('operations.uploadService');
    }

    public function show()
    {
        $service = service::all();
        return view('operations.manageService', ['service' => $service]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $this->validator($request->all())->validate();



        $service = service::create($request->all());
        $service->user_id = Auth::id();
        $service->save();


        return redirect('/uploadService');


    }

    public function validator(array $data)
    {

        return Validator::make($data, [
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'servicetype' => 'required',


        ]);
    }

    public function showupdate($id)
    {
        $update = service::findOrFail($id);
        return view('operations.showupdate', ['update' => $update]);
    }

    public function edit(Request $req)
    {
        $update = service::findOrFail($req->id);
        $update->title = $req->title;
        $update->price = $req->price;
        $update->description = $req->description;
        $update->servicetype = $req->servicetype;
        $update->save();
        return redirect("/manageService");
    }


}
