<?php

namespace M2rk\TaskForce;

use DateTime;
use Exception;

class Task
{
    public const ROLE_CONSUMER = 'Consumer';
    public const ROLE_EXECUTOR = 'Executor';

    public const ACTION_CANCEL = 'Cancel';
    public const ACTION_ASSIGN = 'Assign';
    public const ACTION_DONE = 'Done';
    public const ACTION_REFUSE = 'Refuse';
    public const ACTION_RESPOND = 'Respond';

    public const STATUS_NEW = 'New';
    public const STATUS_CANCEL = 'Cancel';
    public const STATUS_IN_WORK = 'In_work';
    public const STATUS_DONE = 'Done';
    public const STATUS_FAILED = 'Failed';

    public const ROLES = [
        self::ROLE_CONSUMER => 'Заказчик',
        self::ROLE_EXECUTOR => 'Исполнитель',
    ];

    public const ACTIONS = [
        self::ACTION_CANCEL  => 'Отменить',
        self::ACTION_ASSIGN  => 'Назначить',
        self::ACTION_DONE    => 'Выполнено',
        self::ACTION_REFUSE  => 'Отказаться',
        self::ACTION_RESPOND => 'Откликнуться',
    ];

    public const STATUSES = [
        self::STATUS_NEW     => 'Новое',
        self::STATUS_CANCEL  => 'Отменено',
        self::STATUS_IN_WORK => 'В работе',
        self::STATUS_DONE    => 'Выполнено',
        self::STATUS_FAILED  => 'Провалено',
    ];

    public const CONVERSIONS = [
        [
            'name' => self::ACTION_CANCEL,
            'from' => self::STATUS_NEW,
            'to'   => self::STATUS_CANCEL,
            'role' => self::ROLE_CONSUMER
        ],
        [
            'name' => self::ACTION_RESPOND,
            'from' => self::STATUS_NEW,
            'to'   => self::STATUS_IN_WORK,
            'role' => self::ROLE_EXECUTOR
        ],
        [
            'name' => self::ACTION_ASSIGN,
            'from' => self::STATUS_NEW,
            'to'   => self::STATUS_IN_WORK,
            'role' => self::ROLE_CONSUMER
        ],
        [
            'name' => self::ACTION_DONE,
            'from' => self::STATUS_IN_WORK,
            'to'   => self::STATUS_DONE,
            'role' => self::ROLE_CONSUMER
        ],
        [
            'name' => self::ACTION_REFUSE,
            'from' => self::STATUS_IN_WORK,
            'to'   => self::STATUS_FAILED,
            'role' => self::ROLE_EXECUTOR
        ],
    ];

    public int $executorID;
    public int $customerID;
    public DateTime $deadLine;
    public string $status;

    /**
     * Task constructor.
     *
     * @param int      $executorID
     * @param int      $customerID
     * @param DateTime $deadLine
     * @param string   $status
     */
    public function __construct(
        int $executorID,
        int $customerID,
        DateTime $deadLine,
        string $status = self::STATUS_NEW
    ) {
        $this->executorID = $executorID;
        $this->customerID = $customerID;
        $this->deadLine = $deadLine;
        $this->status = $status;
    }

    public static function getAllStatuses(): array
    {
        return self::STATUSES;
    }

    public static function getAllActions(): array
    {
        return self::ACTIONS;
    }

    /**
     * @throws Exception
     */
    public function cancel(string $role): void
    {
        if (($this->status !== self::STATUS_NEW) && ($role !== self::ROLE_CONSUMER)) {
            throw new Exception('Действие ' . self::ACTIONS[self::ACTION_CANCEL] . ' невозможно');
        }

        $this->status = self::STATUS_CANCEL;
    }

    /**
     * @throws Exception
     */
    public function respond(string $role): void
    {
        if (($this->status !== self::STATUS_NEW) && ($role !== self::ROLE_EXECUTOR)) {
            throw new Exception('Действие ' . self::ACTIONS[self::ACTION_RESPOND] . ' невозможно');
        }

        $this->status = self::STATUS_IN_WORK;
    }

    /**
     * @throws Exception
     */
    public function assign(string $role): void
    {
        if (($this->status !== self::STATUS_NEW) && ($role !== self::ROLE_CONSUMER)) {
            throw new Exception('Действие ' . self::ACTIONS[self::ACTION_ASSIGN] . ' невозможно');
        }

        $this->status = self::STATUS_IN_WORK;
    }

    /**
     * @throws Exception
     */
    public function done(string $role): void
    {
        if (($this->status !== self::STATUS_IN_WORK) && ($role !== self::ROLE_CONSUMER)) {
            throw new Exception('Действие ' . self::ACTIONS[self::ACTION_DONE] . ' невозможно');
        }

        $this->status = self::STATUS_DONE;
    }

    /**
     * @throws Exception
     */
    public function refuse(string $role): void
    {
        if (($this->status !== self::STATUS_IN_WORK) && ($role !== self::ROLE_EXECUTOR)) {
            throw new Exception('Действие ' . self::ACTIONS[self::ACTION_REFUSE] . ' невозможно');
        }

        $this->status = self::STATUS_FAILED;
    }

    /**
     * @throws Exception
     */
    public function getNextStatus(string $action, string $role): string
    {
        if (!empty($role) && in_array($action, self::ACTIONS)) {
            foreach (self::CONVERSIONS as $item) {
                if (($item['from'] === $this->status) && ($item['name'] === $action) && ($item['role'] === $role)) {
                    return $item['to'];
                }
            }
        }

        throw new Exception('Следующий статус не может быть определен');
    }
}
