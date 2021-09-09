<?php

namespace backend\helpers;

use backend\exceptions\BadDateException;
use DateTime;
use Exception;

class BaseHelper
{
    public const NOUN_PLURAL_KEYS =
        [
            'time' => ['one' => ''];
        ];

    /**
     * Возвращает корректную форму множественного числа
     * Ограничения: только для целых чисел
     * Пример использования:
     * $remaining_minutes = 5;
     * echo "Я поставил таймер на {$remaining_minutes} " .
     *     get_noun_plural_form(
     *         $remaining_minutes,
     *         'минута',
     *         'минуты',
     *         'минут'
     *     );
     * Результат: "Я поставил таймер на 5 минут"
     *
     * @param int    $number Число, по которому вычисляем форму множественного числа
     * @param string $one    Форма единственного числа: яблоко, час, минута
     * @param string $two    Форма множественного числа для 2, 3, 4: яблока, часа, минуты
     * @param string $many   Форма множественного числа для остальных чисел
     * @return string Рассчитанная форма множественнго числа
     */
    public static function get_noun_plural_form(int $number, string $one, string $two, string $many): string
    {
        $number = (int)$number;
        $mod10 = $number % 10;
        $mod100 = $number % 100;

        switch (true) {
            case ($mod100 >= 11 && $mod100 <= 20):
                return $many;

            case ($mod10 > 5):
                return $many;

            case ($mod10 === 1):
                return $one;

            case ($mod10 >= 2 && $mod10 <= 4):
                return $two;

            default:
                return $many;
        }
    }

    /**
     * Возвращает время относительно текущей даты.
     *
     * @param string      $time Дата/время отсчета
     * @param string|null $gmt
     * @return string Относительное время в общем формате (прим.: "4 дня *назад*", "3 недели *назад*")
     * @throws Exception
     */
    public static function time_difference(string $time, string $gmt = null): string
    {
        date_default_timezone_set("Etc/GMT{$gmt}");

        try {
            $diff = date_diff(new DateTime(), new DateTime($time));
        } catch (Exception) {
            throw new BadDateException('Не удалось');
        }

        if ($diff->y > 0) {
            $relative_time = $diff->y . ' ' .
                self::get_noun_plural_form($diff->y, 'год', 'года', 'лет');
        } elseif ($diff->m > 0) {
            $relative_time = $diff->m . ' ' .
                self::get_noun_plural_form($diff->m, 'месяц', 'месяца', 'месяцев');
        } elseif ($diff->d > 6) {
            $relative_time = floor(($diff->d) / 7) . ' ' .
                self::get_noun_plural_form(floor(($diff->d) / 7), ' неделю', ' недели', ' недель');
        } elseif ($diff->d > 0) {
            $relative_time = $diff->d . ' ' .
                self::get_noun_plural_form($diff->d, 'день', 'дня', 'дней');
        } elseif ($diff->h > 0) {
            $relative_time = $diff->h . ' ' .
                self::get_noun_plural_form($diff->h, 'час', 'часа', 'часов');
        } elseif ($diff->i > 0) {
            $relative_time = $diff->i . ' ' .
                self::get_noun_plural_form($diff->i, 'минуту', 'минуты', 'минут');
        } elseif ($diff->s >= 0) {
            $relative_time = 'Менее минуты';
        } else {
            $relative_time = '';
        }
        return $relative_time;
    }
}
