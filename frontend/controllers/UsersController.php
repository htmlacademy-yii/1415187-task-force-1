<?php

namespace frontend\controllers;

use app\models\Specialisation;
use yii\web\Controller;
use app\models\User;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $users = User::find()
            ->innerJoin(['s' => Specialisation::tableName()], 's.executor_id = `user`.id')
            ->groupBy('`user`.id')
            ->orderBy(['date_add' => SORT_DESC])
            ->all();

        return $this->render(
            'index',
            [
                'users' => $users,
            ]
        );
    }
}
