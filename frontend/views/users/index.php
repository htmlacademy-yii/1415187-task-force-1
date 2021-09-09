<?php
/**
 * @var $this  yii\web\View
 * @var $users \frontend\controllers\UsersController
 */

use backend\helpers\BaseHelper;

?>

<section class="user__search">
    <?php foreach ($users as $user):
        if (!empty($user->specialisation)):
            $taskCount = count($user->completedTasksExecutor);
            $opinionCount = count($user->opinionsExecutor);
            $rating = round($user->opinionsExecutorRate['rating'], 2); ?>
            <div class="content-view__feedback-card user__search-wrapper">
                <div class="feedback-card__top">
                    <div class="user__search-icon">
                        <a href="user.html"><img src="<?= $user->avatar ?>" width="65" height="65"></a>
                        <span><?= "{$taskCount} " . BaseHelper::get_noun_plural_form($taskCount, 'tasks') ?></span>
                        <span><?= "{$opinionCount} " . BaseHelper::get_noun_plural_form($opinionCount, 'feedbacks') ?></span>
                    </div>
                    <div class="feedback-card__top--name user__search-card">
                        <p class="link-name"><a href="user.html" class="link-regular"><?= $user->name ?></a></p>
                        <span <?= $rating < 1 ? 'class="star-disabled"' : '' ?>></span><span <?= $rating < 2 ? 'class="star-disabled"' : '' ?>></span><span <?= $rating < 3 ? 'class="star-disabled"' : '' ?>></span><span <?= $rating < 4 ? 'class="star-disabled"' : '' ?>></span><span <?= $rating < 5 ? 'class="star-disabled"' : '' ?>></span>
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
        <?php endif; ?>
    <?php endforeach; ?>
</section>

<section class="search-task">
    <div class="search-task__wrapper">
        <form class="search-task__form" name="users" method="post" action="#">
            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                <input class="visually-hidden checkbox__input" id="101" type="checkbox" name="" value="" checked
                       disabled>
                <label for="101">Курьерские услуги </label>
                <input class="visually-hidden checkbox__input" id="102" type="checkbox" name="" value="" checked>
                <label for="102">Грузоперевозки </label>
                <input class="visually-hidden checkbox__input" id="103" type="checkbox" name="" value="">
                <label for="103">Переводы </label>
                <input class="visually-hidden checkbox__input" id="104" type="checkbox" name="" value="">
                <label for="104">Строительство и ремонт </label>
                <input class="visually-hidden checkbox__input" id="105" type="checkbox" name="" value="">
                <label for="105">Выгул животных </label>
            </fieldset>
            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <input class="visually-hidden checkbox__input" id="106" type="checkbox" name="" value="" disabled>
                <label for="106">Сейчас свободен</label>
                <input class="visually-hidden checkbox__input" id="107" type="checkbox" name="" value="" checked>
                <label for="107">Сейчас онлайн</label>
                <input class="visually-hidden checkbox__input" id="108" type="checkbox" name="" value="" checked>
                <label for="108">Есть отзывы</label>
                <input class="visually-hidden checkbox__input" id="109" type="checkbox" name="" value="" checked>
                <label for="109">В избранном</label>
            </fieldset>
            <label class="search-task__name" for="110">Поиск по имени</label>
            <input class="input-middle input" id="110" type="search" name="q" placeholder="">
            <button class="button" type="submit">Искать</button>
        </form>
    </div>
</section>
