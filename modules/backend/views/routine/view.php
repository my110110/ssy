<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\backend\models\AdminUser;
/* @var $this yii\web\View */
/* @var $model app\models\Project */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '常规染色', 'url' => ['index']];

?>
<div class="content-view">


    <p>
        <?= Html::a('返回列表', ['index'], [
            'title'=>'返回列表',
            'class' => 'btn btn-primary',

        ]) ?>
        <?= Html::a('添加检测试剂', ['reagent/create', 'id' => $model->id,'type'=>'routine'], [
            'title'=>'添加负责人',
            'class' => 'btn btn-success',

        ]) ?>

        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-warning','title'=>'修改']) ?>
        <?= Html::a('删除', ['del', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'title'=>'删除',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

    </p>
    <div class="tab-content cos">
        <div class="row clearfix">
            <?php $form = ActiveForm::begin([
                'action' => [
                    'reagent/uploadfile',
                    'type'=>'routine',
                    'pid'=>$model->id,
                    'tid'=>$model->id
                ],
                'method' => 'post',
                'options' => ['enctype' => 'multipart/form-data']
            ]); ?>

            <?= $form->field($file, 'file',
                ['options'=>
                    ['tag'=>false ],
                    'template' => '<div class=" col-md-2 column ace-file-input"> 
                             {input}</div>',

                ])->fileInput() ?>
            <?= Html::submitButton('导入检测试剂', ['class' => 'btn btn-primary uploadfile']) ?>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
    <div class="row clearfix" style="margin-top: 10px;">
        <div class="col-md-12 column">
            <table class="table table-hover table-bordered">
                <tbody>
                <tr class="info">

                  <td class="col-md-2">检测指标名称</td>
                    <td class="col-md-10"><?=$model->name?></td>
                </tr>
                <tr class="default">

                    <td class="col-md-2">检索号</td>
                    <td class="col-md-10"><?=$model->retrieve?></td>
                </tr>

                <tr class="info">
                    <td class="col-md-2">检测流程</td>
                    <td class="col-md-10"><?=$model->process?></td>
                </tr>
                <tr class="success">
                    <td class="col-md-2">检测原理</td>
                    <td class="col-md-10"><?=$model->axiom?></td>
                </tr>
                <tr class="default">
                    <td class="col-md-2">添加人</td>
                    <td class="col-md-10"><?=AdminUser::getDoName($model->id,1,'routine')?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">添加时间</td>
                    <td class="col-md-10"><?=$model->add_time?></td>
                </tr>
                <?php if(!empty($model->change_user)):?>
                <tr class="warning">
                    <td class="col-md-2">修改人</td>
                    <td class="col-md-10"><?=AdminUser::getDoName($model->id,3,'routine')?></td>
                </tr>
                    <tr class="default">
                        <td class="col-md-2">修改时间</td>
                        <td class="col-md-10"><?=$model->change_time?></td>
                    </tr>
                <?php endif;?>

                <?php if(count($child)>0) :?>
                    <?php foreach ($child as $child):?>
                        <tr class="info">
                            <td class="col-md-2">检测试剂</td>
                            <td class="col-md-10">
                                <?= Html::a("$child->name", ['reagent/view', 'id' => $child->id]) ?>

                                <?= Html::a('', ['reagent/update', 'id' => $child->id,'type'=>$child->type], ['class' => 'glyphicon glyphicon-pencil','title'=>'修改']) ?>
                                <?= Html::a('', ['reagent/del', 'id' => $child->id], ['class' => 'glyphicon glyphicon-trash','title'=>'删除']) ?>

                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>

                </tbody>
            </table>


</div>
