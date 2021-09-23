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
        $filters->period = !empty($filters->period) ? $filters->period : '100 year';
        $dateFilter = new Expression('now() - interval ' . $filters->period);

        $tasks = Task::getNewTasks()
            ->andWhere(['>', 'task.date_add', $dateFilter])
            ->andFilterWhere(['task.category_id' => $filters->categories])
            ->andFilterWhere(['like', 'task.name', $filters->search]);

        if ($filters->remoteWork) {
            $tasks
                ->andWhere(['task.city_id' => null]);
        }

        if ($filters->noExecutor) {
            $tasks
                ->andWhere(['task.executor_id' => null]);
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
