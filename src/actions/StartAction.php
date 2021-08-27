<?php

namespace M2rk\Taskforce\actions;

use M2rk\Taskforce\exceptions\ActionBaseException;
use M2rk\Taskforce\exceptions\RoleBaseException;
use M2rk\Taskforce\models\Status;
use M2rk\Taskforce\models\Task;
use M2rk\Taskforce\validators\ActionValidator;

class StartAction extends Action
{
    public function getNameClass(): string
    {
        return self::class;
    }

    public function getActionName(): string
    {
        return 'startTask';
    }

    /**
     * @throws RoleBaseException
     * @throws ActionBaseException
     */
    public function verifyAction(Task $task, int $userId): bool
    {
        ActionValidator::isExecutor($userId);
        ActionValidator::isStatus($task, Status::STATUS_NEW);

        return true;
    }
}
