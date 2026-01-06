<?php

namespace App\Http\Middleware;

use Closure;

class OnlyFinance
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
        if (session('user')->role == 'Admin' or session('user')->role == 'Finance' or session('user')->role == 'Budget' or session('user')->role == 'Payment' or session('user')->role == 'Subsidiary'){
            return $next($request);
        }else{
            abort(403);
        }
    }
}
