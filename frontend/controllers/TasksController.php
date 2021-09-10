<?php

namespace frontend\controllers;

use yii\web\Controller;
use app\models\Task;

class TasksController extends Controller
{
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'tasks' => Task::getNewTasks(),
            ]
        );
    }
}
