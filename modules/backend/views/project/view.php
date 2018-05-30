<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\backend\models\AdminUser;
use app\models\Project;
/* @var $this yii\web\View */
/* @var $model app\models\Project */
$this->title = $model->pro_name;
$this->params['breadcrumbs'][] = ['label' => '项目管理', 'url' => ['index']];

?>
<div class="content-view">


    <p>
        <?= Html::a('添加子项目', ['create', 'pro_pid' => $model->pro_id], [
            'title'=>'添加子项目',
            'class' => 'btn btn-primary',

        ]) ?>
        <?= Html::a('添加负责人', ['principal/create', 'pro_id' => $model->pro_id], [
            'title'=>'添加负责人',
            'class' => 'btn btn-success',

        ]) ?>
        <?= Html::a('修改', ['update', 'pro_id' => $model->pro_id], ['class' => 'btn btn-warning','title'=>'修改']) ?>
        <?= Html::a('删除', ['delete', 'pro_id' => $model->pro_id], [
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

                  <td class="col-md-2">项目名称</td>
                    <td class="col-md-10"><?=$model->pro_name?></td>
                </tr>
                <tr class="default">

                    <td class="col-md-2">项目检索号</td>
                    <td class="col-md-10"><?=$model->pro_retrieve?></td>
                </tr>
                <tr class="warning">

                    <td class="col-md-2">项目种属</td>
                    <td class="col-md-10"><?=Project::$kind_type[$model->pro_kind_id]?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">项目关键词</td>
                    <td class="col-md-10"><?=$model->pro_keywords?></td>
                </tr>
                <tr class="success">
                    <td class="col-md-2">项目样品数</td>
                    <td class="col-md-10"><?=$model->pro_sample_count?></td>
                </tr>
                <tr class="default">
                    <td class="col-md-2">项目添加人</td>
                    <td class="col-md-10"><?=AdminUser::getUserName($model->pro_user)?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">项目添加时间</td>
                    <td class="col-md-10"><?=$model->pro_add_time?></td>
                </tr>
                <?php if(!empty($model->pro_change_user)):?>
                <tr class="warning">
                    <td class="col-md-2">项目修改人</td>
                    <td class="col-md-10"><?=AdminUser::getUserName($model->pro_change_user)?></td>
                </tr>
                    <tr class="default">
                        <td class="col-md-2">项目修改时间</td>
                        <td class="col-md-10"><?=$model->pro_update_time?></td>
                    </tr>
                <?php endif;?>
                </tbody>
            </table>

</div>
