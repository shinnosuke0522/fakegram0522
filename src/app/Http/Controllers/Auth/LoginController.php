<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Socialite;
use Auth;
use App\User;


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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {   
        $githubUser = Socialite::driver('github')->stateless()->user();
        $user = User::where(['email' => $githubUser->getEmail()])->first();

        if($user){
            // the user has already account
            Auth::login($user);
            return redirect($this->redirectTo);

        } else {
            // if the user doesn't have account

            // register the user's information
            $newUser = new User;
            $newUser->email = $githubUser->getEmail();
            $newUser->provider_id = $githubUser->getId();

            if(!$githubUser->name){
                $newUser->name = $githubUser->getNickname();
            }else{
                $newUser->name = $githubUser->getName();
            }

            $newUser->save();

            // log in
            Auth::login($newUser);
            return redirect($this->redirectTo);
            
        }
        
    }
}
