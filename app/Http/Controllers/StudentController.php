<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        return User::all();
    }


    public function store (Request $req){

        $this->validator($req->all())->validate();
        return User::create($req->all());
    }


    public function update(Request $req, $id){
        $user = User::findOrFail($id);

        return $user->update($req->all());
    }

    public function destroy($id)
    {
        $post=User::findOrFail($id);
        $post->delete();
        return 204;
    }


    public function validator(array $data){

        return Validator::make($data, [
            'name'=> 'required',
            'email'=>'required|email',
            'age'=>'required',
            'gender'=>'required'

        ]);

    }
}
