<?php

namespace M2rk\Taskforce\actions;

use M2rk\Taskforce\exceptions\ActionBaseException;
use M2rk\Taskforce\exceptions\RoleBaseException;
use M2rk\Taskforce\models\Status;
use M2rk\Taskforce\models\Task;
use M2rk\Taskforce\convertors\ActionValidator;

class NewAction extends Action
{
    public function getNameClass(): string
    {
        return self::class;
    }

    public function getActionName(): string
    {
        return 'newTask';
    }

    /**
     * @throws ActionBaseException
     * @throws RoleBaseException
     */
    public function verifyAction(Task $task, int $userId): bool
    {
        ActionValidator::isCustomer($userId);
        ActionValidator::isStatus($task, Status::STATUS_NEW);

        return true;
    }
}
