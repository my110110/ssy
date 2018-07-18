<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
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
    <?=$form->field($group,'group_name')->textInput() ?>
    <?=$form->field($group,'group_sample_count')->textInput() ?>
    <?= $form->field($group, 'group_experiment_type')->textarea() ?>
    <?=$form->field($group,'group_description')->textInput() ?>
    <?= $form->field($group, 'imageFile')->widget(
        FileInput::class,
        [
            'pluginOptions' => [
                'showUpload' => false,
                'initialPreview' => empty($group->url)?'':[\yii\helpers\Url::to($group->url)],
                'initialPreviewAsData' => true,
            ],
            'pluginEvents' => [
                "fileclear" => "function() { $('#products-image').val('');}",
            ],
        ]
    ) ?>
    <?= $form->field($group, 'pro_id',['options'=>['tag'=>false]])->hiddenInput()->label(false)?>
    <div class="form-group text-right">
        <?= Html::submitButton('提交', ['class' => $group->isNewRecord ? 'btn btn-success ' : 'btn btn-primary ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>