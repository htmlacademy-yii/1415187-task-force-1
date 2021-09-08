<?php

namespace frontend\controllers;

use yii\web\Controller;
use app\models\User;

class UsersController extends Controller
{
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'users' => User::find()
                    ->orderBy(['date_add' => SORT_DESC])
                    ->all()
            ]
        );
    }
}
