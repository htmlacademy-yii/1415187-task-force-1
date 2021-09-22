<?php

namespace frontend\controllers;

use frontend\models\TasksFilter;
use Yii;
use yii\db\Expression;
use yii\web\Controller;
use app\models\Task;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $filters = new TasksFilter();
        $filters->load(Yii::$app->request->get());

        $tasks = Task::getNewTasks()
            ->andFilterWhere(['task.category_id' => $filters->categories])
            ->andFilterWhere(['>', new Expression($filters->period)])
            ->andFilterWhere(['ilike', 'task.name', $filters->search]);

        return $this->render(
            'index',
            [
                'tasks' => $tasks->all(),
            ]
        );
    }
}
