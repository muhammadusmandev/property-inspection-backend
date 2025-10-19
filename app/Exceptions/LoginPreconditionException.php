<?php

namespace App\Exceptions;

use Exception;

class LoginPreconditionException extends Exception
{
    public string $flag;

    /**
     *
     * @param string $message
     * @param string $flag
     */
    public function __construct(string $message, string $flag)
    {
        parent::__construct($message);
        $this->flag = $flag;
    }
}
