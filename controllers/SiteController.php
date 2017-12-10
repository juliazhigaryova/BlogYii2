<?php

namespace app\controllers;

use app\models\Comment;
use app\models\Post;
use app\models\Tag;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($link = null)
    {
        //echo $link;
        $query = Post::find();
        if($link !== null){
            $query = Post::find()->joinwith('fkTags')->where([Tag::tableName() . '.link' => $link]);
            //$query->andFilterWhere(['LIKE', Tag::tableName() . '.link', $link]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 9 //Количество постов на страницу
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionPost($id)
    {
        $model = Post::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Страницы не существует');
        }

        return $this->render('post', [
            'model' => $model,
        ]);
    }

    public function actionCreateComment(int $id)
    {

        $postModel = Post::findOne($id);
        if ($postModel === null) {
            throw new NotFoundHttpException('Поста с таким id не существует.');
        }

        if (!Yii::$app->user->can('blog_comment_create')) {
            throw new ForbiddenHttpException('Зарегистрируйтесь, чтобы добавить комментарий.');
        }

        $model = new Comment();

        if ($model->load(Yii::$app->request->post())) {
            $model->fk_post_id = $id; //Id поста, к которому добавляется комментарий
            $model->fk_user_id = Yii::$app->user->getId();
            if ($model->save()) {
                return $this->redirect(['site/post', 'id' => $id]);
            }
        }

        return $this->render('create-comment', [
            'model' => $model,
        ]);

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
//    public function actionLogin()
//    {
//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }
//
//        $model = new LoginForm();
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
//        }
//        return $this->render('login', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Logout action.
     *
     * @return Response
     */
//    public function actionLogout()
//    {
//        Yii::$app->user->logout();
//
//        return $this->goHome();
//    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
}
