<?php

namespace App\Http\Middleware;

use Closure;

class OnlyExporter
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
        if (session('user')->role == 'Payment' or session('user')->role == 'Admin'){
            return $next($request);
        }else{
            abort(403);
        }
    }
}
