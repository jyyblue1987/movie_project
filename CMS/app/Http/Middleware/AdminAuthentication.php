<?php namespace App\Http\Middleware;

use Closure;
use Auth;
class AdminAuthentication {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {	
        if (!Auth::check())
        { 
            return redirect()->route('login-admin');
        }

        return $next($request);
    }
}