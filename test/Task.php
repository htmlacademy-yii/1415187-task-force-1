<?php

use M2rk\Taskforce\Task;

require  "../vendor/autoload.php";

$action = new Task(1, 1, new DateTime('yesterday noon'), Task::STATUS_NEW);

var_dump($action);

var_dump($action::getAllStatuses());
