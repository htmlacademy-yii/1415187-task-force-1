<?php

require_once 'vendor/autoload.php';

use M2rk\Taskforce\convertors\CsvConverter;

foreach (glob('data/new/*.csv') as $pathFile) {
    $file = new CsvConverter($pathFile);
    $file->convert();
}

echo 'Работа конвертера завершена';
