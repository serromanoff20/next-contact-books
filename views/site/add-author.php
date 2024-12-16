<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model app\models\forms\AddAuthor */

/* @var $message string */
/* @var $isSuccess bool */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Добавить автора';
$this->params['breadcrumbs'][] = $this->title;

$isShowMessage = empty($message) ? 'none' : 'block';
$colorBorder = $isSuccess ? 'lightgreen' : 'darkred';

if (is_array($message)) $message = '';
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(
            [
                'method' => 'post',
                'action' => ['/site/add-author'],
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-2 control-label'],
                ],
            ]
    ); ?>
        <?= $form->field($model, 'full_name_field')->label('Полное ФИО') ?>
        <?= $form->field($model, 'short_name_field')->label('Сокращённое ФИО') ?>
        <?= $form->field($model, 'birthday_date_field')->textInput(['placeholder' => "например: 1970-01-01"])->label('Дата рождения') ?>
        <?= $form->field($model, 'death_date_field')->textInput(['placeholder' => "можно оставить поле пустым"])->label('Дата смерти')?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton($this->title, ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

    <div style="display: <?= $isShowMessage ?>; border: <?= $colorBorder ?> 2px solid;  border-radius: 5px; width: 40%; padding: 2%; margin: 2% 0">
        <p> <?= $message ?> </p>
    </div>
</div>
