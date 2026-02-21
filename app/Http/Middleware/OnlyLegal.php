<?php

namespace App\Http\Middleware;

use App\Services\Auth\AuthContext;
use Closure;

class OnlyLegal
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
        if ($this->authContext->hasAnyRole(['Admin', 'Legal'])) {
            return $next($request);
        }

        abort(403);
    }
}
