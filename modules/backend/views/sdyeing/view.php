<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\backend\models\AdminUser;
use app\models\Sdyeing;
/* @var $this yii\web\View */
/* @var $model app\models\Sdyeing */
$this->title = $model->section_name;
$this->params['breadcrumbs'][] = ['label' => '返回', 'url' => ['stace/view', 'id' => $model->yid]];

?>
<div class="content-view">


    <div class="row clearfix" style="margin-top: 10px;">
        <div class="col-md-12 column">
            <table class="table table-hover table-bordered">
                <tbody>
                <tr class="info">

                  <td class="col-md-2">切片名称</td>
                    <td class="col-md-10"><?=$model->section_name?></td>
                </tr>
                <tr class="default">

                    <td class="col-md-2">检索号</td>
                    <td class="col-md-10"><?=$model->retrieve?></td>
                </tr>
                <tr class="success">
                    <td class="col-md-2">检测指标名称</td>
                    <td class="col-md-10">

                        <?php if(isset($norm)){if($model->ntype==1):?>
                            <?= Html::a("$norm->name", ['routine/view', 'id' => $norm->id]) ?>
                        <?php elseif ($model->ntype==2):?>
                             <?= Html::a("$norm->name", ['particular/view', 'id' => $norm->id]) ?>
                        <?php elseif (in_array($model->ntype,[3,4])):?>
                            <?= Html::a("$norm->name", ['particular/view', 'id' => $norm->id,'type'=>$norm->type]) ?>
                        <?php endif;}?>
                    </td>
                </tr>
                <tr class="default">
                    <td class="col-md-2">检测指标检索号</td>
                    <td class="col-md-10"><?php if(isset($norm)):?><?=$norm->retrieve?><?php endif;?></td>
                </tr>
                <?php if($model->ntype==1):?>
                    <?php if(count($Reagent)>0) :?>
                        <?php foreach ($Reagent as $v=>$Reagent):?>
                            <tr class="<?php if($v%2==0){echo 'info';}else{echo 'default';}?>">
                                <td class="col-md-2">使用的自配试剂</td>
                                <td class="col-md-10">
                                    <?= Html::a("$Reagent->name", ['reagent/view', 'id' => $Reagent->id]) ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                <?php elseif ($model->ntype==2):?>
                    <?php if(count($Reagent)>0) :?>
                        <?php foreach ($Reagent as $v=>$Reagent):?>
                            <tr class="<?php if($v%2==0){echo 'info';}else{echo 'default';}?>">
                                <td class="col-md-2">使用的自配试剂</td>
                                <td class="col-md-10">
                                    <?= Html::a("$Reagent->name", ['reagent/view', 'id' => $Reagent->id,'type'=>'testmethod']) ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                    <?php if(count($kit)>0) :?>
                        <?php foreach ($kit as $v=>$kit):?>
                            <tr class="<?php if($v%2==0){echo 'success';}else{echo 'warning';}?>">
                                <td class="col-md-2">使用的商品试剂</td>
                                <td class="col-md-10">
                                    <?= Html::a("$kit->name", ['kit/view', 'id' => $kit->id,'type'=>'testmethod']) ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                    <tr class="default">
                        <td class="col-md-2">注意事项</td>
                        <td class="col-md-10"><?=$model->attention?></td>
                    </tr>
                <?php elseif ($model->ntype==3):?>
                    <?php if(count($kit)>0) :?>
                        <?php foreach ($kit as $v=>$kit):?>
                            <tr class="<?php if($v%2==0){echo 'success';}else{echo 'warning';}?>">
                                <td class="col-md-2">使用的抗体</td>
                                <td class="col-md-10">
                                    <?= Html::a("$kit->name", ['kit/view', 'id' => $kit->id,'type'=>'pna']) ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                    <tr class="default">
                        <td class="col-md-2">注意事项</td>
                        <td class="col-md-10"><?=$model->attention?></td>
                    </tr>
                <?php elseif ($model->ntype==4):?>
                    <?php if(count($kit)>0) :?>
                        <?php foreach ($kit as $v=>$kit):?>
                            <tr class="<?php if($v%2==0){echo 'success';}else{echo 'warning';}?>">
                                <td class="col-md-2">使用的核酸试剂盒</td>
                                <td class="col-md-10">
                                    <?= Html::a("$kit->name", ['kit/view', 'id' => $kit->id,'type'=>'pna']) ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                    <tr class="default">
                        <td class="col-md-2">注意事项</td>
                        <td class="col-md-10"><?=$model->attention?></td>
                    </tr>
                <?php endif;?>
                <tr class="success">
                    <td class="col-md-2">切片类型</td>
                    <td class="col-md-10"><?=Sdyeing::$section_type[$model->section_type]?></td>
                </tr>
                <tr class="success">
                    <td class="col-md-2">切片厚度</td>
                    <td class="col-md-10"><?=$model->section_thickness?></td>
                </tr>

                <tr class="info">

                    <td class="col-md-2">切片预处理</td>
                    <td class="col-md-10"><?=$model->section_preprocessing?></td>
                </tr>
                <tr class="success">

                    <td class="col-md-2">数字图片文件</td>
                    <td class="col-md-10"><img src="<?=$model->img?>"></td>
                </tr>
                <tr class="dafault">

                    <td class="col-md-2">实验流程</td>
                    <td class="col-md-10"><?=$model->testflow?></td>
                </tr>

                <tr class="info">

                    <td class="col-md-2">存放位置</td>
                    <td class="col-md-10"><?=$model->place?></td>
                </tr>



                <tr class="default">
                    <td class="col-md-2">添加人</td>
                    <td class="col-md-10"><?=AdminUser::getDoName($model->id,1,'sdyeing')?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">添加时间</td>
                    <td class="col-md-10"><?=$model->add_time?></td>
                </tr>
                <?php if(!empty($model->change_user)):?>
                <tr class="warning">
                    <td class="col-md-2">修改人</td>
                    <td class="col-md-10"><?=AdminUser::getDoName($model->id,3,'sdyeing')?></td>
                </tr>
                    <tr class="default">
                        <td class="col-md-2">修改时间</td>
                        <td class="col-md-10"><?=$model->change_time?></td>
                    </tr>
                <?php endif;?>



                </tbody>
            </table>


</div>
