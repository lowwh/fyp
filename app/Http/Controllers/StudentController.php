<?php

namespace App\Http\Controllers;
use App\Models\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        return Student::all();
    }


    public function store (Request $req){

        $this->validator($req->all())->validate();
        return Student::create($req->all());
    }


    public function update(Request $req, $id){
        $student = Student::findOrFail($id);

        return $student->update($req->all());
    }

    public function destroy($id)
    {
        $post=Student::findOrFail($id);
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
