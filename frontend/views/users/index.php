<?php
/**
 * @var $this  yii\web\View
 * @var $users UsersController
 * @var $filters UsersFilter
 */

use app\models\Category;
use backend\helpers\BaseHelper;
use frontend\controllers\UsersController;
use frontend\models\UsersFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<section class="user__search">
    <?php foreach ($users as $user):
        $taskCount = count($user->completedTasksExecutor);
        $opinionCount = count($user->opinionsExecutor);
        $rating = round($user->opinionsExecutorRate['rating'], 2); ?>
        <div class="content-view__feedback-card user__search-wrapper">
            <div class="feedback-card__top">
                <div class="user__search-icon">
                    <a href="user.html"><?= !empty($user->avatar) ? "<img src=\"<?= $user->avatar ?>\" width=\"65\" height=\"65\">" : ''; ?></a>
                    <span><?= "{$taskCount} " . BaseHelper::get_noun_plural_form($taskCount, 'tasks') ?></span>
                    <span><?= "{$opinionCount} " . BaseHelper::get_noun_plural_form($opinionCount, 'feedbacks') ?></span>
                </div>
                <div class="feedback-card__top--name user__search-card">
                    <p class="link-name"><a href="user.html" class="link-regular"><?= $user->name ?></a></p>
                    <span <?= $rating < 0.5 ? 'class="star-disabled"' : '' ?>></span><span <?= $rating < 1.5 ? 'class="star-disabled"' : '' ?>></span><span <?= $rating < 2.5 ? 'class="star-disabled"' : '' ?>></span><span <?= $rating < 3.5 ? 'class="star-disabled"' : '' ?>></span><span <?= $rating < 4.5 ? 'class="star-disabled"' : '' ?>></span>
                    <b><?= $rating ?></b>
                    <p class="user__search-content">
                        <?= $user->about ?>
                    </p>
                </div>
                <span class="new-task__time">Был на сайте <?= BaseHelper::time_difference($user->date_activity) ?> назад</span>
            </div>
            <div class="link-specialization user__search-link--bottom">
                <?php foreach ($user->specialisation as $spec): ?>
                    <a href="browse.html" class="link-regular"><?= $spec->category->name ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<section class="search-task">
    <div class="search-task__wrapper">

        <?php $form = ActiveForm::begin([
            'id' => 'TaskForm',
            'fieldConfig' => [
                'options' => [
                    'tag' => false,
                ],
            ],
            'options' => ['class' => 'search-task__form']
        ]);
        ?>

        <fieldset class="search-task__categories">
            <legend>Категории</legend>

            <?php echo $form->field($filters, 'categories', [
                'template' => '{input}',
                'labelOptions' => ['class' => 'checkbox__legend']
            ])->checkboxList(Category::getCategories(),
                ['item' => function ($index, $label, $name, $checked, $value) {
                    $chek = $checked ? 'checked' : "";
                    return "<label class=\"checkbox__legend\">
                                <input class=\"visually-hidden checkbox__input\" type=\"checkbox\" name=\"{$name}\" value=\"{$value}\" {$chek}>
                                <span>{$label}</span>
                            </label>";
                },
                ]
            ) ?>

        </fieldset>








<!--        <fieldset class="search-task__categories">-->
<!--            <legend>Дополнительно</legend>-->
<!--            --><?php //echo $form->field($filters, 'additionally', ['template' => '{input}'])
//                ->checkboxList(['free' => 'Сейчас свободен', 'online' => 'Сейчас онлайн', 'rew' => 'Есть отзывы', 'fav' => 'В избранном'],
//                    ['item' => function ($index, $label, $name, $checked, $value) {
//                        $chek = $checked ? 'checked' : "";
//                        return '<div><label class="checkbox__legend">'
//                            . '<input class="visually-hidden checkbox__input" type="checkbox" name="' . $name . '" value="' . $value . '" ' . $chek . '>'
//                            . '<span>' . $label . '</span>'
//                            . '</label></div>';
//                    },
//                    ]
//                ); ?>
<!--        </fieldset>-->

        <?php echo $form->field($filters, 'search', [
            'labelOptions' => ['class' => 'search-task__name'],
            'template' => '{label} {input}',
        ])->textInput(['class' => 'input-middle input'])->label('Поиск по имени');
        ?>

        <?php echo Html::submitButton('Искать', ['class' => 'button']) ?>
        <?php $form = ActiveForm::end(); ?>

    </div>
</section>
