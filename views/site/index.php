<?php

/* @var $this yii\web\View */
/* @var $model app\models\Books */

use app\models\Books;

$this->title = 'My Books';

$model = new Books();

$model->getTenBooks();
?>

<div class="site-index">

    <div class="jumbotron">
        <h1>BOOKS</h1>
        <p>На данной странице отображены только 10 последних созданных книг</p>
        <br>
    </div>
    <div class="body-content">
        <div class="row pageMenu">
            <div class="col-lg-2">
                <h2>Все книги</h2>

                <p><a class="btn btn-default" href="/site/books">/site/books &raquo;</a></p>
            </div>
            <div class="col-lg-2">
                <h2>Все авторы</h2>

                <p><a class="btn btn-default" href="/site/authors">/site/authors &raquo;</a></p>
            </div>
        </div>

        <div class="row">
        <?php foreach ($model::$_names as $key => $name): ?>
            <div class="col-lg-4 book">
                <h3><?= $name ?></h3>
                <p>Жанр: <?= $model::$_genre[$key] ?></p>
                <p>Год публикации: <?= $model::$_public_year[$key] ?></p>
                <p>Автор: <?= $model::$_author[$key] ?></p>

                <p><a class="btn btn-default" href="/site/card-book?id-book=<?= $model::$_ids[$key] ?>">/site/card-book &raquo;</a></p>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>
