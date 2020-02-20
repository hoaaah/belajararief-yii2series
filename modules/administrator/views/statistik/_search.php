<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\administrator\models\BlogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'user_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username'),
        'options' => ['placeholder' => 'Select User ...'],
        'pluginOptions' => ['allowClear' => true]
    ]) ?>

    <?= $form->field($model, 'title')->widget(DepDrop::classname(), [
        'type' => DepDrop::TYPE_SELECT2,
        // 'data' => [2 => 'Tablets'],
        'options' => ['id' => 'statistiksearch-title', 'placeholder' => 'Title ...'],
        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
        'pluginOptions' => [
            'depends' => ['statistiksearch-user_id'],
            'url' => Url::to(['/administrator/statistik/title']),
            // 'params' => ['input-type-1', 'input-type-2']
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
