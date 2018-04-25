<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->widget(DatePicker::className(), ['options' => ['class' => 'form form-control']]) ?>

    <?= $form->field($model, 'updated_at')->widget(DatePicker::className(), ['options' => ['class' => 'form form-control']]) ?>

    <?= $form->field($model, 'created_by')->dropdownList(ArrayHelper::map($users, 'id', 'username'),
        ['prompt'=>'Select User']
    ); ?>

    <?= $form->field($model, 'updated_by')->dropdownList(ArrayHelper::map($users, 'id', 'username'),
        ['prompt'=>'Select User']
    ); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
