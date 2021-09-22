<?php


namespace frontend\models;

use DateInterval;
use DateTime;
use yii\base\Model;

class TasksFilter extends Model
{

    public $categories;
    public $noResponse;
    public $remoteWork;
    public $period;
    public $search;

//    private const AVAILABLE_PERIOD = [
//        1 => '1 day',
//        2 => '1 week',
//        3 => '1 month',
//    ];

    public function attributeLabels(): array
    {
        return [
            'categories' => 'Категории',
            'noResponse' => 'Без откликов',
            'remoteWork' => 'Удаленная работа',
            'period' => 'Период',
            'search' => 'Поиск',
        ];
    }

    public function rules(): array
    {
        return [
            [['categories', 'noResponse', 'remoteWork', 'period', 'search'], 'safe'],
        ];
    }
}
