<?php

namespace app\modules\admin\controllers;

use app\models\ManyPostTag;
use app\models\Tag;
use Yii;
use app\models\Post;
use app\models\search\PostSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['blog_post_read'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'already'],
                        'roles' => ['blog_post_create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['blog_post_delete'],
                    ],
                    //Если не попадает ни под одно правило, запрещаем доступ
                    [
                        'allow' => false
                    ]
                ]
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAlready($id)
    {
        $returnArray = [];
        $model = $this->findModel($id);
        $tags = $model->fkTags;
        /** @var Tag $tag */
        foreach ($tags as $tag)
        {
            array_push($returnArray, $tag->content);
        }
        echo json_encode($returnArray);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //Связываем теги с постом
            foreach (explode(',', $model->editorTags) as $tagName) {
                $this->addTagToPost($tagName, $model->id);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException Если у пользователя нет прав на редактирование поста
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(!(Yii::$app->user->can('blog_post_update_own', ['model' => $model])
            || (Yii::$app->user->can('blog_post_update')))
        ){
            throw new ForbiddenHttpException('Доступ запрещен! #01');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //Удалить все теги
            ManyPostTag::deleteAll([
                'fk_post_id' => $model->id,
            ]);

            //Связываем теги с постом
            foreach (explode(',', $model->editorTags) as $tagName) {
                $this->addTagToPost($tagName, $model->id);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function addTagToPost($tag, $idPost)
    {
        if($idPost === null) return; //Не добавлся Пост

        $modelTag = Tag::findOne(['content' => $tag]);
        if($modelTag === null) return; //Если тега не существует

        //Проверяем, подвязан ли данный тег к текущему посту
        $modelPostAlready = ManyPostTag::findOne([
            'fk_tag_id' => $modelTag->id,
            'fk_post_id' => $idPost,
        ]);

        if($modelPostAlready !== null) return; //Тег уже добавлен к посту

        //Добавляем тег к посту
        $model = new ManyPostTag();
        $model->fk_post_id = $idPost;
        $model->fk_tag_id = $modelTag->id;
        return $model->save();
    }
}
