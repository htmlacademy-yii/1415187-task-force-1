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
    public int $category_id;

    /**
     * @var int
     */
    public int $status_id;

    /**
     * @var float
     */
    public float $price;

    /**
     * @var int
     */
    public int $customer_id;

    /**
     * @var int
     */
    public int $date_add;

    /**
     * @var int
     */
    public int $executor_id;

    /**
     * @var string
     */
    public string $address;

    /**
     * @var int
     */
    public int $city_id;

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


    public $initiatorId;


    public function __construct()
    {
        $this->date_add = time();
        $this->status = Status::STATUS_NEW;
        $this->user = new User();
    }

    public function getCustomerId(): int
    {
        return $this->customer_id;
    }

    public function getExecutorId(): int
    {
        return $this->executor_id;
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
        $this->customer_id = $id;
    }

    public function setExecutorId(int $id): void
    {
        $this->executor_id = $id;
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
        if ((new \M2rk\Taskforce\Actions\NewAction)->verifyAction($this, $this->initiatorId)) {
            $result[] = (new \M2rk\Taskforce\Actions\NewAction)->getActionName();
        }
        if ((new \M2rk\Taskforce\Actions\StartAction)->verifyAction($this, $this->initiatorId)) {
            $result[] = (new \M2rk\Taskforce\Actions\StartAction)->getActionName();
        }
        if ((new \M2rk\Taskforce\Actions\CancelAction)->verifyAction($this, $this->initiatorId)) {
            $result[] = (new \M2rk\Taskforce\Actions\CancelAction)->getActionName();
        }
        if ((new \M2rk\Taskforce\Actions\RefuseAction)->verifyAction($this, $this->initiatorId)) {
            $result[] = (new \M2rk\Taskforce\Actions\RefuseAction)->getActionName();
        }
        if ((new \M2rk\Taskforce\Actions\CompleteAction)->verifyAction($this, $this->initiatorId)) {
            $result[] = (new \M2rk\Taskforce\Actions\CompleteAction)->getActionName();
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
