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

    <?php $form = ActiveForm::begin(
            [
                'id'=>'project',
                'options' => ['enctype' => 'multipart/form-data']
            ]);
    ?>

    <?=$form->field($principal,'name')->textInput() ?>
    <?=$form->field($principal,'department')->textInput() ?>
    <?=$form->field($principal,'email')->textInput() ?>
    <?=$form->field($principal,'telphone')->textInput() ?>

    <div class="form-group text-right">
        <?= Html::submitButton('提交', ['class' => $principal->isNewRecord ? 'btn btn-success ' : 'btn btn-primary ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>