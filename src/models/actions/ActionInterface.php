<?php


namespace  M2rk\Taskforce\Models\actions;

use  M2rk\Taskforce\Models\Task;

interface ActionInterface
{
    public static function getNameClass();
    public static function getActionName();
    public static function verifyAction(Task $task, int $userId) :bool;
}
