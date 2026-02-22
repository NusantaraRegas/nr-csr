<?php

namespace App\Exceptions;

use App\Support\ApiResponse;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($this->shouldReport($exception)) {
            $request = request();
            $sessionUser = null;
            if ($request && method_exists($request, 'hasSession') && $request->hasSession()) {
                $sessionUser = $request->session()->get('user');
            }

            Log::error('critical_exception', [
                'exception_class' => get_class($exception),
                'message' => $exception->getMessage(),
                'url' => $request ? $request->fullUrl() : null,
                'method' => $request ? $request->method() : null,
                'actor_username' => is_object($sessionUser) ? ($sessionUser->username ?? null) : null,
                'actor_role' => is_object($sessionUser) ? ($sessionUser->role ?? null) : null,
            ]);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($this->isApiRequest($request)) {
            if ($exception instanceof ValidationException) {
                return ApiResponse::error(
                    'Validasi gagal.',
                    422,
                    'VALIDATION_ERROR',
                    $exception->errors()
                );
            }

            if ($exception instanceof AuthenticationException) {
                return ApiResponse::error('Unauthenticated.', 401, 'UNAUTHENTICATED');
            }

            if ($exception instanceof AuthorizationException) {
                return ApiResponse::error('Forbidden.', 403, 'FORBIDDEN');
            }

            if ($exception instanceof HttpExceptionInterface) {
                $status = $exception->getStatusCode();
                $message = $exception->getMessage();

                if ($message === '') {
                    $message = Response::$statusTexts[$status] ?? 'HTTP error';
                }

                return ApiResponse::error($message, $status, 'HTTP_' . $status);
            }

            return ApiResponse::error(
                config('app.debug') ? $exception->getMessage() : 'Internal server error.',
                500,
                'INTERNAL_SERVER_ERROR'
            );
        }

        return parent::render($request, $exception);
    }

    private function isApiRequest($request)
    {
        return $request->is('api/*') || $request->expectsJson();
    }
}
