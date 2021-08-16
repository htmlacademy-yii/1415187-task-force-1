<?php

namespace M2rk\Taskforce\validators;

use M2rk\Taskforce\exceptions\ActionBaseException;
use M2rk\Taskforce\exceptions\RoleBaseException;
use M2rk\Taskforce\models\User;

class ActionValidator
{
    /**
     * @throws RoleBaseException
     */
    public static function isExecutor($userId): void
    {
        if (!User::isExecutor($userId)) {
            throw new RoleBaseException('Текущий пользователь не является исполнителем.');
        }
    }

    /**
     * @throws RoleBaseException
     */
    public static function isCustomer($userId): void
    {
        if (!User::isCustomer($userId)) {
            throw new RoleBaseException('Ошибка: Текущий пользователь не является заказчиком.');
        }
    }

    /**
     * @throws ActionBaseException
     */
    public static function isStatus($task, $status): void
    {
        if ($task->getStatus() !== $status) {
            throw new ActionBaseException('Статус задачи не ' . $status . '.');
        }
    }
}
