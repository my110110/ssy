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
                'id'=>'project',
                'options' => ['enctype' => 'multipart/form-data']
            ]);
    ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?=$form->field($model,'retrieve')->textInput(['readonly'=>true]) ?>
    <div class="form-group text-right">
        <?= Html::submitButton('提交', ['class' => $model->isNewRecord ? 'btn btn-success ' : 'btn btn-primary ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>