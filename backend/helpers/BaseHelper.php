<?php

namespace backend\helpers;

use backend\exceptions\BadDateException;
use DateTime;
use Exception;

class BaseHelper
{
    public const NOUN_PLURAL_KEYS =
        [
            'secs' => [
                'one'  => 'секунду',
                'two'  => 'секунд',
                'many' => 'секунды',
            ],
            'mins' => [
                'one'  => 'минуту',
                'two'  => 'минуты',
                'many' => 'минут',
            ],
            'hours' => [
                'one'  => 'час',
                'two'  => 'часа',
                'many' => 'часов',
            ],
            'days' => [
                'one'  => 'день',
                'two'  => 'дня',
                'many' => 'дней',
            ],
            'weeks' => [
                'one'  => 'неделю',
                'two'  => 'недели',
                'many' => 'недель',
            ],
            'months' => [
                'one'  => 'месяц',
                'two'  => 'месяца',
                'many' => 'месяцев',
            ],
            'years' => [
                'one'  => 'год',
                'two'  => 'года',
                'many' => 'лет',
            ],
            'tasks' => [
                'one'  => 'задание',
                'two'  => 'задания',
                'many' => 'заданий',
            ],
            'comments' => [
                'one'  => 'комментарий',
                'two'  => 'комментария',
                'many' => 'комментариев',
            ],
            'feedbacks' => [
                'one'  => 'отзыв',
                'two'  => 'отзыва',
                'many' => 'отзывов',
            ],
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
     * @param string $key Ключ массива с маппингом
     * @return string Рассчитанная форма множественнго числа
     */
    public static function get_noun_plural_form(int $number, string $key): string
    {
        $mod10 = $number % 10;
        $mod100 = $number % 100;

        return match (true) {
            $mod100 >= 11 && $mod100 <= 14 => self::NOUN_PLURAL_KEYS[$key]['many'],
            $mod10 === 1 => self::NOUN_PLURAL_KEYS[$key]['one'],
            $mod10 >= 2 && $mod10 <= 4 => self::NOUN_PLURAL_KEYS[$key]['two'],
            default => self::NOUN_PLURAL_KEYS[$key]['many'],
        };
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
            throw new BadDateException('Не удалось преобразовать дату');
        }

        if ($diff->y > 0) {
            $relative_time = $diff->y . ' ' .
                self::get_noun_plural_form($diff->y, 'years');
        } elseif ($diff->m > 0) {
            $relative_time = $diff->m . ' ' .
                self::get_noun_plural_form($diff->m, 'months');
        } elseif ($diff->d > 6) {
            $relative_time = floor(($diff->d) / 7) . ' ' .
                self::get_noun_plural_form(floor(($diff->d) / 7), 'weeks');
        } elseif ($diff->d > 0) {
            $relative_time = $diff->d . ' ' .
                self::get_noun_plural_form($diff->d, 'days');
        } elseif ($diff->h > 0) {
            $relative_time = $diff->h . ' ' .
                self::get_noun_plural_form($diff->h, 'hours');
        } elseif ($diff->i > 0) {
            $relative_time = $diff->i . ' ' .
                self::get_noun_plural_form($diff->i, 'mins');
        } elseif ($diff->s >= 0) {
            $relative_time = 'Менее минуты';
        } else {
            throw new BadDateException('Не удалось преобразовать дату');
        }

        return $relative_time;
    }
}
