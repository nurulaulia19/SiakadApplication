<?php

namespace App\Http\Controllers\Auth;

use App\Models\DataUser;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{

    public function login(Request $request)
{
    $credentials = $request->validate([
        'user_name' => 'required',
        'user_password' => 'required',
    ]);
    
    $user = DataUser::where('user_name', $credentials['user_name'])->first();
    
    if ($user && Hash::check($credentials['user_password'], $user->user_password)) {
        Auth::login($user);
        return redirect()->intended('admin/home');
    }
    
    return back()->withErrors([
        'user_name' => 'Invalid credentials.',
    ]);
    // $credentials = $request->validate([
    //     'user_name' => 'required',
    //     'user_password' => 'required',
    // ]);

    // $user = DataUser::where('user_name', $credentials['user_name'])->first();

    // if ($user) {
    //     Auth::login($user);
    //     return redirect()->intended('admin/home');
    // }

    // return back()->withErrors([
    //     'user_name' => 'Invalid credentials.',
    // ]);
}
//     public function login(Request $request)
// {
//     $username = $request->input('username');
//     $password = $request->input('password');

//     if (Auth::attempt(['username' => $username, 'password' => $password])) {
//         $request->session()->regenerate();

//         return redirect()->intended('/admin.home');
//     }

//     return back()->withErrors([
//         'username' => 'Invalid credentials.',
//     ]);
// }

    
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
 
//     public function login(Request $request)
// {
//     // Validasi login
//     $credentials = $request->only('email', 'password');
//     if (Auth::attempt($credentials)) {
//         // Jika login berhasil, arahkan ke halaman home
//         return redirect()->route('home');
//     } else {
//         // Jika login gagal, kembali ke halaman login dengan pesan error
//         return redirect()->back()->with('error', 'Invalid credentials');
//     }
// }

    public function showLoginForm() {
        return view('auth.login');
    }

    

    
}
