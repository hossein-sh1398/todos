<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->only('showForm', 'login');
        $this->middleware('logout')->only('auth');
    }

    public function showForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        if (auth()->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return redirect('/');
        }

        return redirect()->back()->withErrors([
            'email' => 'نام کاربری یا رمز عبور اشتباه می باشد'
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return redirect('/');
    }
}
