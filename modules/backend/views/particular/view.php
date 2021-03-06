<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\backend\models\AdminUser;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Project */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '检测指标列表', 'url' => ['index']];

?>
<div class="content-view">

    <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
        <div class="clearfix">
                <div class="pull-left">

                <?= Html::a('添加检测方法', ['testmethod/create', 'id' => $model->id], [
                    'title'=>'添加负责人',
                    'class' => 'btn btn-success',

                ]) ?>

                <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-warning','title'=>'修改']) ?>
                <?= Html::a('删除', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'title'=>'删除',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>

                </div>
                <div class="pull-right">
                    <div class="tab-content cos">
                        <div class="row clearfix">
                            <?php $form = ActiveForm::begin([
                                'action' => ['testmethod/uploadfile','pid'=>$model->id],
                                'method' => 'post',
                                'options' => ['enctype' => 'multipart/form-data']
                            ]); ?>

                            <?= $form->field($file, 'file',
                                ['options'=>
                                    ['tag'=>false ],
                                    'template' => '<div class=" col-md-2 column ace-file-input"> 
                                             {input}</div>',

                                ])->fileInput() ?>
                            <?= Html::submitButton('上传检测方法', ['class' => 'btn btn-primary uploadfile']) ?>
                            <?php ActiveForm::end(); ?>
                        </div>

                    </div>
        </div>
    <?php endif;?>
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


                <tr class="default">
                    <td class="col-md-2">添加人</td>
                    <td class="col-md-10"><?=AdminUser::getDoName($model->id,1,'particular')?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">添加时间</td>
                    <td class="col-md-10"><?=$model->add_time?></td>
                </tr>
                <?php if(!empty($model->change_user)):?>
                <tr class="warning">
                    <td class="col-md-2">修改人</td>
                    <td class="col-md-10"><?=AdminUser::getDoName($model->id,3,'particular')?></td>
                </tr>
                    <tr class="default">
                        <td class="col-md-2">修改时间</td>
                        <td class="col-md-10"><?=$model->change_time?></td>
                    </tr>
                <?php endif;?>

                <?php if(count($child)>0) :?>
                    <?php foreach ($child as $child):?>
                        <tr class="info">
                            <td class="col-md-2">检测方法</td>
                            <td class="col-md-10">
                                <?= Html::a("$child->name", ['testmethod/view', 'id' => $child->id]) ?>
                        <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
                                <?= Html::a('<button type="button" class="btn btn-warning btn-xs">修改</button>', ['testmethod/update', 'id' => $child->id], ['title'=>'修改']) ?>
                                <?= Html::a('<button type="button" class="btn btn-danger btn-xs">删除</button>', ['testmethod/del', 'id' => $child->id], ['title'=>'删除']) ?>
                         <?php endif;?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>

                </tbody>
            </table>


</div>
