<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post">
    <div class="row">
        <div class="col-md-10">
            <h2><?= Html::encode($model->title) ?></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">    
            <div class="btn-group" role="group" aria-label="...">
                <?php // Html::a("Username", false, ['class' => 'btn btn-default']) ?>
                <?= Html::a('<i class="glyphicon glyphicon-calendar" ></i> '.Yii::$app->formatter->asDate($model->created_at), false, ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">    
            <?= HtmlPurifier::process($model->body) ?>    
        </div>
    </div>
</div>