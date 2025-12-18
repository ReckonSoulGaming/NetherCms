<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    protected $redirectTo = '/store';

   
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

   
    public function showLoginForm()
    {
        return view('auth.login');
    }

    
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return redirect()->intended($this->redirectTo);
        }

        return back()->withErrors([
            'email' => 'Wrong email or password',
        ]);
    }

   
    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}
