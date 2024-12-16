<?php

/* @var $this yii\web\View */
/* @var $model authors */
/* @var $favorites_goods array */

use app\models\authors\Authors;

$model = new Authors();

$model->getAllAuthors();
?>

<div class="site-login">
    <h1>Список авторов</h1>
    <br>
    <div class="all_data" id=data>
        <?php for($i = 0; $i < count($model->authors['id']); $i++): ?>
            <ul>
                <li><label>id: <?= $model->authors['id'][$i] ?></label></li>
                <li><label>Полное ФИО </label>: <?= $model->authors['full_name'][$i] ?></li>
                <li><label>Фамилия </label>: <?= $model->authors['short_name'][$i] ?></li>
                <li><label>Годы жизни </label>: <?= $model->authors['birthday_date'][$i] . " - " . $model->authors['death_date'][$i] ?></li>
            </ul>

            <div class="d-sm-inline-block">
                <input type="button" onclick="redirectCard(<?= $model->authors['id'][$i] ?>, 'authors')" class="btn btn-primary" value="&#9998; Редактировать">
                <input type="button" onclick="removeAuthor(<?= $model->authors['id'][$i] ?>)" class="btn btn-primary" value="&#10060; Удалить">
            </div>

            <br /><br />
        <?php endfor; ?>
    </div>
</div>
