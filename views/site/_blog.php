<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\StringHelper;

?>
<div class="post">
    <h2><?= Html::a(Html::encode($model->title), ['/blog', 'slug' => $model->slug]) ?></h2>

    <?= StringHelper::truncateWords(HtmlPurifier::process($model->body), 30, Html::a("Read More &raquo;", ['blog', 'slug' => $model->slug], [
        'class' => 'btn btn-default'
    ]), true) ?>
</div>