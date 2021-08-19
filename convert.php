<?php

use M2rk\Taskforce\convertors\CsvImporter;

require_once 'index.php';

$test = new CsvImporter();

$test->joinCSVUser();

$test->interpreter();
