<?php


namespace M2rk\Taskforce\models;

use M2rk\Taskforce\actions\CancelAction;
use M2rk\Taskforce\actions\CompleteAction;
use M2rk\Taskforce\actions\NewAction;
use M2rk\Taskforce\actions\RefuseAction;
use M2rk\Taskforce\actions\StartAction;

class Task
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $description;

    /**
     * @var int
     */
    public int $categoryId;

    /**
     * @var int
     */
    public int $statusId;

    /**
     * @var float
     */
    public float $price;

    /**
     * @var int
     */
    public int $customerId;

    /**
     * @var int
     */
    public int $dateAdd;

    /**
     * @var int
     */
    public int $executorId;

    /**
     * @var string
     */
    public string $address;

    /**
     * @var int
     */
    public int $cityId;

    /**
     * @var int
     */
    public int $expire;

    /**
     * @var User
     */
    public User $user;

    /**
     * @var string
     */
    public string $status;


    public $initiatorId; // Attention! Not part of model!


    public function __construct()
    {
        $this->dateAdd = time();
        $this->status = Status::STATUS_NEW;
        $this->user = new User();
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getExecutorId(): int
    {
        return $this->executorId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getExpire(): string
    {
        return $this->expire;
    }

    public function setCustomerId(int $id): void
    {
        $this->customerId = $id;
    }

    public function setExecutorId(int $id): void
    {
        $this->executorId = $id;
    }

    public function setInitiatorId(int $id): void
    {
        $this->initiatorId = $id;
    }

    public function setExpire(string $time)
    {
        $this->expire = $time;
    }

    public function getNewStatus(string $action): ?string
    {
        switch ($action) {
            case (new NewAction)->getActionName():
                return $this->status = Status::STATUS_NEW;
            case (new StartAction)->getActionName():
                return $this->status = Status::STATUS_EXECUTION;
            case (new CancelAction)->getActionName():
                return $this->status = Status::STATUS_CANCELED;
            case (new RefuseAction)->getActionName():
                return $this->status = Status::STATUS_FAILED;
            case (new CompleteAction)->getActionName():
                return $this->status = Status::STATUS_DONE;
        }

        return null;
    }

    public function getAvailableActions(): array
    {
        $result = [];
        if ((new NewAction)->verifyAction($this, $this->initiatorId)) {
            $result[] = (new NewAction)->getActionName();
        }
        if ((new StartAction)->verifyAction($this, $this->initiatorId)) {
            $result[] = (new StartAction)->getActionName();
        }
        if ((new CancelAction)->verifyAction($this, $this->initiatorId)) {
            $result[] = (new CancelAction)->getActionName();
        }
        if ((new RefuseAction)->verifyAction($this, $this->initiatorId)) {
            $result[] = (new RefuseAction)->getActionName();
        }
        if ((new CompleteAction)->verifyAction($this, $this->initiatorId)) {
            $result[] = (new CompleteAction)->getActionName();
        }
        return $result;
    }

    public function start(): ?string
    {
        if ((new StartAction)->verifyAction($this, $this->initiatorId)) {
            return $this->status = Status::STATUS_EXECUTION;
        }
        return null;
    }

    public function cancel(): ?string
    {
        if ((new CancelAction)->verifyAction($this, $this->initiatorId)) {
            return $this->status = Status::STATUS_CANCELED;
        }
        return null;
    }

    public function refuse(): ?string
    {
        if ((new RefuseAction)->verifyAction($this, $this->initiatorId)) {
            return $this->status = Status::STATUS_FAILED;
        }
        return null;
    }

    public function complete(): ?string
    {
        if ((new CompleteAction)->verifyAction($this, $this->initiatorId)) {
            return $this->status = Status::STATUS_DONE;
        }
        return null;
    }

}
