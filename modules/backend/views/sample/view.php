<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\backend\models\AdminUser;
use app\models\Project;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '项目管理', 'url' => ['project/index']];

?>
<div class="content-view">



    <div class="clearfix">
        <div class="pull-left">
        <?php if($ret==1):?>
            <?= Html::a('返回列表', ['sample/index'], [
                'title'=>'返回列表',
                'class' => 'btn btn-primary',

            ]) ?>
            <?php else:?>
        <?= Html::a('返回分组', ['group/view', 'id' => $model->gid], [
            'title'=>'返回项目',
            'class' => 'btn btn-primary',

        ]) ?>

        <?php endif;?>
        <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
        <?= Html::a('新增实验样本的特定组织与细胞标本', ['stace/create', 'id' => $model->id], ['class' => 'btn btn-info ','title'=>'修改']) ?>

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
        </div>
    <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
        <div class="pull-right">
            <div class="tab-content cos">
                <div class="row clearfix">
                    <?php $form = ActiveForm::begin([
                        'action' => ['stace/uploadfile','pid'=>$model->id],
                        'method' => 'post',
                        'options' => ['enctype' => 'multipart/form-data']
                    ]); ?>

                    <?= $form->field($file, 'file',
                        ['options'=>
                            ['tag'=>false ],
                            'template' => '<div class=" col-md-2 column ace-file-input"> 
                                     {input}</div>',

                        ])->fileInput() ?>
                    <?= Html::submitButton('导入标本', ['class' => 'btn btn-primary uploadfile']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
             </div>
        </div>
    <?php endif;?>
    </div>
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



                <tr class="info">
                    <td class="col-md-2">样品描述</td>
                    <td class="col-md-10"><?=$model->descript?></td>
                </tr>
                <tr class="default">
                    <td class="col-md-2">添加人</td>
                    <td class="col-md-10"><?=AdminUser::getUserName($model->add_user)?></td>
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
                        <td class="col-md-10"><?=$model->change_time;?></td>
                    </tr>
                <?php endif;?>

                </tbody>
            </table>

            <?php if(count($stace)>0) :?>
            <table class="table table-bordered">
                <tr>
                     <th>特定组织与细胞标本名称</th>
                     <th>检索号</th>
                     <th>操作</th>
                 </tr>
                <?php foreach ($stace as $stace):?>

                    <tr class="default">
                        <td class="col-md-3"><?= Html::a($stace->name, ['stace/view', 'id' => $stace->id]) ?></td>
                        <td class="col-md-3"><?= Html::a($stace->retrieve, ['stace/view', 'id' => $stace->id]) ?></td>
                        <td class="col-md-4">
                            <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
                                <?= Html::a('<button type="button" class="btn btn-warning btn-xs">修改</button>', ['stace/update', 'id' => $stace->id]) ?>
                                <?= Html::a('<button type="button" class="btn btn-danger btn-xs">删除</button>', ['stace/del', 'id' => $stace->id], ['title'=>'删除']) ?>
                            <?php endif;?>
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php endif;?>
            </table>

</div>
