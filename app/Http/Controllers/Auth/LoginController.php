<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    
    protected $redirectTo = '/account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function login(Request $request)
    {
        //here it checking name form email field
       dd (auth()->attempt(['email' => $request['email'], 'password' => request('password')]));  
        $the_user = User::where('name','=',request('email'))->first();
        if($the_user){
            $request['email']=$the_user->email;
        }
        if (auth()->attempt(['email' => $request['email'], 'password' => request('password')]))
        //password is not hashed
        // so we should hash it here
        {
            // Authentication passed...
            return redirect('/account');
        }else{
            return $this->sendFailedLoginResponse($request);
        }
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
