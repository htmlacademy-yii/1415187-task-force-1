<?php


namespace M2rk\Taskforce\actions;

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
        return User::isExecutor($userId) === true && $task->getStatus() === Status::STATUS_NEW;
    }
}
