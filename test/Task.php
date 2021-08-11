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

print $task->getStatus();
