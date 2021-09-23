<?php

namespace frontend\controllers;

use yii\web\Controller;
use app\models\User;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $users = User::getExecutors();


        return $this->render(
            'index',
            [
                'users' => $users->all(),
            ]
        );
    }
}
