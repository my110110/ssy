<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\backend\models\AdminUser;
use app\models\Project;
/* @var $this yii\web\View */
/* @var $model app\models\Project */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '特殊染色', 'url' => ['particu lar/index']];

?>
<div class="content-view">


    <p>
        <?= Html::a('返回', ['particular/view', 'id' => $model->pid], [
            'title'=>'返回',
            'class' => 'btn btn-primary',

        ]) ?>
        <?= Html::a('新增自配试剂', ['reagent/create', 'id' => $model->id,'type'=>'testmethod'], [
            'title'=>'添加负责人',
            'class' => 'btn btn-success',

        ]) ?>
        <?= Html::a('新增商品化试剂盒', ['kit/create', 'id' => $model->id,'type'=>'testmethod'], [
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

    </p>
    <div class="row clearfix" style="margin-top: 10px;">
        <div class="col-md-12 column">
            <table class="table table-hover table-bordered">
                <tbody>
                <tr class="info">

                  <td class="col-md-2">检测方法名称</td>
                    <td class="col-md-10"><?=$model->name?></td>
                </tr>
                <tr class="default">

                    <td class="col-md-2">检索号</td>
                    <td class="col-md-10"><?=$model->retrieve?></td>
                </tr>
                <tr class="warning">

                    <td class="col-md-2">阳性对照</td>
                    <td class="col-md-10"><?=$model->positive?></td>
                </tr>
                <tr class="success">
                    <td class="col-md-2">阴性对照</td>
                    <td class="col-md-10"><?=$model->negative?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">结果判断</td>
                    <td class="col-md-10"><?=$model->judge?></td>
                </tr>
                <tr class="success">
                    <td class="col-md-2">注意事项</td>
                    <td class="col-md-10"><?=$model->matters?></td>
                </tr>
                <tr class="default">
                    <td class="col-md-2">添加人</td>
                    <td class="col-md-10"><?=AdminUser::getDoName($model->id,1,'testmethod')?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">添加时间</td>
                    <td class="col-md-10"><?=$model->add_time?></td>
                </tr>
                <?php if(!empty($model->change_user)):?>
                <tr class="warning">
                    <td class="col-md-2">修改人</td>
                    <td class="col-md-10"><?=AdminUser::getDoName($model->id,3,'testmethod')?></td>
                </tr>
                    <tr class="default">
                        <td class="col-md-2">修改时间</td>
                        <td class="col-md-10"><?=$model->change_time?></td>
                    </tr>
                <?php endif;?>

                <?php if(count($child)>0) :?>
                    <?php foreach ($child as $child):?>
                        <tr class="info">
                            <td class="col-md-2">自配试剂</td>
                            <td class="col-md-10">
                                <?= Html::a("$child->name", ['reagent/view', 'id' => $child->id,'type'=>$child->type]) ?>

                                <?= Html::a('', ['reagent/update', 'id' => $child->id,'type'=>$child->type], ['class' => 'glyphicon glyphicon-pencil','title'=>'修改']) ?>
                                <?= Html::a('', ['reagent/del', 'id' => $child->id,'type'=>$child->type], ['class' => 'glyphicon glyphicon-trash','title'=>'删除']) ?>

                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
                <?php if(count($kit)>0) :?>
                    <?php foreach ($kit as $kit):?>
                        <tr class="info">
                            <td class="col-md-2">商品试剂</td>
                            <td class="col-md-10">
                                <?= Html::a("$kit->name", ['kit/view', 'id' => $kit->id]) ?>

                                <?= Html::a('', ['kit/update', 'id' => $kit->id], ['class' => 'glyphicon glyphicon-pencil','title'=>'修改']) ?>
                                <?= Html::a('', ['kit/del', 'id' => $kit->id], ['class' => 'glyphicon glyphicon-trash','title'=>'删除']) ?>

                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>


</div>