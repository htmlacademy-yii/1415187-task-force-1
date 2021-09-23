<?php

namespace frontend\controllers;

use app\models\Status;
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

        $users = User::getExecutors()->joinWith('opinionsExecutor');

        foreach ($filters as $key => $data) {
            if ($data) {
                switch ($key) {
                    case 'categories':
                        $users->andWhere(['s.category_id' => $filters->categories]);
                        break;
                    case 'free':
                        $users->JoinWith('tasksExecutor')
                            ->andWhere(['or', ['tasks.id' => null], ['tasks.status' => Status::STATUS_DONE]]);
                        break;
                    case 'online':
                        $users->where(['>', '`user`.date_activity', 'now()']);
                        break;
                    case 'hasFeedback':
                        $users->joinWith('opinionsExecutor');
                        $users->andWhere(['is not', 'opinion.customer_id', null]);
                        break;
                    case 'inFavorites':
                        $users->joinWith('favoritesExecutor');
                        $users->andWhere(['is not', 'favorite.customer_id', null]);
                        break;
                }
            }
        }

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $users->count(),
        ]);
        $users->offset($pagination->offset)
            ->limit($pagination->limit);

        return $this->render(
            'index',
            [
                'users' => $users->all(),
                'filters' => $filters,
                'pagination' => $pagination,
            ]
        );
    }
}
