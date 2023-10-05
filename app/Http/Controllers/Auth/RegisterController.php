<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Providers\RouteServiceProvider;
use App\Models\Verifytoken;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
    protected $redirectTo = '/admin/home';

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
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:3']
            // 'password' => ['required', 'string', 'min:8'],
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#?!@$%^&*-]).{6,}$/'
            ],    
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user =  User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),

            // 'name' => $data['name'],
            // 'email' => $data['email'],
            // 'dateofbirth' => $data['dateofbirth'],
            // 'gender' => $data['gender'],
            // 'password' => Hash::make($data['password']),
        ]);

        // $validToken = rand(10000, 99999);
        // $get_token = new Verifytoken();
        // $get_token->token = $validToken;
        // $get_token->email = $data['email'];
        // $get_token->save();
        // $get_user_email = $data['email'];
        // $get_user_name = $data['name'];
        // Mail::to($data['email'])->send(new WelcomeMail($get_user_email, $validToken, $get_user_name));

        return $user;
    }

    public function index() {
        
    }

    public function showRegisterForm() {
        return view('auth.register');
    }
}
