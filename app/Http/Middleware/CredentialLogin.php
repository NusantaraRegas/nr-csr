<?php

namespace App\Http\Middleware;

use App\Services\Auth\AuthContext;
use Closure;

class CredentialLogin
{
    /**
     * @var AuthContext
     */
    protected $authContext;

    public function __construct(AuthContext $authContext)
    {
        $this->authContext = $authContext;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->authContext->hasUser()) {
            return $next($request);
        }

        return redirect()->route('login')->with('credential', 'Silahkan login untuk memulai session anda');
    }
}
