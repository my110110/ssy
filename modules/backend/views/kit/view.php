<?php

use yii\helpers\Html;
use app\modules\backend\models\AdminUser;


/* @var $this yii\web\View */
/* @var $model app\models\Project */
$this->title = $model->name;

?>
<div class="content-view">


    <p>
        <?php if($ret==1):?>
        <?= Html::a('返回列表',["$model->type/show",'type'=>$model->typeid], [
                'title'=>'返回上级',
                'class' => 'btn btn-primary',

        ]) ?>

        <?php else:?>
        <?= Html::a('返回上级',["$model->type/view",'id'=>$model->rid], [
            'title'=>'返回上级',
            'class' => 'btn btn-primary',

        ]) ?>
        <?php endif;?>
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
                    <td class="col-md-2">公司名称</td>
                    <td class="col-md-10"><?=$model->company?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">官网地址</td>
                    <td class="col-md-10"><?=$model->http?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">查看说明</td>
                    <td class="col-md-10">

                        <?= Html::a($model->pdf, '/'.$model->pdf, [
                            'title'=>'试剂盒说明书',
                            'target'=>'_black'
                        ]) ?>
                    </td>
                </tr>

                <tr class="default">
                    <td class="col-md-2">添加人</td>
                    <td class="col-md-10"><?=AdminUser::getDoName($model->id,1,'kit')?></td>
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

                </tbody>
            </table>


</div>
