<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\assets\ChartJsAsset;
use yii\helpers\Json;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\administrator\models\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;

// Register ChartJsAsset
ChartJsAsset::register($this);
?>
<div class="blog-index">
    <div class="row">
        
        <div class="col-md-12">

            <h1><?= Html::encode($this->title) ?></h1>
        
        </div>
    
    </div>

    <div class="row">

        <div class="col-md-6">

            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Create Blog', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'title',
                    [
                        'attribute' => 'body',
                        'format' => 'raw',
                        'value' => function ($model){
                            return StringHelper::truncateWords(strip_tags($model->body, "<image>"), 30, "", true);
                        }
                    ],
                    [
                        'attribute' => 'created_by',
                        'value' => 'userCreator.username'
                    ],
                    'created_at:date',
                    // 'userCreator.username',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        
        </div>

        <div class="col-md-6">

            <canvas id="blogCountByMonthChart"></canvas>

        </div>

    </div>

</div>
<?php 
// first with convert our php array object to json
$blogCountByMonthJson = Json::encode($blogCountByMonth);

// then register our Js
$this->registerJs(<<<JS
    // we create function for generate count per month first
    function generateDataCount(month, blogCount){
        var result = blogCount.find(o => o.month == month);
        if(result == null) return 0;
        return result.count;
    }

    var blogCount = $blogCountByMonthJson; // blogCount json
    var ctx = document.getElementById('blogCountByMonthChart').getContext('2d'); //ctx, you can replace it with jQuery if you have one

    // Then we generate data with some simple looping
    var i = 0;
    data = [];
    while(i < 12)
    {
        data[i] = generateDataCount(i+1, blogCount);
        i++;
    }

    // and then generate to chartJs
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Blog Count By Month",
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: data,
            }]
        },
        options: {}
    });
JS
);
?>