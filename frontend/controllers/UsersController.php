<?php

namespace frontend\controllers;

use frontend\models\UsersFilter;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use app\models\User;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $filters = new UsersFilter();
        $filters->load(Yii::$app->request->get());

        $users = User::getExecutors($filters);

        $pagination = new Pagination(
            [
                'defaultPageSize' => 10,
                'totalCount'      => $users->count(),
            ]
        );

        $users->offset($pagination->offset)
            ->limit($pagination->limit);

        return $this->render(
            'index',
            [
                'users'      => $users->all(),
                'filters'    => $filters,
                'pagination' => $pagination,
            ]
        );
    }
}
