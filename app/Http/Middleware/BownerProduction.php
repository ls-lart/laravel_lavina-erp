<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class BownerProduction
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
        if (Auth::check()) {
            if ((Auth::user()->isProduction() || Auth::user()->isBowner()) {
                return $next($request);
            }
        }
        return redirect('/login');
    }
}
