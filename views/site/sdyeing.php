<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $adList array */
use app\widgets\LastNews;
use app\widgets\ConfigPanel;
use yii\widgets\ListView;
use yii\bootstrap\Carousel;
use yii\helpers\Url;
use app\models\Sdyeing;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\modules\backend\models\AdminUser;

$this->title = ArrayHelper::getValue(Yii::$app->params,'homeTitle', 'YiiCms首页');
$carouselItems = [];


?>

<div class="container" style="width: 100%;border: none;background-color: #fff">
    <div class="row clearfix" style="width: 80%;margin: 0 auto;border: none">
        <div class="col-md-12 column">
            <div class="shows" >
                <h3>
                    <?=$model['section_name']?>

                </h3>
                <dl class="show_dl">
                    <dd><span>上传人:</span>
                        <?=AdminUser::getDoName($model->id,1,'sdyeing')?>
                    </dd>
                    <dd>
                        <span>发布时间:</span>
                        <?=$model->add_time?>
                    </dd>
                </dl>
                <h4>
                    实验流程

                </h4>
                <div class="show_p" style="font-family: "微软雅黑", Arial, "Trebuchet MS", Helvetica, Verdana">
                    <?=$model['testflow']?>
                </div>
                    <h4>
                        注意事项

                    </h4>
                    <div class="show_p" style="font-family: "微软雅黑", Arial, "Trebuchet MS", Helvetica, Verdana">
                    <?=$model['attention']?>
                    </div>
                <dl class="show_left">
                    <dd><span>检索号:</span><?=$model->retrieve?></dd>
                    <dd><span>存放位置:</span><?=$model->place?></dd>
                    <dd><span>数字图片文件:</span><img src="<?=$model->img?>"></dd>
                    <dd><span>切片预处理:</span><?=$model->section_preprocessing?></dd>
                    <dd><span>切片厚度:</span><?=$model->section_thickness?></dd>
                    <dd><span>切片类型:</span><?=Sdyeing::$section_type[$model->section_type]?></dd>

                    <?php if(isset($norm)){if($model->ntype==1):?>
                        <dd><span>实验结果类型:</span>常规H&E染色
                        </dd>
                        <dd><span>检测指标名称:</span>
                            <?= Html::a("$norm->name", ['detection/routine', 'id' => $norm->id]) ?>
                        </dd>
                    <?php elseif ($model->ntype==2):?>
                        <dd><span>实验结果类型:</span>特殊染色
                        <dd><span>检测指标名称:</span>
                           <?= Html::a("$norm->name", ['detection/particular', 'id' => $norm->id]) ?>
                    </dd>
                        <?php elseif (in_array($model->ntype,[3,4])):?>
                        <dd><span>检测指标名称:</span>
                            <?= Html::a("$norm->name", ['detection/pna', 'id' => $norm->id]) ?>
                        </dd>
                    <?php endif;}?>
                </dl>

                        <?php if($model->ntype==1):?>
                            <?php if(count($Reagent)>0) :?>
                                <div class="col-md-12 column" style="padding-left: 0;padding-top: 0;margin-bottom: 10px;">
                                    <ul class="list-unstyled list-inline">
                                        <li style="font-family: '微软雅黑';float: left">
                                            使用的试剂:
                                        </li>
                                        <?php foreach ($Reagent as $v=>$Reagent):?>
                                            <li style="font-family: '微软雅黑';float: left">
                                                <?= Html::a("$Reagent[name]", ['detection/reagent','at'=>2, 'id' => $Reagent['id']], ['title'=>'查看']) ?>

                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                            <?php endif;?>
                        <?php elseif ($model->ntype==2):?>
                            <?php if(count($Reagent)>0) :?>
                                <div class="col-md-12 column" style="padding-left: 0;padding-top: 0;margin-bottom: 10px;">
                                    <ul class="list-unstyled list-inline">
                                        <li style="font-family: '微软雅黑';float: left">
                                            使用的自配试剂:
                                        </li>
                                        <?php foreach ($Reagent as $v=>$Reagent):?>
                                            <li style="font-family: '微软雅黑';float: left">
                                                <?= Html::a("$Reagent[name]", ['detection/reagent','at'=>2, 'id' => $Reagent['id']], ['title'=>'查看']) ?>

                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                            <?php endif;?>
                            <?php if(count($kit)>0) :?>
                                <div class="col-md-12 column" style="padding-left: 0;padding-top: 0;margin-bottom: 10px;">
                                    <ul class="list-unstyled list-inline">
                                        <li style="font-family: '微软雅黑';float: left">
                                            使用的商品试剂:
                                        </li>
                                        <?php foreach ($kit as $v=>$kit):?>
                                            <li style="font-family: '微软雅黑';float: left">
                                                <?= Html::a("$kit[name]", ['detection/kit','at'=>2, 'id' => $kit['id']], ['title'=>'查看']) ?>

                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                            <?php endif;?>

                        <?php elseif ($model->ntype==3):?>
                            <?php if(count($kit)>0) :?>
                                <div class="col-md-12 column" style="padding-left: 0;padding-top: 0;margin-bottom: 10px;">
                                    <ul class="list-unstyled list-inline">
                                        <li style="font-family: '微软雅黑';float: left">
                                            使用的抗体:
                                        </li>
                                        <?php foreach ($kit as $v=>$kit):?>
                                            <li style="font-family: '微软雅黑';float: left">
                                                <?= Html::a("$kit[name]", ['detection/kit','at'=>2, 'id' => $kit['id']], ['title'=>'查看']) ?>

                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                            <?php endif;?>

                        <?php elseif ($model->ntype==4):?>
                            <?php if(count($kit)>0) :?>
                                <div class="col-md-12 column" style="padding-left: 0;padding-top: 0;margin-bottom: 10px;">
                                    <ul class="list-unstyled list-inline">
                                        <li style="font-family: '微软雅黑';float: left">
                                            使用的试剂盒:
                                        </li>
                                        <?php foreach ($kit as $v=>$kit):?>
                                            <li style="font-family: '微软雅黑';float: left">
                                                <?= Html::a("$kit[name]", ['sample','at'=>1, 'id' => $kit['id']], ['title'=>'查看']) ?>

                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                            <?php endif;?>

                        <?php endif;?>


            </div>

        </div>


    </div>
</div>