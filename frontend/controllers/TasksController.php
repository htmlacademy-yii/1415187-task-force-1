<?php

namespace frontend\controllers;

use app\models\Status;
use yii\web\Controller;
use app\models\Task;

class TasksController extends Controller
{
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'tasks' => Task::find()
                    ->orderBy('date_add')
                    ->where(['status_id' => Status::STATUS_NEW])
                    ->all()
            ]
        );
    }
}
