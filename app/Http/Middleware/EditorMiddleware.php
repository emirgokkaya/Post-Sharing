<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EditorMiddleware
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
            if ((Auth()->user()->role === "editor") || (Auth()->user()->role === "admin")) {
                if (Auth()->user()->state === 1)
                    return $next($request);
                else{
                    Auth::logout();
                    return redirect()->route('login')->with('message', 'Account Access Denied')->with('status', 'danger');
                }
            } else {
                Auth::logout();
                return redirect()->route('login')->with('message', 'User role is blocking access, please contact admin')->with('status', 'warning');
            }
        } else {
            Auth::logout();
            return redirect('/login');
        }
    }
}
