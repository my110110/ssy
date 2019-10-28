<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $group app\models\Group */
/* @var $model app\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">

    <?php $form = ActiveForm::begin(
            [
                'id'=>'Group',
                'options' => ['enctype' => 'multipart/form-data']
            ]);
    ?>
    <?=$form->field($sample,'name')->textInput() ?>
    <?=$form->field($sample,'descript')->textInput() ?>
    <?= $form->field($sample, 'gid',['options'=>['tag'=>false]])->hiddenInput()->label(false)?>
    <?= $form->field($sample, 'pid',['options'=>['tag'=>false]])->hiddenInput()->label(false)?>
    <div class="form-group text-right">
        <?= Html::submitButton('提交', ['class' => $sample->isNewRecord ? 'btn btn-success ' : 'btn btn-primary ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>