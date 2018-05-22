<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $principal app\models\Principal */
/* @var $model app\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'pro_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pro_keywords')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pro_kind_id')->dropDownList($model::$kind_type) ?>
    <?=$form->field($model,'pro_sample_count')->textInput() ?>
    <?=$form->field($principal,'name')->textInput() ?>
    <?=$form->field($principal,'department')->textInput() ?>
    <?=$form->field($principal,'email')->textInput() ?>
    <?=$form->field($principal,'telphone')->textInput() ?>
    <?= $form->field($model, 'pro_description')->textarea() ?>

    <div class="form-group text-right">
        <?= Html::submitButton('提交', ['class' => $model->isNewRecord ? 'btn btn-success ' : 'btn btn-primary ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>