<?php

namespace app\modules\administrator\controllers;

use Yii;
use app\models\Blog;
use app\modules\administrator\models\BlogSearch;
use app\modules\administrator\models\StatistikSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StatistikController implements the CRUD actions for Blog model.
 */
class StatistikController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index',  'title'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
        $searchModel = new StatistikSearch();
        $dataJson = '[{"month":"", "count":""}]';
        if($searchModel->load(Yii::$app->request->queryParams)){
            $dataJson = $searchModel->getBlogCountByMonthJson();
            // return var_dump($dataJson);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataJson' => $dataJson,
        ]);
    }

    public function actionTitle() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $user_id = $parents[0];
                $out = self::getTitleList($user_id); 
                // the getSubCatList function will query the database based on the
                // user_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-user_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }

    private function getTitleList($user_id)
    {
        $blog = Blog::find()->select(['slug as id', 'title as name'])->where(['created_by' => $user_id])->asArray()->all();
        return $blog ?? ['id' => '', 'name' => ''];
    }

}
