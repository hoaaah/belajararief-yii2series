<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\administrator\models\CategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'id')])->label(false) ?>

    <?= $form->field($model, 'name')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'name')])->label(false) ?>

    <?= $form->field($model, 'created_at')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'created_at')])->label(false) ?>

    <?= $form->field($model, 'updated_at')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'updated_at')])->label(false) ?>

    <?= $form->field($model, 'created_by')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'created_by')])->label(false) ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
