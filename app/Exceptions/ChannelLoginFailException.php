<?php

namespace App\Exceptions;

use Exception;


class ChannelLoginFailException extends Exception
{
    public function __construct($message = "", $code = 403)
    {
        parent::__construct($message, $code);
    }
}
