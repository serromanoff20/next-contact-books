<?php namespace app\controllers;

use app\models\authors\Author;
use app\models\Books;
use app\models\forms\AddAuthor;
use app\models\forms\AddBook;
use DateTime;
use Exception;
use http\Exception\InvalidArgumentException;
use Yii;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class AjaxController extends Controller
{

    public function behaviors(): array
    {
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['delete-book',],
            'rules' => [
                [
                    'actions' => ['delete-book',],
                    'allow' => true,
                    'roles' => ['?', '@'],//all users
                ]
            ],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'delete-book' => ['delete'],

            ]
        ];

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];


        return $behaviors;
    }

    /**
     * Редактирование книги;
     */
    public function actionEditBook(): array
    {
        if (Yii::$app->getRequest()->isPut) {
            $id = Yii::$app->getRequest()->getBodyParam('id') ?
                (int)Yii::$app->getRequest()->getBodyParam('id') : 0;
            $name = Yii::$app->getRequest()->getBodyParam('name') ?
                (string)Yii::$app->getRequest()->getBodyParam('name') : '';
            $genre = Yii::$app->getRequest()->getBodyParam('genre') ?
                (string)Yii::$app->getRequest()->getBodyParam('genre') : '';
            $public_year = Yii::$app->getRequest()->getBodyParam('public_year') ?
                (string)Yii::$app->getRequest()->getBodyParam('public_year') : '';
            $author_id = Yii::$app->getRequest()->getBodyParam('author_id') ?
                (int)Yii::$app->getRequest()->getBodyParam('author_id') : 0;

            $model = new Books();
            if (
                $model->load([
                    'id' => $id,
                    'name' => $name,
                    'genre' => $genre,
                    'public_year' => $public_year,
                    'author_id' => $author_id,
                ], '') && $model->editBook()
            ) {

                return [
                    'edited' => true,
                    'message' => 'Книга с id - ' . $id . ' отредактирована',
                    'redirectPage' => 'books',
                ];
            }

            return [
                'deleted' => false,
                'message' => $model->getErrors(),
            ];
        }

        return [
            'edited' => false,
            'message' => ['Error' => ['Invalid method request']],
        ];
    }

    /**
     * Удаление книги;
     */
    public function actionDeleteBook(): array
    {
        if (Yii::$app->getRequest()->isDelete) {
            $params = Yii::$app->getRequest()->getBodyParam('idBook') ?
                (int)Yii::$app->getRequest()->getBodyParam('idBook') : 0;

            $model = new Books();
            if ($model->load(['id' => $params], '') && $model->deleteBookById()) {

                return [
                    'deleted' => true,
                    'message' => 'Книга с id - ' . $params . ' была удалена',
                    'redirectPage' => 'books',
                ];
            }

            return [
                'deleted' => false,
                'message' => $model->getErrors(),
            ];
        }

        return [
            'deleted' => false,
            'message' => ['Error' => ['Invalid method request']],
        ];
    }

    /**
     * Редактирование автора;
     * @throws Exception
     */
    public function actionEditAuthor(): array
    {
        if (Yii::$app->getRequest()->isPut) {
            $id = Yii::$app->getRequest()->getBodyParam('id') ?
                (int)Yii::$app->getRequest()->getBodyParam('id') : 0;
            $full_name = Yii::$app->getRequest()->getBodyParam('full_name') ?
                (string)Yii::$app->getRequest()->getBodyParam('full_name') : '';
            $short_name = Yii::$app->getRequest()->getBodyParam('short_name') ?
                (string)Yii::$app->getRequest()->getBodyParam('short_name') : '';
            $birthday_date = Yii::$app->getRequest()->getBodyParam('birthday_date') ?
                (new DateTime(Yii::$app->getRequest()->getBodyParam('birthday_date')))->format('Y-m-d') : '';
            $death_date = Yii::$app->getRequest()->getBodyParam('death_date') ?
                (new DateTime(Yii::$app->getRequest()->getBodyParam('death_date')))->format('Y-m-d') : '';


            $model = new Author();
            if (
                $model->load([
                    'id' => $id,
                    'full_name' => $full_name,
                    'short_name' => $short_name,
                    'birthday_date' => $birthday_date,
                    'death_date' => $death_date,
                ], '') && $model->editAuthor()
            ) {

                return [
                    'edited' => true,
                    'message' => 'Автор с id - ' . $id . ' отредактирован',
                    'redirectPage' => 'authors',
                ];
            }

            return [
                'deleted' => false,
                'message' => $model->getErrors(),
            ];
        }

        return [
            'edited' => false,
            'message' => ['Error' => ['Invalid method request']],
        ];
    }

    /**
     * Удаление автора;
     */
    public function actionDeleteAuthor(): array
    {
        if (Yii::$app->getRequest()->isDelete) {
            $params = Yii::$app->getRequest()->getBodyParam('idAuthor') ?
                (int)Yii::$app->getRequest()->getBodyParam('idAuthor') : 0;

            $model = new Author();
            if ($model->load(['id' => $params], '') && $model->deleteAuthorById()) {

                return [
                    'deleted' => true,
                    'message' => 'Автор с id - ' . $params . ' был удалён',
                    'redirectPage' => 'authors',
                ];
            }

            return [
                'deleted' => false,
                'message' => $model->getErrors(),
            ];
        }

        return [
            'deleted' => false,
            'message' => ['Error' => ['Invalid method request']],
        ];
    }
}