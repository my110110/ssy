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
    <?=$form->field($model,'OfficialSymbol')->textInput() ?>
    <?=$form->field($model,'OfficialFullName')->textInput() ?>
    <?=$form->field($model,'GeneID')->textInput() ?>
    <?=$form->field($model,'function')->textInput() ?>
    <?=$form->field($model,'NCBIgd')->textInput() ?>
    <?=$form->field($model,'GeneGards')->textInput() ?>
    <?=$form->field($model,'standard')->textInput() ?>
    <?=$form->field($model,'cells')->textInput() ?>
    <div class="form-group text-right">
        <?= Html::submitButton('提交', ['class' => $model->isNewRecord ? 'btn btn-success ' : 'btn btn-primary ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>