<?php

namespace App\Http\Middleware;

use Closure;

class OnlySubsidiary
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
        if (session('user')->role == 'Admin' or session('user')->role == 'Subsidiary' or session('user')->role == 'Budget'){
            return $next($request);
        }else{
            abort(403);
        }
    }
}
