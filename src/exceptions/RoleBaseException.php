<?php

namespace M2rk\Taskforce\exceptions;

use Exception;

class RoleBaseException extends Exception
{
    public function userMessage()
    {
        echo 'Произошла ошибка роли:' . $this->getMessage();
    }
}
