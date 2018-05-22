<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'pro_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pro_keywords')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pro_description')->textarea() ?>
    <?= $form->field($model, 'pro_kind_id')->dropDownList($model::$kind_type) ?>
    <?=$form->field($model,'pro_sample_count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>