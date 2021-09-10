<?php

namespace frontend\controllers;

use app\models\Status;
use yii\web\Controller;
use app\models\Task;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()
            ->innerJoin(['s' => Status::tableName()], 's.id = `task`.status_id')
            ->orderBy('date_add')
            ->where(['s.`name`' => Status::STATUS_NEW])
            ->all();

        return $this->render(
            'index',
            [
                'tasks' => $tasks,
            ]
        );
    }
}
