<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     * @return \Illuminate\Http\Response
     */

    public function render($request, Throwable $exception)
    {
        switch ($exception) {
            case $exception instanceof InvalidFileException:
                return $this->response('Only excel files are allowed', Response::HTTP_BAD_REQUEST);
                break;

            case $exception instanceof EmptySheetException:
                return $this->response('Empty sheet cannot be uploaded', Response::HTTP_BAD_REQUEST);
                break;

            case $exception instanceof NoContractFoundException:
                return $this->response('No contract found', Response::HTTP_NOT_FOUND);
                break;

            default:
                return parent::render($request, $exception);
        }
    }

    private function response($message, $code)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }
}
