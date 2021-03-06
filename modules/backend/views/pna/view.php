<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\backend\models\AdminUser;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Project */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '返回列表', 'url' => ['index', 'type' => $model->type]];

?>
<div class="content-view">
    <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
    <div class="clearfix">
                <div class="pull-left">

                 <?php if($model->type==1):?>
                <?= Html::a('添加抗体', ['kit/create', 'id' => $model->id,'type'=>'pna','typeid'=>1], [
                    'title'=>'添加抗体',
                    'class' => 'btn btn-success',

                ]) ?>
           <?php elseif ($model->type==2):?>
                 <?= Html::a('添加检测试剂盒', ['kit/create', 'id' => $model->id,'type'=>'pna','typeid'=>2], [
                     'title'=>'添加检测试剂盒',
                     'class' => 'btn btn-success',

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

                </div>
    <?php
    if($model->type==1)
    {
        $str='导入抗体';
    }
    elseif($model->type==2)
    {
        $str='导入核酸试剂盒';
    }
    ?>
        <div class="pull-right">
    <div class="tab-content cos">
        <div class="row clearfix">
            <?php $form = ActiveForm::begin([
                'action' => [
                    'kit/uploadfile',
                    'type'=>'pna',
                    'typeid'=>$model->type,
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
            <?= Html::submitButton($str, ['class' => 'btn btn-primary uploadfile']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
    </div>
    <?php endif;?>
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
                <tr class="warning">

                    <td class="col-md-2">官方符号</td>
                    <td class="col-md-10"><?=$model->OfficialSymbol?></td>
                </tr>
                <tr class="info">

                    <td class="col-md-2">官方名称</td>
                    <td class="col-md-10"><?=$model->OfficialFullName?></td>
                </tr>
                <tr class="dafault">

                    <td class="col-md-2">基因ID</td>
                    <td class="col-md-10"><?=$model->GeneID?></td>
                </tr>
                <tr class="warning">

                    <td class="col-md-2">功能</td>
                    <td class="col-md-10"><?=$model->function?></td>
                </tr>
                <tr class="info">

                    <td class="col-md-2">NCBI基因数据库网址</td>
                    <td class="col-md-10"><?=$model->NCBIgd?></td>
                </tr>
                <tr class="default">

                    <td class="col-md-2">GeneGards网址</td>
                    <td class="col-md-10"><?=$model->GeneGards?></td>
                </tr>
                <tr class="success">

                    <td class="col-md-2">阳性结果判定标准</td>
                    <td class="col-md-10"><?=$model->standard?></td>
                </tr>
                <tr class="warning">

                    <td class="col-md-2">阳性对照组织/细胞</td>
                    <td class="col-md-10"><?=$model->cells?></td>
                </tr>

                <tr class="default">
                    <td class="col-md-2">添加人</td>
                    <td class="col-md-10"><?=AdminUser::getDoName($model->id,1,'pna')?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">添加时间</td>
                    <td class="col-md-10"><?=$model->add_time?></td>
                </tr>
                <?php if(!empty($model->change_user)):?>
                <tr class="warning">
                    <td class="col-md-2">修改人</td>
                    <td class="col-md-10"><?=AdminUser::getDoName($model->id,3,'pna')?></td>
                </tr>
                    <tr class="default">
                        <td class="col-md-2">修改时间</td>
                        <td class="col-md-10"><?=$model->change_time?></td>
                    </tr>
                <?php endif;?>

                <?php if(count($child)>0) :?>
                    <?php foreach ($child as $child):?>
                        <tr class="info">
                            <td class="col-md-2"><?php if($model->type==1){echo '抗体';}elseif($model->type==2){echo '核酸试剂盒';}?></td>
                            <td class="col-md-10">
                                <?= Html::a("$child->name", ['kit/view', 'id' => $child->id]) ?>
                                <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>

                                <?= Html::a('<button type="button" class="btn btn-warning btn-xs">修改</button>', ['kit/update', 'id' => $child->id], ['title'=>'修改']) ?>
                                <?= Html::a('<button type="button" class="btn btn-danger btn-xs">删除</button>', ['kit/del', 'id' => $child->id], ['title'=>'删除']) ?>
                                <?php endif;?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>

                </tbody>
            </table>

</div>
