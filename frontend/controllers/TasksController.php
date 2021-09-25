<?php

namespace frontend\controllers;

use frontend\models\TasksFilter;
use Yii;
use yii\data\Pagination;
use yii\db\Expression;
use yii\web\Controller;
use app\models\Task;
use yii\web\NotFoundHttpException;

class TasksController extends Controller
{

    public function actionIndex(): string
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

    /**
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {

        $task = Task::find()
            ->where(['id' => $id])
            ->one();

        if (empty($task)) {
            throw new NotFoundHttpException('Задание не найдено, проверьте правильность введенных данных', 404);
        }

        return $this->render('view', ['task' => $task]);
    }
}
