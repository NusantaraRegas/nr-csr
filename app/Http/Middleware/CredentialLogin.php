<?php

namespace App\Http\Middleware;

use Closure;

class CredentialLogin
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

        if (!empty(session('user'))) {
            return $next($request);
        }

        return redirect()->route('login')->with('credential', 'Silahkan login untuk memulai session anda');
    }
}
