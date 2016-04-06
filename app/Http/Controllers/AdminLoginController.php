<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\User;

class AdminLoginController extends Controller {
    protected $loginPath = '/administration';
    protected $redirectTo = '/admin/dashboard';
    protected $redirectAfterLogout = '/';
    

    public function dashboard(){
        return view('dashboard.index');
    }

    public function getadminlogin(){
        if(Auth::check()){
            return redirect('/admin/dashboard');
        }
        return view('login.login');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function postLogin()
    {
        $username=Request::input('username');
        $password=Request::input('password');
        $field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $email  = $username,
            $pass   = \Hash::make($password)
        ];

        if(Auth::attempt([$field=>$username, 'password'=>$password])){
            return redirect('/admin/dashboard');
        } else {
            return redirect('/administration');
        }
    }


    public function logout(){
        Auth::logout();

        return redirect('/administration');
    }

}
