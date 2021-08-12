<?php


namespace M2rk\Taskforce\actions;


use M2rk\Taskforce\models\Task;

abstract class Action
{
    abstract public function getNameClass();

    abstract public function getActionName();

    abstract public function verifyAction(Task $task, int $userId): bool;
}