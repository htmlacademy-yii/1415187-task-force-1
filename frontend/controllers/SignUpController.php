<?php

namespace frontend\controllers;

use frontend\models\SignUp;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;


/**
 * Registration controller
 */
class SignUpController extends Controller
{

    /**
     * Регистрация пользователя.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $signUpForm = new SignUp();

        if (\Yii::$app->request->getIsPost()) {
            $signUpForm->load(\Yii::$app->request->post());

            if (\Yii::$app->request->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($signUpForm);
            }

            if ($signUpForm->validate()) {
                // TODO
            }
        }

        return $this->render('index', ['userRegisterForm' => $signUpForm]);
    }
}
