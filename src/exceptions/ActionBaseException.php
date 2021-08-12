<?php

namespace M2rk\Taskforce\exceptions;

use Exception;

class ActionBaseException extends Exception
{
    public function userMessage()
    {
        echo 'Произошла ошибка действия:' . $this->getMessage();
    }
}
