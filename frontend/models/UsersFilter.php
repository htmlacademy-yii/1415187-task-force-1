<?php

namespace frontend\models;

use yii\base\Model;

class UsersFilter extends Model
{

    public $categories;
    public $free;
    public $online;
    public $hasFeedback;
    public $inFavorites;
    public $search;
    public $sort;

    public function attributeLabels(): array
    {
        return [
            'categories'  => 'Категории',
            'free'        => 'Сейчас свободен',
            'online'      => 'Сейчас онлайн',
            'hasFeedback' => 'Есть отзывы',
            'inFavorites' => 'В избранном',
            'search'      => 'Поиск по имени',
            'sort'        => 'Сортировать по',
        ];
    }

    public function rules(): array
    {
        return [
            [['categories', 'free', 'online', 'hasFeedback', 'inFavorites', 'search', 'sort'], 'safe'],
        ];
    }
}
