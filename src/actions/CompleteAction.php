<?php

namespace M2rk\Taskforce\actions;

use M2rk\Taskforce\exceptions\ActionBaseException;
use M2rk\Taskforce\exceptions\RoleBaseException;
use Taskforce\models\Status;
use Taskforce\models\Task;
use M2rk\Taskforce\validators\ActionValidator;

class CompleteAction extends Action
{
    public function getNameClass(): string
    {
        return self::class;
    }

    public function getActionName(): string
    {
        return 'completeTask';
    }

    /**
     * @throws RoleBaseException
     * @throws ActionBaseException
     */
    public function verifyAction(Task $task, int $userId): bool
    {
        ActionValidator::isCustomer($userId);
        ActionValidator::isStatus($task, Status::STATUS_EXECUTION);

        return true;
    }
}
