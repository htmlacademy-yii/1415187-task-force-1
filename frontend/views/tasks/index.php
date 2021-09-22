<?php

/**
 * @var $tasks      \frontend\controllers\TasksController
 * @var $pagination \yii\data\Pagination
 * @var $filters    \frontend\models\TasksFilter
 */

use backend\helpers\BaseHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use app\models\Category;

?>

<section class="new-task">
    <div class="new-task__wrapper">
        <h1>Новые задания</h1>

        <?php foreach ($tasks as $task): ?>
            <div class="new-task__card">
                <div class="new-task__title">
                    <a href="#" class="link-regular"><h2><?= $task->name ?></h2></a>
                    <a class="new-task__type link-regular" href="#"><p><?= $task->category->name ?></p></a>
                </div>
                <div class="new-task__icon new-task__icon--<?= $task->category->icon ?>"></div>
                <p class="new-task_description">
                    <?= $task->description ?>
                </p>
                <b class="new-task__price new-task__price--<?= $task->category->icon ?>"><?= $task->price ?> <b>
                        ₽</b></b>
                <p class="new-task__place"><?= Html::encode(
                        "{$task->city->name}, {$task->address}, {$task->city->lat}-{$task->city->long}"
                    ) ?></p>
                <span class="new-task__time"><?= BaseHelper::time_difference($task->date_add) ?> назад</span>
            </div>
        <?php endforeach; ?>

        <div class="new-task__pagination">

            <?= LinkPager::widget(
                [
                    'pagination'         => $pagination,
                    'options'            => [
                        'class' => 'new-task__pagination-list',
                    ],
                    'activePageCssClass' => 'pagination__item--current',
                    'pageCssClass'       => 'pagination__item',
                    'prevPageCssClass'   => 'pagination__item',
                    'nextPageCssClass'   => 'pagination__item',
                    'nextPageLabel'      => '⠀',
                    'prevPageLabel'      => '⠀',
                    'hideOnSinglePage'   => true
                ]
            ) ?>

        </div>
</section>
<section class="search-task">
    <div class="search-task__wrapper">

        <?php

        $form = ActiveForm::begin(
            [
                'id'      => 'filter-form',
                'options' => ['class' => 'search-task__form'],
                'action'  => ['/tasks'],
                'method'  => 'get'
            ]
        );

        ?>

        <fieldset class="search-task__categories">
            <legend>Категории</legend>
            <label class="checkbox__legend">
                <input class="visually-hidden checkbox__input" type="checkbox" name="" value="" checked>
                <span>Курьерские услуги</span>
            </label>
            <label class="checkbox__legend">
                <input class="visually-hidden checkbox__input" type="checkbox" name="" value="" checked>
                <span>Грузоперевозки</span>
            </label>
            <label class="checkbox__legend">
                <input class="visually-hidden checkbox__input" type="checkbox" name="" value="">
                <span>Переводы</span>
            </label>
            <label class="checkbox__legend">
                <input class="visually-hidden checkbox__input" type="checkbox" name="" value="">
                <span>Строительство и ремонт</span>
            </label>
            <label class="checkbox__legend">
                <input class="visually-hidden checkbox__input" type="checkbox" name="" value="">
                <span>Выгул животных</span>
            </label>
        </fieldset>

<!--        <fieldset class="search-task__categories">-->
<!--            <legend>Категории</legend>-->
<!---->
<!--            --><?php
//
//            echo $form->field($filters, 'categories', ['options' => ['class' => '']])
//                ->checkboxList(
//                    Category::getCategories(),
//                    [
//                        'item'     => function ($index, $label, $name, $checked, $value) use ($filters) {
//                            if (!empty($model['categories']) && in_array($value, $model['categories'])) {
//                                $checked = 'checked';
//                            }
//
//                            return "<label class=\"checkbox__legend\" for=\"categories_{$value}\">
//                                        <input class=\"visually-hidden checkbox__input\" id=\"categories_{$value}\" type=\"checkbox\" name=\"{$value}\" value=\"\" {$checked}>
//                                        <span>{$label}</span>
//                                    </label>";
//                        },
//                        'unselect' => null
//                    ]
//                )->label(false);
//
//            ?>
<!---->
<!--        </fieldset>-->

        <fieldset class="search-task__categories">
            <legend>Дополнительно</legend>
            <div>
                <label class="checkbox__legend">
                    <input class="visually-hidden checkbox__input" type="checkbox" name="" value="">
                    <span>Без исполнителя</span>
                </label>
            </div>
            <div>
                <label class="checkbox__legend">
                    <input class="visually-hidden checkbox__input" id="7" type="checkbox" name="" value=""
                           checked>
                    <span>Удаленная работа</span>
                </label>
            </div>
        </fieldset>

        <fieldset class="search-task__categories">
            <legend>Дополнительно</legend>
            <?php

            echo $form->field($filters, 'noResponse', [
                'template' => '{input}{label}',
                'options' => ['class' => ''],
            ])
                ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => false], false);

            echo $form->field($filters, 'remoteWork', [
                'template' => '{input}{label}',
                'options' => ['class' => '']
            ])
                ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => false], false);

            ?>
        </fieldset>


        <div class="field-container">
            <label class="search-task__name" for="8">Период</label>
            <select class="multiple-select input" id="8" size="1" name="time[]">
                <option value="day">За день</option>
                <option selected value="week">За неделю</option>
                <option value="month">За месяц</option>
            </select>
        </div>
        <div class="field-container">
            <label class="search-task__name" for="9">Поиск по названию</label>
            <input class="input-middle input" id="9" type="search" name="q" placeholder="">
        </div>
        <button class="button" type="submit">Искать</button>

        <?php

        ActiveForm::end();

        ?>

    </div>
</section>
