<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth()->user())
        {
            if ((Auth()->user()->role === "admin" || Auth()->user()->role === "super_admin")) {
                if (Auth()->user()->state === 1)
                    return $next($request);
                else{
                    Auth::logout();
                    return redirect()->route('login')->with('message', 'Account Access Denied')->with('status', 'danger');
                }
            } else {
                /*Auth::logout();*/
                return redirect()->route('myprofile')->with('message', 'User role is blocking access, please contact admin')->with('status', 'warning');
            }
        } else {
            Auth::logout();
            return redirect('/login');
        }
    }
}
