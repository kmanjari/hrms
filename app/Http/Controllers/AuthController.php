<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('hrms.auth.login');
    }

    public function doLogin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        if(\Auth::attempt(['email' => $email, 'password' => $password]))
        {
            return redirect()->to('welcome');
        }
        else
        {
            return redirect()->to('error');
        }
    }

    public function doLogout()
    {
        \Auth::logout();
        return redirect()->to('/');
    }

    public function dashboard()
    {
        return view('hrms.dashboard');
    }

    public function welcome()
    {
        return view('hrms.auth.welcome');
    }

    public function error()
    {
        return view('hrms.auth.error');
    }

    public function doRegister()
    {
        return view('hrms.auth.register');
    }

    public function calendar()
    {
        return view('hrms.auth.calendar');
    }
}
