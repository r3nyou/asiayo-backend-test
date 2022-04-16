<?php

namespace App\Exceptions;

use Exception;

class CurrencyException extends Exception
{
    protected $message = 'currency exception';

    public function getStatusCode()
    {
        return 400;
    }
}
