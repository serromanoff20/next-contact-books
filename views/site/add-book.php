<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model app\models\forms\AddBook */

/* @var $message string */
/* @var $isSuccess bool */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use app\models\authors\Author;

$this->title = 'Добавить книгу';
$this->params['breadcrumbs'][] = $this->title;

$isShowMessage = empty($message) ? 'none' : 'block';
$colorBorder = $isSuccess ? 'lightgreen' : 'darkred';
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(
            [
                'method' => 'post',
                'action' => ['/site/add-book'],
                'id' => 'add-book',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-2 control-label'],
                ],
            ]
    ); ?>
        <?= $form->field($model, 'name_field')->label('Наименование книги') ?>
        <?= $form->field($model, 'public_year_field')->label('Год издания') ?>
        <?= $form->field($model, 'genre_field')->label('Жанр произведения') ?>
        <?= $form->field($model, 'author_id_field', ['labelOptions' => ['label' => 'Автор']])->dropdownList(
                Author::getShortNameAll()
        ) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton($this->title, ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

    <div class="col-lg-offset-1" style="color:#999;">
        <br />
        Если необходимого автора не нашли в списке, то можете добавить его по <strong><a href="/site/add-author">ссылке</a></strong>.
    </div>

    <div style="display: <?= $isShowMessage ?>; border: <?= $colorBorder ?> 2px solid;  border-radius: 5px; width: 40%; padding: 2%; margin: 2% 0">
        <p> <?= $message ?> </p>
    </div>
</div>
