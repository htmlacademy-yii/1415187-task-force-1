<?php

namespace frontend\controllers;

use yii\web\Controller;
use app\models\Task;

/**
 * Landing controller
 */
class LandingController extends Controller
{
    private const DEFAULT_LAST_TASKS = 4;

    public function actionIndex(): string
    {
        $tasks = Task::getLastNewTasks(self::DEFAULT_LAST_TASKS)->all();

        return $this->renderPartial('index', ['tasks' => $tasks]);
    }
}
