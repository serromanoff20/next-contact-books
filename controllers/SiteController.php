<?php

namespace app\controllers;

use app\models\authors\Author;
use app\models\Books;
use app\models\forms\AddAuthor;
use app\models\forms\AddBook;
use app\models\forms\LoginForm;
use http\Exception\InvalidArgumentException;
use Yii;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['index', 'books', 'authors', 'add-book', 'add-author',],
            'rules' => [
                [
                    'actions' => ['index', 'books', 'authors', 'add-book', 'add-author',],
                    'allow' => true,
                    'roles' => ['?', '@'],//all users
                ],
            ],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index' => ['get'],
                'books' => ['get'],
                'authors' => ['get'],
                'add-book' => ['get', 'post'],
                'add-author' => ['get', 'post'],
            ]
        ];

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_HTML,
            ],
        ];


        return $behaviors;
    }

    /**
     * Отоброжение главной страницы. На главной странице отображено 10 книг;
     *
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * Страница со полным списком книг;
     *
     * @return string
     */
    public function actionBooks(): string
    {
        return $this->render('books');
    }

    /**
     * Страница со всем существующими авторами;
     *
     * @return string
     */
    public function actionAuthors(): string
    {
        return $this->render('authors');
    }

    /**
     * Создание книги;
     *
     * @return string
     * @throws InvalidConfigException
     */
    public function actionAddBook(): string
    {
        $message = '';
        $isSuccess = false;

        $modelForm = new AddBook();
        if (Yii::$app->getRequest()->isPost) {
            $params = Yii::$app->getRequest()->getBodyParams();
            if ($modelForm->load($params['AddBook'], "")) {

                $model = new Books();
                if ($modelForm->addBook($model)) {
                    $message = 'Книга успешно добавлена!';
                    $isSuccess = true;
                } else {
                    $message = $model->getErrors();
                }

            }
        }

        return $this->render('add-book', ['model' => $modelForm, 'message' => $message, 'isSuccess' => $isSuccess]);
    }

    /**
     * Создание автора;
     *
     * @return string
     * @throws InvalidConfigException
     */
    public function actionAddAuthor(): string
    {
        $message = '';
        $isSuccess = false;

        $modelForm = new AddAuthor();
        if (Yii::$app->getRequest()->isPost) {
            $params = Yii::$app->getRequest()->getBodyParams();
            if ($modelForm->load($params['AddAuthor'], "")) {

                $model = new Author();
                if ($modelForm->addAuthor($model)) {
                    $message = 'Автор успешно добавлен!';
                    $isSuccess = true;
                } else {
                    $message = $model->getErrors('Error');
                }

            }
        }

        return $this->render('add-author', ['model' => $modelForm, 'message' => $message, 'isSuccess' => $isSuccess]);
    }

    /**
     * Страница редактирования книги;
     *
     * @return string
     */
    public function actionCardBook(): string
    {
        $id = Yii::$app->getRequest()->getQueryParam('id-book') ?? 0;

        return $this->render('card-book', ['model' => Books::findOne(['id' => $id])]);
    }

    /**
     * Страница редактирования автора;
     *
     * @return string
     */
    public function actionCardAuthor(): string
    {
        $id = Yii::$app->getRequest()->getQueryParam('id-author') ?? 0;

        return $this->render('card-author', ['model' => Author::findOne(['id' => $id])]);
    }
}
