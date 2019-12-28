<?php

namespace App\Http\Middleware;

use Closure;

class Debugbar
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
        if (auth()->user() && in_array(auth()->id(), [1,0])) {
            \Debugbar::enable();
        }
        else {
            \Debugbar::disable();
        }       

        return $next($request);
    }
}
