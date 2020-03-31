<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            return response()->view(
                'error-page',
                [
                    'error' => Response::HTTP_NOT_FOUND,
                    'text' =>'Resource not found'
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->view(
                'error-page',
                [
                    'error' => Response::HTTP_METHOD_NOT_ALLOWED,
                    'text' => 'Method not allowed'
                ],
                Response::HTTP_METHOD_NOT_ALLOWED
            );
        }

        if ($exception instanceof ValidationException) {
            return response()->view(
                'error-page',
                [
                    'error' => Response::HTTP_BAD_REQUEST,
                    'text' => 'Malformed Request'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return response()->view(
            'error-page',
            [
                'error' => $exception->getCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR,
                'text' => $exception->getMessage(),
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
