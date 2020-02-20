<?php

use app\assets\ChartJsAsset;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\administrator\models\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;


// Register ChartJsAsset
ChartJsAsset::register($this);
?>
<div class="blog-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    

    <div class="col-md-12">

        <canvas id="blogCountByMonthChart"></canvas>

    </div>


</div>
<?php
// then register our Js
$this->registerJs(<<<JS
    // we create function for generate count per month first
    function generateDataCount(month, blogCount){
        var result = blogCount.find(o => o.month == month);
        if(result == null) return 0;
        return result.count;
    }

    var blogCount = $dataJson; // blogCount json
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