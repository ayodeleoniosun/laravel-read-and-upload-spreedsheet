<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class FileTooLargeException extends Exception
{
    protected $message;

    public function __construct($message)
    {
        parent::__construct($message);
    }

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return response()->json([
            'status' => 'error',
            'message' => $this->message,
        ], Response::HTTP_BAD_REQUEST);
    }
}
