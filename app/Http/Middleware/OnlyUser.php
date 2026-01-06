<?php

namespace App\Http\Middleware;

use Closure;

class OnlyUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (in_array(session('user')->role, ['Admin', 'Manager', 'Inputer', 'Supervisor 1', 'Corporate Secretary', 'Budget', 'Finance', 'Payment', 'Subsidiary']))
        {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
