<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventBlockedUsers
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
        //Auth get access to user by calling user method
        if (Auth::user()->is_blocked) {
            return redirect()->route('blocked');
        }
        //let request pass through if user is not blocked
        return $next($request);
    }
}
