<?php

namespace M2rk\Taskforce\convertors;

use M2rk\Taskforce\exceptions\CsvBaseException;
use M2rk\Taskforce\convertors\BaseImporter;
use SplFileObject;

class CsvImporter
{
    private array $accord = [
        'cities.csv'         => [
            'table'  => 'city',
            'header' => [
                'name',
                'lat',
                'long',
            ],
        ],
        'categories.csv'     => [
            'table'  => 'category',
            'header' => [
                'name',
                'icon',
            ],
        ],
        'users-profiles.csv' => [
            'table'  => 'user',
            'header' => [
                'email',
                'name',
                'password',
                'date_add',
                'date_activity',
                'is_visible',
                'city_id',
                'address',
                'birthday',
                'phone',
                'skype',
                'telegram',
                'avatar',
                'about',
                'is_deleted',
            ],
        ],
        'tasks.csv'          => [
            'table'  => 'task',
            'header' => [
                'name',
                'description',
                'category_id',
                'status_id',
                'price',
                'customer_id',
                'date_add',
                'executor_id',
                'address',
                'city_id',
                'expire',
            ],
        ],
        'opinions.csv'       => [
            'table'  => 'reviews',
            'header' => [
                'date_add',
                'rating',
                'review',
                'user_id',
                'task_id',
            ],
        ],
        'replies.csv'        => [
            'table'  => 'reviews',
            'header' => [
                'date_add',
                'rating',
                'review',
                'user_id',
                'task_id',
            ],
        ],
    ];
    public array $userResult;
    private array $profileResult;
    private array $output;

    public function joinCSVUser(): void
    {
        $user = new SplFileObject('data/users.csv');
        $user->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD | SplFileObject::DROP_NEW_LINE);
        $profile = new SplFileObject('data/profiles.csv');

        while (!$user->eof()) {
            $userResult[] = $user->fgets();
        }

        while (!$profile->eof()) {
            $profilesResult[] = $profile->fgets();
        }

        $min = min(count($userResult), count($profilesResult));
        $output = new SplFileObject('data/users-profiles.csv', "a+");

        for ($i = 0; $i < $min - 1; $i++) {
            $output->fwrite($userResult[$i] . ', ' . $profilesResult[$i]);
        }
    }

    public function interpreter(): void
    {
        foreach ($this->accord as $files => $table) {
            $filename = 'data/' . $files;
            $import = new BaseImporter($filename, $table['table'], $table['header']);
            try {
                $import->import();
            } catch (CsvBaseException $e) {
                error_log("Ошибка: " . $e->getMessage());
            }
        }
    }
}
