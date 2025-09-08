<?php namespace app\controllers;

use app\models\authors\Author;
use app\models\books\Books;
use DateTime;
use Exception;
use Yii;
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
            'only' => ['select-books', 'edit-book', 'delete-book', 'edit-author', 'delete-author', ],
            'rules' => [
                [
                    'actions' => ['select-books', 'edit-book', 'delete-book', 'edit-author', 'delete-author', ],
                    'allow' => true,
                    'roles' => ['?', '@'],//all users
                ]
            ],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'select-books' => ['get'],
                'edit-book' => ['put'],
                'delete-book' => ['delete'],
                'edit-author' => ['put'],
                'delete-author' => ['delete'],

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

    public function actionSelectBooks(): array
    {
        $data = [];
        if (Yii::$app->getRequest()->isGet) {
            $sort = Yii::$app->getRequest()->getQueryParam('sortBy') ?? '';
            $filterOnProps = Yii::$app->getRequest()->getQueryParam('filterOnProps') ?? '';
            $filterByValue = Yii::$app->getRequest()->getQueryParam('filterByValue') ?? '';

            $model = new Books();
            if ( empty($filterByValue) ) {

                $data = $model->getAllBooks($sort);
            } else if ( !empty($filterOnProps) && !in_array($filterOnProps, $model->attributes()) ) {
                $authors_id = (new Author())->getAuthorIdByLikeShortName(trim($filterByValue));

                if ( !empty($authors_id) ) {

                    return $model->getAllBooks($sort, ['authors_id' => $authors_id]);
                }

                return $data;
            } else if ( !empty($filterOnProps) && in_array($filterOnProps, $model->attributes()) ) {

                $data = $model->getAllBooks($sort, [$filterOnProps => trim($filterByValue)]);
            }
        }

        return $data;
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
                    'data' => [
                        'edited' => true,
                        'redirectPage' => 'books',
                    ],
                    'messages' => 'Книга с id - ' . $id . ' отредактирована',
                ];
            }

            return [
                'data' => [
                    'edited' => false,
                ],
                'messages' => $model->getErrors(),
            ];
        }

        return [
            'data' => [
                'edited' => false,
            ],
            'messages' => ['Error' => ['Invalid method request']],
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
            if (
                $model->load(['id' => $params], '')
                && $model->deleteBookById()
            ) {

                return [
                    'data' => [
                        'deleted' => true,
                        'redirectPage' => 'books',
                    ],
                    'messages' => 'Книга с id - ' . $params . ' была удалена',
                ];
            }

            return [
                'data' => [
                    'deleted' => false,
                ],
                'messages' => $model->getErrors(),
            ];
        }

        return [
            'data' => [
                'deleted' => false,
            ],
            'messages' => ['Error' => ['Invalid method request']],
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
                    'data' => [
                        'edited' => true,
                        'redirectPage' => 'authors',
                    ],
                    'messages' => 'Автор с id - ' . $id . ' отредактирован',

                ];
            }

            return [
                'data' => [
                    'edited' => false,
                ],
                'messages' => $model->getErrors(),
            ];
        }

        return [
            'data' => [
                'edited' => false,
            ],
            'messages' => ['Error' => ['Invalid method request']],
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
                    'data' => [
                        'deleted' => true,
                        'redirectPage' => 'authors',
                    ],
                    'messages' => 'Автор с id - ' . $params . ' был удалён',
                ];
            }

            return [
                'data' => [
                    'deleted' => false,
                ],
                'messages' => $model->getErrors(),
            ];
        }

        return [
            'data' => [
                'deleted' => false,
            ],
            'messages' => ['Error' => ['Invalid method request']],
        ];
    }

    public function afterAction($action, $result): array
    {
        if ( empty($result) ) {
            return [
                'data' => [],
                'messages' => "Данные не найдены",
            ];
        }

        if ( isset($result['messages']) ) {
            return [
                'data' => $result['data'],
                'messages' => $result['messages'],
            ];
        }

        return [
            'data' => $result,
            'messages' => "",
        ];
    }
}