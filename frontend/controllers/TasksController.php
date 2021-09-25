<?php

namespace frontend\controllers;

use frontend\models\TasksFilter;
use Yii;
use yii\data\Pagination;
use yii\db\Expression;
use yii\web\Controller;
use app\models\Task;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $filters = new TasksFilter();
        $filters->load(Yii::$app->request->get());

        $tasks = Task::getNewTasks($filters);


        $pagination = new Pagination(
            [
                'defaultPageSize' => 10,
                'totalCount'      => $tasks->count(),
            ]
        );

        $tasks->offset($pagination->offset);
        $tasks->limit($pagination->limit);

        return $this->render(
            'index',
            [
                'tasks'      => $tasks->all(),
                'filters'    => $filters,
                'pagination' => $pagination,
            ]
        );
    }
}
