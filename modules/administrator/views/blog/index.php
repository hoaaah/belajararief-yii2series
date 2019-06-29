<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\assets\ChartJsAsset;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

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

            <p>
                <?= Html::a('Create Blog', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'id' => 'kv-grid-demo',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],
                    'title',
                    [
                        'attribute' => 'body',
                        'format' => 'raw',
                        'value' => function ($model){
                            return StringHelper::truncateWords(strip_tags($model->body, "<image>"), 30, "", true);
                        }
                    ],
                    [
                        'attribute' => 'category_id',
                        'value' => 'category.name',
                        'filter' => Select2::widget([
                            'model' => $searchModel,
                            'attribute' => 'category_id',
                            'data' => ArrayHelper::map(\app\models\Category::find()->all(), 'id', 'name'),
                            'options' => ['placeholder' => 'Category ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])
                    ],
                    [
                        'attribute' => 'created_by',
                        'value' => 'userCreator.username'
                    ],
                    'created_at:date',
                    // 'userCreator.username',

                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'noWrap' => true,
                    ],                    
                ],
                'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                'filterRowOptions' => ['class' => 'kartik-sheet-style'],
                'pjax' => true, // pjax is set to always true for this demo
                // set your toolbar
                'toolbar' =>  [
                    [
                        'content' =>
                            Html::a('<i class="fas fa-redo"></i>', ['grid-demo'], [
                                'class' => 'btn btn-outline-secondary',
                                'title'=> 'Reset Grid',
                                'data-pjax' => 0, 
                            ]), 
                        'options' => ['class' => 'btn-group mr-2']
                    ],
                    '{export}',
                    '{toggleData}',
                ],
                'toggleDataContainer' => ['class' => 'btn-group mr-2'],
                // set export properties
                'export' => [
                    'fontAwesome' => true
                ],
                // parameters from the demo form
                'bordered' => true,
                'striped' => true,
                'condensed' => true,
                'responsive' => true,
                'hover' => true,
                'showPageSummary' => true,
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => $this->title,
                ],
                'persistResize' => false,
                'toggleDataOptions' => ['minCount' => 10],
                // 'itemLabelSingle' => 'book',
                // 'itemLabelPlural' => 'books'
            ]) ?>
        
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