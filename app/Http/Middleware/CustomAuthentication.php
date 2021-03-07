<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) { //user is logged in
            return $next($request); //pass request to next piece of middleware
        } else {
            return redirect()->route('auth.loginForm'); //if not logged in, redirected to login page
        }
        
    }
}
