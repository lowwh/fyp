<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home'; // Change this to your desired redirect route

    public function __construct()
    {
        // Uncomment this if you want to restrict registration to guests only
        // $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        // Make serviceType required only for freelancers
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer'],
            'gender' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'state' => ['required'],
            'language' => ['required'],
            'role' => ['required'], // Ensure role is validated
            'serviceType' => ['required_if:role,freelancer'], // Conditionally required
            'freelancerId' => ['required_if:role,freelancer'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'age' => $data['age'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'state' => $data['state'],
            'language' => $data['language'],
            'role' => $data['role'],
            'serviceType' => $data['role'] === 'freelancer' ? $data['serviceType'] : null, // Set to null if not a freelancer
            'freelancer_id' => $data['role'] === 'freelancer' ? $data['freelancerId'] : null, // Set to null if not a freelancer
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
