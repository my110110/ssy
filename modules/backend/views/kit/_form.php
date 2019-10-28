<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\Kit */

?>

<div class="content-form">

    <?php $form = ActiveForm::begin(
            [
                'options' => ['enctype' => 'multipart/form-data']
            ]);
    ?>
    <?=$form->field($model,'name')->textInput() ?>
    <?=$form->field($model,'company')->textInput() ?>
    <?=$form->field($model,'number')->textInput() ?>
    <?=$form->field($model,'http')->textInput() ?>
    <?= $form->field($model, 'file')->fileInput() ?>
    <?php if($model->pdf):?>
        <?=$model->pdf?>
    <?php endif;?>
    <?= $form->field($model, 'type',['options'=>['tag'=>false]])->hiddenInput()->label(false)?>
    <?= $form->field($model, 'rid',['options'=>['tag'=>false]])->hiddenInput()->label(false)?>
    <div class="form-group text-right">
        <?= Html::submitButton('提交', ['class' => $model->isNewRecord ? 'btn btn-success ' : 'btn btn-primary ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>