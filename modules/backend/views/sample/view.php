<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\backend\models\AdminUser;
use app\models\Project;
/* @var $this yii\web\View */
/* @var $model app\models\Project */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '项目管理', 'url' => ['index']];

?>
<div class="content-view">


    <p>
        <?= Html::a('返回分组', ['group/view', 'id' => $model->gid], [
            'title'=>'返回项目',
            'class' => 'btn btn-primary',

        ]) ?>
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

    </p>
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
                <?php if(count($stace)>0) :?>
                    <?php foreach ($stace as $stace):?>

                        <tr class="warning">
                            <td class="col-md-2">样本的特定组织与细胞标本</td>
                            <td class="col-md-10">
                                <?= Html::a($stace->name, ['stace/view', 'id' => $stace->id]) ?>

                                <?= Html::a('', ['stace/update', 'id' => $stace->id], ['class' => 'glyphicon glyphicon-pencil','title'=>'修改']) ?>
                                <?= Html::a('', ['stace/del', 'id' => $stace->id], ['class' => 'glyphicon glyphicon-trash','title'=>'删除']) ?>

                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>


</div>
