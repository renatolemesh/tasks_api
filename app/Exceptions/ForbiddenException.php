<?php

namespace App\Exceptions;

use Exception;

class ForbiddenException extends Exception
{
    protected $message = 'Forbidden';

    public function render($request)
    {
        return response()->json([
            'message' => $this->message
        ], 403);
    }
}
