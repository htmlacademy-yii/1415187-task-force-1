<?php

namespace frontend\controllers;

use app\models\Responce;
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
        $dateFilter = new Expression('now() - ' . ($filters->period ?? 'now()'));

        $tasks = Task::getNewTasks()
            ->andWhere(['>', 'task.date_add', $dateFilter])
            ->andFilterWhere(['task.category_id' => $filters->categories])
            ->andFilterWhere(['ilike', 'task.name', $filters->search]);

        if ($filters->remoteWork) {
            $tasks
                ->andWhere(['task.city' => null]);
        }

        if ($filters->noResponse) {
            $tasks
                ->joinWith(Responce::tableName()) // error
                ->andWhere(['response.id' => null]);
        }

        $pagination = new Pagination(
            [
                'defaultPageSize' => 5,
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
