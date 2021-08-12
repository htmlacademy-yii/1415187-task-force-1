<?php


namespace M2rk\Taskforce\actions;

use M2rk\Taskforce\exceptions\ActionBaseException;
use M2rk\Taskforce\exceptions\RoleBaseException;
use M2rk\Taskforce\models\Status;
use M2rk\Taskforce\models\Task;

class CancelAction extends Action
{
    public function getNameClass(): string
    {
        return self::class;
    }

    public function getActionName(): string
    {
        return 'cancelTask';
    }

    public function verifyAction(Task $task, int $userId): bool
    {
        if ($userId !== $task->getCustomerId()) {
            throw new RoleBaseException('Ошибка: Текущий пользователь не является иницицатором.');
        }

        if ($task->getStatus() !== Status::STATUS_NEW) {
            throw new ActionBaseException('Ошибка. Статус задачи не ' . Status::STATUS_NEW . '.');
        }

        return true;
    }
}
