<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;

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
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
//        if($exception instanceof \PDOException) {
//            // script dibawah bisa disesuaikan return view('errors.503') juga bsa
//            abort(500);
//        }

        return parent::render($request, $exception);
    }
}
