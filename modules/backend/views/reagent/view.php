<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\backend\models\AdminUser;
/* @var $this yii\web\View */
/* @var $model app\models\Project */
$this->title = $model->name;

$this->params['breadcrumbs'][] = ['label' => '返回上级', ["$model->type/view", 'id' => $model->sid]];

?>
<div class="content-view">


    <div class="clearfix">
        <div class="pull-left">

        <?php if($ret==1):?>
            <?= Html::a('返回列表',["reagent/index"], [
                'title'=>'返回上级',
                'class' => 'btn btn-primary',

            ]) ?>

        <?php else:?>
            <?php if($model->type=='testmethod'):?>
            <?= Html::a('返回上级',["$model->type/view",'id'=>$model->tid], [
                'title'=>'返回上级',
                'class' => 'btn btn-primary',

            ]) ?>
            <?php else:?>
            <?= Html::a('返回上级',["$model->type/view",'id'=>$model->sid], [
                'title'=>'返回上级',
                'class' => 'btn btn-primary',

            ]) ?>
            <?php endif;?>
        <?php endif;?>
        <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
        <?= Html::a('新增公司信息', ['company/create', 'id' => $model->id], ['class' => 'btn btn-info ','title'=>'修改']) ?>

        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-warning','title'=>'修改']) ?>
        <?= Html::a('删除', ['del', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'title'=>'删除',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif;?>
        </div>
    <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
        <div class="pull-right">
    <div class="tab-content cos">
        <div class="row clearfix">
            <?php $form = ActiveForm::begin([
                'action' => ['company/uploadfile','pid'=>$model->id],
                'method' => 'post',
                'options' => ['enctype' => 'multipart/form-data']
            ]); ?>

            <?= $form->field($file, 'file',
                ['options'=>
                    ['tag'=>false ],
                    'template' => '<div class=" col-md-2 column ace-file-input"> 
                             {input}</div>',

                ])->fileInput() ?>
            <?= Html::submitButton('导入公司信息', ['class' => 'btn btn-primary uploadfile']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
    <?php endif;?>
    </div>
    <div class="row clearfix" style="margin-top: 10px;">
        <div class="col-md-12 column">
            <table class="table table-hover table-bordered">
                <tbody>
                <tr class="info">

                  <td class="col-md-2">名称</td>
                    <td class="col-md-10"><?=$model->name?></td>
                </tr>
                <tr class="default">

                    <td class="col-md-2">检索号</td>
                    <td class="col-md-10"><?=$model->retrieve?></td>
                </tr>




                <tr class="default">
                    <td class="col-md-2">添加人</td>
                    <td class="col-md-10"><?=AdminUser::getDoName($model->id,1,'reagent')?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">添加时间</td>
                    <td class="col-md-10"><?=$model->add_time?></td>
                </tr>
                <?php if(!empty($model->change_user)):?>
                <tr class="warning">
                    <td class="col-md-2">修改人</td>
                    <td class="col-md-10"><?=AdminUser::getUserName($model->change_user)?></td>
                </tr>
                    <tr class="default">
                        <td class="col-md-2">修改时间</td>
                        <td class="col-md-10"><?=$model->change_time?></td>
                    </tr>
                <?php endif;?>
                <?php if(count($child)>0) :?>
                    <?php foreach ($child as $child):?>
                        <tr class="success">
                            <td class="col-md-2">公司</td>
                            <td class="col-md-10">
                                <?= $child->company?>
                                <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
                                   <?= Html::a('<button type="button" class="btn btn-warning btn-xs">修改</button>', ['company/update', 'id' => $child->id], ['title'=>'修改']) ?>
                                   <?= Html::a('<button type="button" class="btn btn-danger btn-xs">删除</button>', ['company/del', 'id' => $child->id], ['title'=>'删除']) ?>
                                <?php endif;?>
                            </td>
                        </tr>
                        <tr class="warning">
                            <td>货号</td>
                            <td><?= $child->number?></td>
                        </tr>
                        <tr class="default">
                            <td>配置方法</td>
                            <td><?= $child->method?></td>
                        </tr>
                        <tr class="default">
                            <td>保存条件</td>
                            <td><?= $child->savetion?></td>
                        </tr>
                        <tr class="default">
                            <td>官网地址</td>
                            <td><?= $child->http?></td>
                        </tr>

                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>


</div>
