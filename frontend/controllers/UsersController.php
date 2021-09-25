<?php

namespace frontend\controllers;

use frontend\models\UsersFilter;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use app\models\User;
use yii\web\NotFoundHttpException;

class UsersController extends Controller
{
    public function actionIndex(): string
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
                'title' => '',
                'users'      => $users->all(),
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
        $user = User::findOne($id);

        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден, проверьте правильность введенных данных', 404);
        }

        return $this->render('view', [
            'user' => $user
        ]);
    }
}
