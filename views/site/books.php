<?php

/* @var $this yii\web\View */
/* @var $model Books */

use app\models\Books;

$model = new Books();

$model->getAllBooks();

$this->params['id'] = $model::$_ids;
$this->params['name'] = $model::$_names;
$this->params['genre'] = $model::$_genre;
$this->params['public_year'] = $model::$_public_year;
$this->params['author'] = $model::$_author;

?>
<div class="site-login">
    <h1>Список книг</h1>
    <br />
    <div id="message" class="display-none">
        <p></p>
    </div>
    <br />
    <div class="all_data" id=data>
        <?php for($i=0; $i<count($this->params['id']); $i++): ?>
            <ul>
                <li><label>id: <?= $this->params['id'][$i] ?></label></li>
                <li><label>Название произведения </label>: <?= $this->params['name'][$i] ?></li>
                <li><label>Жанр </label>: <?= $this->params['genre'][$i] ?></li>
                <li><label>Год издания </label>: <?= $this->params['public_year'][$i] ?></li>
                <li><label>Автор </label>: <?= $this->params['author'][$i] ?></li>
            </ul>

            <div class="d-sm-inline-block">
                <input type="button" onclick="redirectCard(<?= $this->params['id'][$i] ?>, 'books')" class="btn btn-primary" value="&#9998; Редактировать">
                <input type="button" onclick="removeBook(<?= $this->params['id'][$i] ?>)" class="btn btn-primary" value="&#10060; Удалить">
            </div>
            <br /><br />
        <?php endfor; ?>
    </div>
</div>
