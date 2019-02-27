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
        return Socialite::driver('github')->scopes(['read:user', 'public_repo'])->redirect(); 
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)// 追加！
    {
        $github_user = Socialite::driver('github')->user();
        $app_user = User::where(['email' => $github_user->getEmail()])->first();

        if(empty($app_user)){
            // if the user doesn't have account
            $new_user = new User;
            $new_user->email = $github_user->getEmail();
            $new_user->provider_id = $github_user->getId();

            if(!$github_user->name){
                $new_user->name = $github_user->getNickname();
            }else{
                $new_user->name = $github_user->getName();
            }

            $new_user->save();
            Auth::login($new_user);
        } else {
            // if the user has already an account
            Auth::login($app_user);
        }

        $request->session()->put('github_token', $github_user->token);
        
        return redirect('github');
    }
 
}
