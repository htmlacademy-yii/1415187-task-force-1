<?php


namespace frontend\models;

use DateInterval;
use DateTime;
use yii\base\Model;

class TasksFilter extends Model
{

    public $categories;
    public $noExecutor;
    public $remoteWork;
    public $period;
    public $search;
    public $additionally;

//    private const AVAILABLE_PERIOD = [
//        1 => '1 day',
//        2 => '1 week',
//        3 => '1 month',
//    ];

    public function attributeLabels(): array
    {
        return [
            'categories' => 'Категории',
            'noExecutor' => 'Без исполнителя',
            'remoteWork' => 'Удаленная работа',
            'period' => 'Период',
            'search' => 'Поиск',
        ];
    }

    public function rules(): array
    {
        return [
            [['categories', 'noExecutor', 'remoteWork', 'period', 'search'], 'safe'],
        ];
    }
}
