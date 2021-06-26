<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //se validan todos los campos del formulario enviado
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'photo' => ['required', 'mimes:jpeg,jpg,bmp,png'],
            'identification_number' => ['required', 'string', 'max:10', 'min:7'],
            'type_identification' => ['required', 'string', 'max:255'],
            'years' => ['required', 'string', 'max:2', 'min:1'],
            'favorite_language' => ['required', 'string', 'max:50'],
            'years_experience' => ['required', 'string', 'max:2', 'min:1'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'photo' => $data['photo'],
            'identification_number' => $data['identification_number'],
            'type_identification' => $data['type_identification'],
            'years' => $data['years'],
            'favorite_language' => $data['favorite_language'],
            'years_experience' => $data['years_experience'],
        ]);
    }
}
