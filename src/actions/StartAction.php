<?php


namespace M2rk\Taskforce\actions;

use M2rk\Taskforce\exceptions\ActionBaseException;
use M2rk\Taskforce\exceptions\RoleBaseException;
use M2rk\Taskforce\models\Status;
use M2rk\Taskforce\models\Task;
use M2rk\Taskforce\models\User;

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

    public function verifyAction(Task $task, int $userId): bool
    {
        if (!User::isExecutor($userId) ) {
            throw new RoleBaseException('Текущий пользователь не является исполнителем.');
        }

        if ($task->getStatus() !== Status::STATUS_NEW) {
            throw new ActionBaseException('Статус задачи не ' . Status::STATUS_NEW . '.');
        }

        return true;
    }
}
