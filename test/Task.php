<?php

require_once '../index.php';

use M2rk\Taskforce\models\Status;
use M2rk\Taskforce\models\Task;

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);

function my_assert_handler($file, $line, $code, $desc = null)
{
    echo "Assertion failed at {$file}:{$line}: {$code}";
    if ($desc) {
        echo ": {$desc}";
    }
    echo "\n";
    echo '<br>';
}

assert_options(ASSERT_CALLBACK, 'my_assert_handler');

$task = new Task();

try {
    $task->setCustomerId(121);
    $task->setExecutorId(122);
    $task->setInitiatorId(121);
} catch ( $exception) {
    print $exception->getMessage() . "\n";
} catch ( $exception) {
    print $exception->getMessage() . "\n";
} catch ( $exception) {
    print $exception->getMessage() . "\n";
} finally {
    echo 'Назначение ролей завершено успешно';
}
$task->setCustomerId(121);
$task->setExecutorId(120);
$task->setInitiatorId(121);
assert($task->getNewStatus('newTask') === Status::STATUS_NEW, 'При действии "Создать задание" метод вернёт статус "Новое"');
assert($task->getNewStatus('startTask') === Status::STATUS_EXECUTION, 'При действии "Начать задание" метод вернёт статус "В работе"');
assert($task->getNewStatus('cancelTask') === Status::STATUS_CANCELED, 'При действии "Отменить задание" метод вернёт статус "Отменено"');
assert($task->getNewStatus('refuseTask') === Status::STATUS_FAILED, 'При действии "Отказаться от задания" метод вернёт статус "Провалено"');
assert($task->getNewStatus('completeTask') === Status::STATUS_DONE, 'При действии "Завершить задание" метод вернёт статус "Выполнено"');

$task->getNewStatus('newTask');
assert($task->start() === null, 'При действии "Начать задание" метод вернет null так как пользователь не имеет роли "Исполнитель"');

$task->setInitiatorId(120);
assert($task->start() === Status::STATUS_EXECUTION, 'При действии "Начать задание" метод вернёт статус "В работе"');
assert($task->refuse() === Status::STATUS_FAILED, 'При действии "Отказаться от задания" метод вернёт статус "Провалено"');
assert($task->cancel() === null, 'При действии "Отменить задание" метод вернёт null так как пользователь не совпадает с заказчиком и статус задачи не "В работе"');

$task->setInitiatorId(121);
$task->getNewStatus('newTask');
assert($task->cancel() === Status::STATUS_CANCELED, 'При действии "Отменить задание" метод вернёт статус "Отменено"');
assert($task->complete() === null, 'При действии "Завершить задание" метод вернёт null так как статус задания "Отменено"');

$task->getNewStatus('startTask');
assert($task->complete() === Status::STATUS_DONE, 'При действии "Завершить" метод вернёт статус "Выполнено"');

print $task->getStatus();
