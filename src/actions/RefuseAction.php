<?php


namespace M2rk\Taskforce\actions;

use M2rk\Taskforce\exceptions\ActionBaseException;
use M2rk\Taskforce\exceptions\RoleBaseException;
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
        if ($userId !== $task->getExecutorId()) {
            throw new RoleBaseException('Ошибка: Текущий пользователь не является исполнителем.');
        }

        if ($task->getStatus() !== Status::STATUS_EXECUTION) {
            throw new ActionBaseException('Ошибка: Статус задачи не '. Status::STATUS_EXECUTION . '.');
        }

        return true;
    }
}
