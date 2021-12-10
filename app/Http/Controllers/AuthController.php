<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class AuthController extends Controller
{
    /**
	 * login page
	 */
	public function index()
	{
		return inertia('Auth/Login');
	}

	/**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
		

        if (Auth::attempt($credentials, request()->remember)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
