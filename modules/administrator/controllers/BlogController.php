<?php

namespace app\modules\administrator\controllers;

use Yii;
use app\models\Blog;
use app\modules\administrator\models\BlogSearch;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
     * Lists all Blog models.
     * @return mixed
     */
    public function actionIndex()
    {
        // get current server year
        $year = date('Y');
        /**
         * create an array for count blog by year this year
         * this array will be use to create bar chart with chartjs
         */
        $blogCountByMonth = Blog::find()
        ->select(['MONTH(FROM_UNIXTIME(created_at)) month', 'count(id) AS count'])
        ->where("YEAR(FROM_UNIXTIME(created_at)) = $year")
        ->groupBy('MONTH(FROM_UNIXTIME(created_at))')->asArray()->all();

        // show list of blog created
        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'blogCountByMonth' => $blogCountByMonth,
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $render = "render";

        // if ajax request comes, overrider render to renderAjax
        if($request->isAjax) $render = "renderAjax";

        return $this->{$render}('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Blog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $render = "render";

        // if ajax request comes, overrider render to renderAjax
        if($request->isAjax) $render = "renderAjax";

        $model = $this->findModel($id);

        // if user who update different from user who create, scenario set to editByOther
        if($model->created_by != Yii::$app->user->identity->id) $model->scenario = 'editByOther';

        if ($model->load(Yii::$app->request->post())) {
            // prevent user from change title if that article is not created by them
            if($model->created_by != Yii::$app->user->identity->id) $model->title = $model->oldAttributes['title'];
            if($model->save()){
                if($request->isAjax) return 1;
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                if($request->isAjax) return 0;
            }
        }

        return $this->{$render}('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Blog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
