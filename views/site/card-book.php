<?php

/* @var $this yii\web\View */
/* @var $model Books */

use app\models\Books;

$options = $model->getAuthorOption($model->author_id);
?>
<div class="site-login">
    <h1>id: <?= $model->id ?></h1>
    <br />
    <div id="message" class="d-none">
        <p></p>
    </div>
    <br />

        <form class="site-login" id="formEditingBook">
            <div class="mb-3 row required">
                <label for="name" class="col-lg-2 control-label">Название произведения: </label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" id="name" name="name" value="<?= $model->name ?>">
                </div>
            </div>

            <div class="mb-3 row required">
                <label for="genre" class="col-lg-2 control-label">Жанр: </label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" id="genre" name="genre" value="<?= $model->genre ?>">
                </div>
            </div>

            <div class="mb-3 row required">
                <label for="public_year" class="col-lg-2 control-label">Год издания: </label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" id="public_year" name="public_year" value="<?= $model->public_year ?>">
                </div>
            </div>

            <div class="mb-3 row required">
                <label for="author_id" class="col-lg-2 control-label">Выберите значение</label>
                <div class="col-lg-3">
                    <select class="form-control" id="author_id" name="author_id">
                        <option value="<?= $model->author_id ?>" selected><?= $model->getAuthorByAuthorId((int)$model->author_id) ?></option>
                        <?php foreach($options as $author_id => $short_name): ?>
                            <option value="<?= $author_id ?>"><?= $short_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="buttons">
                <input type="button" onclick="editBook(<?= $model->id ?>)" class="btn btn-primary" value="&#9998; Редактировать">
                <input type="button" onclick="removeBook(<?= $model->id ?>)" class="btn btn-primary" value="&#10060; Удалить">

            </div>
        </form>
</div>

