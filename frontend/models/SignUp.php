<?php

namespace frontend\models;

use yii\base\Model;

/**
 * Registration form
 */
class SignUp extends Model
{
    public string $email;
    public string $name;
    public int $city;
    public string $password;

    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта',
            'name' => 'Ваше имя',
            'city' => 'Город проживания',
            'password' => 'Пароль'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['email', 'name', 'city', 'password'], 'safe'],
            [['email', 'name', 'city', 'password'], 'required'],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 128],
            ['email', 'unique', 'targetClass' => '\frontend\models\Users', 'message' => 'Пользователь с таким email уже существует'],
            ['name', 'string', 'max' => 128],
            ['password', 'string', 'max' => 16],
            ['password', 'string', 'min' => 6],
        ];
    }
}
