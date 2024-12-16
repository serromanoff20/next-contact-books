<?php

/* @var $this yii\web\View */
/* @var $model Author */

use app\models\authors\Author;

//$options = $model->getAuthorOption($model->author_id);
?>
<div class="site-login">
    <h1>id: <?= $model->id ?></h1>
    <br />
    <div id="message" class="display-none">
        <p></p>
    </div>
    <br />

    <form class="site-login" id="formEditingAuthor">

        <div class="mb-3 row">
            <label for="full_name" class="col-lg-2 control-label">Полное ФИО: </label>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?= $model->full_name ?>">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="short_name" class="col-lg-2 control-label">Фамилия: </label>
            <div class="col-lg-3">
                <input type="text" class="form-control" id="short_name" name="short_name" value="<?= $model->short_name ?>">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="birthday_date" class="col-lg-2 control-label">Дата рождения: </label>
            <div class="col-lg-3">
                <input type="text" class="form-control" id="birthday_date" name="birthday_date" value="<?= $model->birthday_date ?>">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="death_date" class="col-lg-2 control-label">Дата смерти: </label>
            <div class="col-lg-3">
                <input type="text" class="form-control" id="death_date" name="death_date" value="<?= $model->death_date ?>">
            </div>
        </div>

        <div class="buttons">
            <input type="button" onclick="editAuthor(<?= $model->id ?>)" class="btn btn-primary" value="&#9998; Редактировать">
            <input type="button" onclick="removeAuthor(<?= $model->id ?>)" class="btn btn-primary" value="&#10060; Удалить">
        </div>
    </form>
</div>

