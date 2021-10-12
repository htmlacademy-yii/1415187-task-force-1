<?php

namespace frontend\models;

use app\models\User;
use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;
    private $user;

    public function attributeLabels(): array
    {
        return [
            'email' => 'Электронная почта',
            'password' => 'Пароль',
        ];
    }

    public function rules(): array
    {
        return [

            [['email', 'password'], 'safe'],
            [['email'], 'required', 'message' => 'Email не может быть пустым'],
            [['password'], 'required', 'message' => 'Пароль не может быть пустым'],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 128],
            ['password', 'validatePassword']
        ];
    }

    public function validatePassword($attribute): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный email или пароль');
            }
        }
    }

    public function getUser(): ?User
    {
        if ($this->user === null) {
            $this->user = User::findOne(['email' => $this->email]);
        }

        return $this->user;
    }
}