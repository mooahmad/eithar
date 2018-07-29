<?php

namespace App\Exceptions;

use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     * @param Exception $exception
     * @return \Illuminate\Http\Response|mixed
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->view('errors.404', [], 404);
        }

        if ($exception instanceof HttpException) {
            return response()->view('errors.404', [], 404);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->view('errors.401', [], 401);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->view('errors.403', [], 403);
        }

        if ($exception instanceof TokenMismatchException) {
            return response()->view('errors.400', [], 400);
        }

        if ($exception instanceof ValidationException) {
            return response()->view('errors.404', [], 404);
        }

        if ($exception instanceof QueryException) {
            return response()->view('errors.404', [], 404);
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

        if ($exception instanceof ModelNotFoundException) {
            return response()->view('errors.404', [], 404);
        }

        if ($exception instanceof HttpException) {
            return response()->view('errors.404', [], 404);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->view('errors.401', [], 401);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->view('errors.403', [], 403);
        }

        if ($exception instanceof TokenMismatchException) {
            return response()->view('errors.400', [], 400);
        }

        if ($exception instanceof ValidationException) {
            return response()->view('errors.404', [], 404);
        }

        if ($exception instanceof QueryException) {
            return response()->view('errors.404', [], 404);
        }

        return parent::render($request, $exception);
    }
}
