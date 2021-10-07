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

        if (Yii::$app->request->getIsPost()) {
            $loginForm->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ActiveForm::validate($loginForm);
            }

            if ($loginForm->validate()) {

                $user = $loginForm->getUser();
                Yii::$app->user->login($user);

                return $this->goBack();
            }
        }

        // TODO fix password

        $tasks = Task::getLastTasks(self::DEFAULT_LAST_TASKS_COUNT, Status::STATUS_NEW)->all();

        return $this->renderPartial('../login/index',
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