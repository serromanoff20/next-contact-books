<?php

namespace app\controllers;

use app\models\FavoritesGoods;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\models\forms\RegForm;
use yii\base\InvalidConfigException;
use app\models\forms\LoginForm;

class AuthController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['login', 'myindex', 'logout'],
            'rules' => [
                [
                    'actions' => ['login'],
                    'allow' => true,
                    'roles' => ['?', '@'] //all users
                ],
                [
                    'actions' => ['myindex', 'logout'],
                    'allow' => true,
                    'roles' => ['@'] //only log in users
                ]
            ]
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'login' => ['post'],
                'myindex' => ['get'],
                'logout' => ['get']
            ]
        ];
//        $behaviors['contentNegotiator'] = [
//            'class' => ContentNegotiator::class,
//            'formats' => [
//                'application/json' => Response::FORMAT_JSON,
//            ]
//        ];

        return $behaviors;
    }

    public function actionLogin()
    {
        if (Yii::$app->getRequest()->isGet && Yii::$app->user->isGuest) {
            return $this->render('login', ['model' => (new LoginForm())]);
        }

        if(Yii::$app->getRequest()->isPost) {
            $params = Yii::$app->getRequest()->getBodyParams()['LoginForm'];
            $user = new User();
            $model = new LoginForm();

            if ($model->load([
                'email' => $params['email'],
                'password' => $params['password']
            ],''))
            {
                $user = $model->registration();
            }
            return $this->render('myindex', ['model' => $user]);
        }
    }



    /**
     * Logout action.
     */
    public function actionLogout()
    {
        if (Yii::$app->request->isGet) {
            $model = new User();
            if ($model->logout(Yii::$app->user->id)) {
                return $this->render('index');
//                return array("data" => [], "message" => 'success', "code" => 200);
            }
            return array("data" => [], "message" => $model->getErrors(), "code" => 400);
        }
//        return $this->render('error', ['error' => $model]);
        return array("data" => [], "message" => [], "code" => 500);
    }
}