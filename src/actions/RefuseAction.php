<?php


namespace M2rk\Taskforce\actions;

use M2rk\Taskforce\models\Status;
use M2rk\Taskforce\models\Task;

class RefuseAction extends Action
{
    public function getNameClass(): string
    {
        return self::class;
    }

    public function getActionName(): string
    {
        return 'refuseTask';
    }

    public function verifyAction(Task $task, int $userId): bool
    {
        return $userId === $task->getExecutorId() && $task->getStatus() === Status::STATUS_EXECUTION;
    }
}
