<?php

namespace frontend\controllers;

use app\models\City;
use app\models\Status;
use frontend\models\LoginForm;
use frontend\models\SignupForm;
use Yii;
use yii\base\BaseObject;
use yii\web\Controller;
use app\models\Task;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Landing controller
 */
class LandingController extends SecurityController
{
    private const DEFAULT_LAST_TASKS_COUNT = 4;

    public function actionLogin()
    {
        $loginForm = new LoginForm();

        if (Yii::$app->request->isPjax) {
            if ($loginForm->load(Yii::$app->request->post()) && $model->login()) {
                return $this->redirect(['tasks/index']);
            }

            return $this->renderPartial('loginForm', [
                'loginForm' => $loginForm
            ]);
        }

        // TODO fix password
        // TODO add  tooShort and tooLong keys

        $tasks = Task::getLastTasks(self::DEFAULT_LAST_TASKS_COUNT, Status::STATUS_NEW)->all();

        return $this->renderPartial('/index',
            [
                'tasks' => $tasks,
                'loginForm' => $loginForm,
            ]);
    }

    public function actionSignup()
    {
        $signUp = new SignupForm();

        if ($signUp->load(\Yii::$app->request->post()) && $signUp->validate()) {
            $signUp->signup();

            return $this->goHome();
        }

        $city = City::getCities();

        return $this->render('../signup/index', [
            'city' => $city,
            'signupForm' => $signUp,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}