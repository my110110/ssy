<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $group app\models\Sample */
/* @var $model app\models\Stace */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">

    <?php $form = ActiveForm::begin(
            [
                'id'=>'Stace',
                'options' => ['enctype' => 'multipart/form-data']
            ]);
    ?>
    <?=$form->field($model,'name')->textInput() ?>
    <?=$form->field($model,'retrieve')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'sid',['options'=>['tag'=>false]])->hiddenInput()->label(false)?>
    <?= $form->field($model, 'type',['options'=>['tag'=>false]])->hiddenInput()->label(false)?>
    <?= $form->field($model, 'tid',['options'=>['tag'=>false]])->hiddenInput()->label(false)?>

    <div class="form-group text-right">
        <?= Html::submitButton('提交', ['class' => $model->isNewRecord ? 'btn btn-success ' : 'btn btn-primary ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>