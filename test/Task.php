<?php

use M2rk\Taskforce\Task;

require '../vendor/autoload.php';

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);

function my_assert_handler($file, $line, $code, $desc = null)
{
    echo "Assertion failed at $file:$line: $code";
    if ($desc) {
        echo ": $desc";
    }
    echo "\n";
    echo '<br>';
}

assert_options(ASSERT_CALLBACK, 'my_assert_handler');

$action = new Task(1, 1, new DateTime(), Task::STATUS_NEW);
assert($action->getNextStatus(Task::ACTION_CANCEL, Task::ROLE_CONSUMER) === 'Cancel');
assert($action->getNextStatus(Task::ACTION_ASSIGN, Task::ROLE_CONSUMER) === 'In_work');
assert($action->getNextStatus(Task::ACTION_RESPOND, Task::ROLE_EXECUTOR) === 'In_work');

$action = new Task(1, 1, new DateTime('yesterday noon'), Task::STATUS_IN_WORK);
assert($action->getNextStatus(Task::ACTION_REFUSE, Task::ROLE_EXECUTOR) === 'Failed');
assert($action->getNextStatus(Task::ACTION_REFUSE, Task::ROLE_EXECUTOR) === 'Failed');
assert($action->getNextStatus(Task::ACTION_DONE, Task::ROLE_CONSUMER) === 'Done');
