<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\backend\models\AdminUser;
use app\models\Project;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
$this->title = $model->group_name;
$this->params['breadcrumbs'][] = ['label' => '项目管理', 'url' => ['project/index']];

?>
<div class="content-view">


    <p>

        <?php if($ret==1):?>
            <?= Html::a('返回列表', ['group/index'], [
                'title'=>'返回列表',
                'class' => 'btn btn-primary',

            ]) ?>
        <?php else:?>
            <?= Html::a('返回项目', ['project/view', 'id' => $model->pro_id], [
                'title'=>'返回项目',
                'class' => 'btn btn-primary',

            ]) ?>
        <?php endif;?>
        <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
        <?= Html::a('添加样品', ['sample/create', 'id' => $model->id], ['class' => 'btn btn-info','title'=>'新增样品']) ?>

        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-warning','title'=>'修改']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'title'=>'删除',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif;?>
    </p>
    <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
    <div class="tab-content cos">
        <div class="row clearfix">
            <?php $form = ActiveForm::begin([
                'action' => ['sample/uploadfile','pid'=>$model->id],
                'method' => 'post',
                'options' => ['enctype' => 'multipart/form-data']
            ]); ?>

            <?= $form->field($file, 'file',
                ['options'=>
                    ['tag'=>false ],
                    'template' => '<div class=" col-md-2 column ace-file-input"> 
                             {input}</div>',

                ])->fileInput() ?>
            <?= Html::submitButton('导入样品', ['class' => 'btn btn-primary uploadfile']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <?php endif;?>
    <div class="row clearfix" style="margin-top: 10px;">
        <div class="col-md-12 column">
            <table class="table table-hover table-bordered">
                <tbody>
                <tr class="info">

                  <td class="col-md-2">分组名称</td>
                    <td class="col-md-10"><?=$model->group_name?></td>
                </tr>
                <tr class="default">

                    <td class="col-md-2">分组检索号</td>
                    <td class="col-md-10"><?=$model->group_retrieve?></td>
                </tr>


                <tr class="success">
                    <td class="col-md-2">分组样品数</td>
                    <td class="col-md-10"><?=$model->group_sample_count?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">样品处理方式</td>
                    <td class="col-md-10"><?=$model->group_experiment_type?></td>
                </tr>
                <tr class="parmary">
                    <td class="col-md-2">分组描述</td>
                    <td class="col-md-10"><?=$model->group_description?></td>
                </tr>
                <tr class="waring">
                    <td class="col-md-2">样本图片</td>
                    <td class="col-md-10"><img src="<?=$model->url?>"></td>
                </tr>
                <tr class="default">
                    <td class="col-md-2">分组添加人</td>
                    <td class="col-md-10"><?=AdminUser::getUserName($model->group_add_user)?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">分组添加时间</td>
                    <td class="col-md-10"><?=$model->group_add_time?></td>
                </tr>
                <?php if(!empty($model->group_change_user)):?>
                <tr class="warning">
                    <td class="col-md-2">项目修改人</td>
                    <td class="col-md-10"><?=AdminUser::getUserName($model->group_change_user)?></td>
                </tr>
                    <tr class="default">
                        <td class="col-md-2">项目修改时间</td>
                        <td class="col-md-10"><?=$model->group_change_time?></td>
                    </tr>
                <?php endif;?>
                <?php if(count($sample)>0) :?>
                    <?php foreach ($sample as $sample):?>
                        <tr class="warning">
                            <td class="col-md-2">样本</td>
                            <td class="col-md-10">
                                <?= Html::a("$sample->name", ['sample/view', 'id' => $sample->id]) ?>
                        <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
                                <?= Html::a('', ['sample/update', 'id' => $sample->id], ['class' => 'glyphicon glyphicon-pencil','title'=>'修改']) ?>
                                <?= Html::a('', ['sample/del', 'id' => $sample->id], ['class' => 'glyphicon glyphicon-trash','title'=>'删除']) ?>
                        <?php endif;?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>


</div>
