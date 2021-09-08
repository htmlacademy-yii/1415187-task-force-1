<?php


namespace Taskforce\models;


class Status
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $name;

    public const STATUS_NEW = 'Новое';
    public const STATUS_EXECUTION = 'В работе';
    public const STATUS_CANCELED = 'Отменено';
    public const STATUS_FAILED = 'Провалено';
    public const STATUS_DONE = 'Выполнено';

    static function listAllStatus(): array
    {
        return [
            self::STATUS_NEW,
            self::STATUS_EXECUTION,
            self::STATUS_DONE,
            self::STATUS_FAILED,
            self::STATUS_CANCELED
        ];
    }

}
