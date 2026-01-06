<?php

namespace App\Http\Middleware;

use Closure;

class OnlyApprover
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
        if (session('user')->role == 'Manager' or session('user')->role == 'Supervisor 1'){
            return $next($request);
        }else{
            abort(403);
        }
    }
}
