<?php

require_once '../index.php';

use M2rk\Taskforce\exceptions\ActionBaseException;
use M2rk\Taskforce\exceptions\RoleBaseException;
use M2rk\Taskforce\exceptions\StatusBaseException;
use M2rk\Taskforce\models\Task;

$task = new Task();

try {
    $task->setCustomerId(121);
    $task->setExecutorId(120);
    echo $task->getStatus() . PHP_EOL . '<br>';
    $task->setInitiatorId(120);
    $task->start();
    echo '<br>' . $task->getStatus() . PHP_EOL . '<br>';
    $task->refuse();
    echo '<br>' . $task->getStatus() . PHP_EOL . '<br>';

    $task->setInitiatorId(121);
    $task->getNewStatus('newTask');
    $task->cancel();
    echo '<br>' . $task->getStatus() . PHP_EOL . '<br>';

    $task->setInitiatorId(121);
    $task->getNewStatus('newTask');
    $task->setInitiatorId(120);
    $task->start();
    $task->setInitiatorId(121);
    $task->complete();
    echo '<br>' . $task->getStatus() . PHP_EOL;

} catch (ActionBaseException $e) {
    print $e->getMessage() . "\n";
} catch (RoleBaseException $e) {
    print $e->getMessage() . "\n";
} catch (StatusBaseException $e) {
    print $e->getMessage() . "\n";
}
