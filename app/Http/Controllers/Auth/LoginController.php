<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
    // protected $redirectTo = RouteServiceProvider::HOME;

    // protected function redirectTo(){
    //     if(Auth()->user()->user_type == 1){
    //         return route('admin.dashboard');
    //     }elseif(Auth()->user()->user_type == 2){
    //         return route('home');
    //     }
    // }

    protected function authenticated(){
        if(Auth::user()->user_type == 1){
            return redirect()->route('admin.dashboard');
        }elseif(Auth::user()->user_type == 2){
            return redirect()->intended('/');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {  
         Redirect::setIntendedUrl(url()->previous());
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
            if (Auth::user()->user_type == 1) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->user_type == 2) {
                return redirect()->intended('/');
            }
        } else {
            return redirect()->route('login')->with('error', 'These credentials do not match our records.');
        }
    }
}
