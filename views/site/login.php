<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model app\models\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>Для того что бы добавить товар в избранное, Вам необходимо войти:</p>-->
    <?php $form = ActiveForm::begin(
            [
                'method' => 'post',
                'action' => ['/site/login'],
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
            ]
    ); ?>
        <?= $form->field($model, 'email')->label('Почта') ?>
        <?= $form->field($model, 'password')->label('Пароль') ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton($this->title, ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

    <div class="col-lg-offset-1" style="color:#999;">
        <br />
        Рад приветствовать <strong>всех</strong> участников моего личного кабинета.
    </div>
</div>
