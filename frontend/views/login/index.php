<?php

/**
 * @var $loginForm LoginForm
 */

use common\models\LoginForm;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

ActiveForm::begin([
    'action' => ['site/login'],
    'options' => ['data-pjax' => true],
]);
?>

    <p>
        <?= Html::activeLabel($loginForm, 'email', ['class' => 'form-modal-description']) ?>
        <?= Html::activeTextInput($loginForm, 'email', ['class' => 'enter-form-email input input-middle', 'type' => 'email']) ?>
        <?php if ($loginForm->hasErrors('email')) { ?>
            <span style="color:red; padding-bottom: 10px"><?= $loginForm->getFirstError('email') ?></span>
        <?php } ?>
    </p>
    <p>
        <?= Html::activeLabel($loginForm, 'password', ['class' => 'form-modal-description']) ?>
        <?= Html::activePasswordInput($loginForm, 'password', ['class' => 'enter-form-email input input-middle']) ?>
        <?php if ($loginForm->hasErrors('password')) { ?>
            <span style="color:red; padding-bottom: 10px"><?= $loginForm->getFirstError('password') ?></span>
        <?php } ?>
    </p>
<?php

echo Html::submitButton('Войти', ['class' => 'button']);
ActiveForm::end();

?>