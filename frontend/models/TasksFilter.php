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

    private $availablePeriod = [
        1 => 'day',
        2 => 'week',
        3 => 'month',
    ];

    public function attributeLabels(): array
    {
        return [
            'categories' => 'Категории',
            'no_response' => 'Без откликов',
            'remote_work' => 'Удаленная работа',
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

    public function formName(): void
    {

    }

    public function getPeriodTime($period): string
    {
        $date = new DateTime();
        $date->sub(DateInterval::createFromDateString($this->availablePeriod[$period]));
        return $date->format('Y-m-d H:i:s');
    }
}