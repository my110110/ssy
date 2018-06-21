<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;

use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $principal app\models\Principal */
/* @var $model app\models\Sdyeing */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">

    <?php $form = ActiveForm::begin(
            [
                'id'=>'project',
                'options' => ['enctype' => 'multipart/form-data']
            ]);
    ?>
    <?= $form->field($model, 'section_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'section_type')->dropDownList($model::$section_type) ?>



    <div class="form-group">
        <label class="control-label" for="sdyeing-nid">检测指标</label>
        <select id="sdyeing-nid" class="part form-control" name="Sdyeing[nid]" aria-invalid="false">
            <?php if(count($routine)>0) :?>
                <?php foreach ($routine as $routine):?>
                    <option value="<?=$routine->id?>" <?php if($routine->id==$model->nid){echo 'selected';}?>><?=$routine->name?></option>
                <?php endforeach;?>
            <?php endif;?>
        </select>

        <div class="help-block"></div>
    </div>
<div class="form-group">
    <label class="control-label" >使用试剂</label>
    <div id="sdyeing-kit">
        <?php if(count($reagent)>0) :?>
            <?php foreach ($reagent as $reagent):?>
            <div class="checkbox id<?=$reagent->sid?>  hid" ><label><input type="checkbox" name="Sdyeing[rgid][]" value="<?=$reagent->id?>" <?php if(in_array($reagent->id,json_decode($model->rgid))){echo 'checked';}?>><?=$reagent->name?></label></div>
            <?php endforeach;?>
        <?php endif;?>
    </div>

<div class="help-block"></div>
</div>
    <?=$form->field($model,'section_thickness')->textInput() ?>
    <?=$form->field($model,'section_preprocessing')->textInput() ?>
    <?=$form->field($model,'place')->textInput() ?>
    <?= $form->field($model, 'imageFile')->widget(
        FileInput::class,
        [
            'pluginOptions' => [
                'showUpload' => false,
                'initialPreview' => empty($model->img)?'':[\yii\helpers\Url::to($model->img)],
                'initialPreviewAsData' => true,
            ],
            'pluginEvents' => [
                "fileclear" => "function() { $('#products-image').val('');}",
            ],
        ]
    ) ?>
    <?= $form->field($model, 'img',['options'=>['style'=>'display:none']])->hiddenInput(['id'=>'products-image'])?>

    <?= $form->field($model, 'testflow')->widget(\kucha\ueditor\UEditor::className(), [
        'clientOptions' => [
            'serverUrl'=>yii\helpers\Url::to([$this->context->module->UEditorConfigAction]),
            'initialFrameHeight' => '200'
        ]
    ]) ?>
    <div class="form-group text-right">
        <?= Html::submitButton('提交', ['class' => $model->isNewRecord ? 'btn btn-success ' : 'btn btn-primary ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script><?php $this->beginBlock('js_end') ?>

    $(function(){
        $('.hid').each(function () {
            $(this).hide();
        })
        var id=$('.part').val();
        var ids='id'+id;
        var node=$('.'+ids);
        node.each(function () {
            $(this).show();
        })
        $('.part').change(function () {
            $('.hid').each(function () {
                $(this).hide();
            })
            var id=$(this).val();
            var ids='id'+id;
            var node=$('.'+ids);
            node.each(function () {
                $(this).show();
            })
        })
    })

    <?php $this->endBlock() ?>

</script>

<?php $this->registerJs($this->blocks['js_end'],\yii\web\View::POS_END); ?>
