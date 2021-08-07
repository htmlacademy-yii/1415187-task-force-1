<?php


namespace M2rk\Taskforce\actions;

use M2rk\Taskforce\models\Status;
use M2rk\Taskforce\Models\Task;
use M2rk\Taskforce\Models\User;

class NewAction  extends Action
{
    public function getNameClass(): string
    {
        return self::class;
    }

    public function getActionName(): string
    {
        return 'newTask';
    }

    public function verifyAction(Task $task, int $userId): bool
    {
        return User::isCustomer($userId) === true && $task->getStatus() === Status::STATUS_NEW;
    }
}
