<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class IsLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        if(Auth::user()){
            if (Auth::user()->role == 5) {
                Session::flush();
                Auth::logout();
                return Redirect::to('/login')->with('Error', 'Not Authorized to Login');
            } else {
                return $next($request);
            }
        }else{
            return response()->json("Not authorized - Login");
        }
        
    }
}
