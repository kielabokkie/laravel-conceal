<?php

namespace Kielabokkie\LaravelConceal\Exceptions;

use Exception;
use Throwable;

class NotSupportedException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = 'Only Collections or Arrays are supported';

        parent::__construct($message, $code, $previous);
    }
}
