<?php

use app\models\Category;
use app\models\Specialisation;

echo Category::findOne(7)->name;
echo PHP_EOL;
echo Specialisation::findOne(['category_id' => 6])->executor_id;
echo PHP_EOL;
var_dump(Category::findOne(['icon' => 'neo'])->specialisations);