<?php

namespace M2rk\Taskforce\exceptions;

use Exception;

class StatusBaseException extends Exception
{
    public function userMessage()
    {
        echo 'Произошла ошибка статуса:' . $this->getMessage();
    }
}
