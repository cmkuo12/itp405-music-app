<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $loginWasSuccessful = Auth::attempt([ //returns bool
            'email' => $request->input('email'),
            'password' => $request->input('password'), //takes raw password and checks to match the encrypted password in database
        ]); //check if valid credentials entered

        //does Auth::login for us
        
        if($loginWasSuccessful) {
            return redirect()->route('profile.index');
        } else {
            return redirect()->route('auth.loginForm')->with('error', 'Invalid credentials'); //use flash data for error
        }
    }

    public function logout()
    {
        Auth::logout(); //destroys session "session_destroy" in raw php
        return redirect()->route('invoice.index');
    }
}
