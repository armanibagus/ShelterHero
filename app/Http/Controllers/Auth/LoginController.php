<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
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
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function login(Request $request) {
        // get the input
        $input = $request->all();

        // validate input
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        // Login using username & email
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email':'username';
        if(auth()->attempt(array($fieldType => $input['username'],
                                'password' => $input['password']))) {
            if (auth()->user()->role == 'user') {
                return redirect()->route('home-user');
            } else if (auth()->user()->role == 'volunteer') {
                return redirect()->route('home-volunteer');
            } else if (auth()->user()->role == 'pet_shelter') {
                return redirect()->route('home-pet-shelter');
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('login')->with('error', "Oops! Username & Password doesn't match!");
        }
    }
}
