<?php


namespace M2rk\Taskforce\models;


class User
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $password;

    /**
     * @var int
     */
    public int $dateAdd;

    /**
     * @var string
     */
    public string $dateActivity;

    /**
     * @var bool
     */
    public bool $isVisible;

    /**
     * @var int
     */
    public int $cityId;

    /**
     * @var string
     */
    public string $address;

    /**
     * @var int
     */
    public int $birthday;

    /**
     * @var string
     */
    public string $phone;

    /**
     * @var string
     */
    public string $skype;

    /**
     * @var string
     */
    public string $telegram;

    /**
     * @var string
     */
    public string $avatar;

    /**
     * @var string
     */
    public string $about;

    /**
     * @var bool
     */
    public bool $isDeleted;


    public static function isExecutor(int $user): bool
    {
        $executorIds = [120];

        return in_array($user, $executorIds);
    }

    public static function isCustomer(int $user): bool
    {
        $customerIds = [121];

        return in_array($user, $customerIds);
    }
}
