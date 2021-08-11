<?php


namespace  M2rk\Taskforce\Models\actions;

use  M2rk\Taskforce\Models\Task;
use  M2rk\Taskforce\Models\User;

class NewAction implements ActionInterface
{

    public static function getNameClass(): string
    {
        return NewAction::class;
    }

    public static function getActionName(): string
    {
        return 'newTask';
    }

    public static function verifyAction(Task $task, int $userId): bool
    {
        if (User::isCustomer($userId) === true && $task->getStatus() === $task::STATUS_NEW) {
            return true;
        }
        return false;
    }
}
