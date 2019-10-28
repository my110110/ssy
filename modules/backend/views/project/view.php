<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\backend\models\AdminUser;
use app\models\Project;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
$this->title = $model->pro_name;
$this->params['breadcrumbs'][] = ['label' => '项目管理', 'url' => ['index']];
if($model->pro_pid>0){
    $str = '子';
}else{
    $str = '';
}


?>
<div class="content-view">


    <div class="clearfix">
        <div class="pull-left">
            <?php if($model->pro_pid>0):?>
                <?= Html::a('返回主项目', ['view', 'id' => $model->pro_pid], [
                    'title'=>'返回主项目',
                    'class' => 'btn btn-primary',

                ]) ?>
            <?php endif;?>
            <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
            <?php if(!$model->pro_pid>0):?>
            <?= Html::a('添加子项目', ['create', 'pro_pid' => $model->pro_id], [
                'title'=>'添加子项目',
                'class' => 'btn btn-primary',

            ]) ?>
            <?php endif;?>
            <?= Html::a('添加负责人', ['principal/create', 'id' => $model->pro_id], [
                'title'=>'添加负责人',
                'class' => 'btn btn-success',

            ]) ?>
            <?php if(!count($child)>0):?>
            <?= Html::a('添加实验分组', ['group/create', 'id' => $model->pro_id], [
                'title'=>'添加实验分组',
                'class' => 'btn btn-info',

            ]) ?>
            <?php endif;?>
            <?= Html::a('修改', ['update', 'id' => $model->pro_id], ['class' => 'btn btn-warning','title'=>'修改']) ?>
            <?= Html::a('删除', ['delete', 'id' => $model->pro_id], [
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
                <?php if($model->pro_pid==0):?>

                    <div class="tab-content cos" >
                        <div class="row clearfix">
                            <?php $form = ActiveForm::begin([
                                'action' => ['uploadfile','pid'=>$model->pro_id],
                                'method' => 'post',
                                'options' => ['enctype' => 'multipart/form-data']
                            ]); ?>

                            <?= $form->field($file, 'file',
                                ['options'=>
                                    ['tag'=>false ],
                                    'template' => '<div class="  ace-file-input"> 
                                         {input}</div>',

                                ])->fileInput() ?>
                            <?= Html::submitButton('导入子项目', ['class' => 'btn btn-primary uploadfile']) ?>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                <?php else:?>
                    <div class="tab-content cos">
                        <div class="row clearfix">
                            <?php $form = ActiveForm::begin([
                                'action' => ['group/uploadfile','pid'=>$model->pro_id],
                                'method' => 'post',
                                'options' => ['enctype' => 'multipart/form-data']
                            ]); ?>

                            <?= $form->field($file, 'file',
                                ['options'=>
                                    ['tag'=>false ],
                                    'template' => '<div class=" col-md-2 column ace-file-input"> 
                                         {input}</div>',

                                ])->fileInput() ?>
                            <?= Html::submitButton('导入分组', ['class' => 'btn btn-primary uploadfile']) ?>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                 <?php endif;?>
        </div>
                <?php endif;?>

    </div>
  
    <div class="row clearfix" style="margin-top: 10px;">
        <div class="col-md-12 column">
            <table class="table table-hover table-bordered">
                <tbody>
                <tr class="info">

                  <td class="col-md-2"><?=$str?>项目名称</td>
                    <td class="col-md-10"><?=$model->pro_name?></td>
                </tr>
                <tr class="default">

                    <td class="col-md-2"><?=$str?>项目检索号</td>
                    <td class="col-md-10"><?=$model->pro_retrieve?></td>
                </tr>
                <tr class="warning">

                    <td class="col-md-2"><?=$str?>项目种属</td>
                    <td class="col-md-10"><?=Project::$kind_type[$model->pro_kind_id]?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2"><?=$str?>项目关键词</td>
                    <td class="col-md-10"><?=$model->pro_keywords?></td>
                </tr>
                <tr class="success">
                    <td class="col-md-2"><?=$str?>项目样品数</td>
                    <td class="col-md-10"><?=$model->pro_sample_count?></td>
                </tr>
                <tr class="active">
                    <td class="col-md-2"><?=$str?>项目描述</td>
                    <td class="col-md-10"><?=$model->pro_description?></td>
                </tr>
                <tr class="default">
                    <td class="col-md-2"><?=$str?>项目添加人</td>
                    <td class="col-md-10"><?=AdminUser::getUserName($model->pro_user)?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2"><?=$str?>项目添加时间</td>
                    <td class="col-md-10"><?=$model->pro_add_time?></td>
                </tr>
                <?php if(!empty($model->pro_change_user)):?>
                <tr class="warning">
                    <td class="col-md-2"><?=$str?>项目修改人</td>
                    <td class="col-md-10"><?=AdminUser::getUserName($model->pro_change_user)?></td>
                </tr>
                    <tr class="default">
                        <td class="col-md-2"><?=$str?>项目修改时间</td>
                        <td class="col-md-10"><?=$model->pro_update_time?></td>
                    </tr>
                <?php endif;?>

                <?php if(count($child)>0) :?>
                    <table class="table table-hover table-bordered">
                        <tr class="-address-book">
                            <th>子项目名称</th>
                            <th>子项目检索号</th>
                            <th>操作</th>
                        </tr>
                        <?php foreach ($child as $child):?>
                            <tr class="default">
                                <td class="col-md-3">  <?= Html::a("$child->pro_name", ['view', 'id' => $child->pro_id]) ?></td>
                                <td class="col-md-3">  <?= Html::a("$child->pro_retrieve", ['view', 'id' => $child->pro_id]) ?></td>
                                <td class="col-md-4">

                                    <?= Html::a('<button type="button" class="btn btn-primary btn-xs">下载子项目</button>', ['project/export', 'id' =>  $child['pro_id']], ['title'=>'下载']) ?>
                                    <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
                                        <?= Html::a('<button type="button" class="btn btn-warning btn-xs">修改</button>', ['principal/update', 'id' => $child->pro_id]) ?>
                                        <?= Html::a('<button type="button" class="btn btn-danger btn-xs">删除</button>', ['project/del', 'id' => $child->pro_id], ['title'=>'删除']) ?>
                                    <?php endif;?>
                                </td>
                            </tr>
                        <?php endforeach;?>

                    </table>
                <?php endif;?>

            <?php if(count($Principal)>0) :?>
                <table class="table table-hover table-bordered">
                    <tr class="-address-book">
                        <th>项目负责人</th>
                        <th>科室</th>
                        <th>邮箱</th>
                        <th>电话</th>
                        <th>操作</th>
                    </tr>
                    <?php foreach ($Principal as $Principal):?>
                        <tr class="info">
                            <td class="col-md-2"><?=$Principal->name?></td>
                            <td class="col-md-2"><?=$Principal->department?></td>
                            <td class="col-md-2"><?=$Principal->email?></td>
                            <td class="col-md-2"><?=$Principal->telphone?></td>
                            <td class="col-md-2">
                                <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
                                    <?= Html::a('<button type="button" class="btn btn-warning btn-xs">修改</button>', ['principal/update', 'id' => $Principal->id]) ?>
                                    <?= Html::a('<button type="button" class="btn btn-danger btn-xs">删除</button>', ['principal/delete', 'id' => $Principal->id], ['title'=>'删除', 'data' => [
                                        'confirm' => '确定要删除这个项目负责人吗?',
                                        'method' => 'post',
                                    ],]) ?>
                                <?php endif;?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            <?php endif;?>
            <?php if(count($group)>0) :?>
                  <table class="table table-hover table-bordered">
                      <tr class="-address-book">
                          <th>分组名称</th>
                          <th>分组检索号</th>
                          <th>操作</th>
                      </tr>
                          <?php foreach ($group as $group):?>
                              <tr class="default">
                                  <td class="col-md-3"><?= Html::a("$group->group_name", ['group/view', 'id' => $group->id]) ?></td>
                                  <td class="col-md-3"><?= Html::a("$group->group_retrieve", ['group/view', 'id' => $group->id]) ?></td>
                                  <td class="col-md-4">
                                      <?= Html::a('<button type="button" class="btn btn-primary btn-xs">导出样本</button>', ['sample/exports', 'id' =>  $group->id], ['title'=>'导出所有样本']) ?>
                                      <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
                                          <?= Html::a('<button type="button" class="btn btn-warning btn-xs">修改</button>', ['group/update', 'id' => $group->id]) ?>
                                          <?= Html::a('<button type="button" class="btn btn-danger btn-xs">删除</button>', ['group/del', 'id' => $group->id], ['title'=>'删除']) ?>
                                      <?php endif;?>
                                  </td>
                              </tr>
                          <?php endforeach;?>
                  </table>
            <?php endif;?>
</div>
