<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\StringHelper;

?>
<div class="post">
    <h2><?= Html::a(Html::encode($model->title), ['/blog/'.$model->slug]) ?></h2>

    <div class="btn-group" role="group" aria-label="...">
        <?php // Html::a("Username", false, ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-calendar" ></i> '.Yii::$app->formatter->asDate($model->created_at), false, ['class' => 'btn btn-xs btn-default']) ?>
    </div>

    <?= StringHelper::truncateWords(HtmlPurifier::process($model->body), 30, Html::a("Read More &raquo;", ['/blog/'.$model->slug], [
        'class' => 'btn btn-default'
    ]), true) ?>
</div>