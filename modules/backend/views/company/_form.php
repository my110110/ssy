<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">

    <?php $form = ActiveForm::begin(
            [
                'id'=>'Stace',
                'options' => ['enctype' => 'multipart/form-data']
            ]);
    ?>
    <?=$form->field($model,'company')->textInput() ?>
    <?=$form->field($model,'number')->textInput() ?>
    <?=$form->field($model,'http')->textInput() ?>
    <?=$form->field($model,'method')->textInput() ?>
    <?=$form->field($model,'savetion')->textInput() ?>
    <?= $form->field($model, 'rid',['options'=>['tag'=>false]])->hiddenInput()->label(false)?>
    <div class="form-group text-right">
        <?= Html::submitButton('提交', ['class' => $model->isNewRecord ? 'btn btn-success ' : 'btn btn-primary ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>