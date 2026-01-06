<?php

namespace App\Http\Middleware;

use Closure;

class OnlyLegal
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
        if (session('user')->role == 'Admin' or session('user')->role == 'Legal'){
            return $next($request);
        }else{
            abort(403);
        }
    }
}
