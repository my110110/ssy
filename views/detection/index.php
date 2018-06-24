<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $adList array */
use app\widgets\LastNews;
use app\widgets\ConfigPanel;
use yii\widgets\ListView;
use yii\bootstrap\Carousel;
use yii\helpers\Url;
use app\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = ArrayHelper::getValue(Yii::$app->params,'homeTitle', 'YiiCms首页');
$carouselItems = [];
?>
<div class="container" style="width: 100%;border: none;background-color: #fff">
    <div class="row clearfix" style="width: 80%;margin: 0 auto;border: none">

        <?php if(count($routine)>0):?>
            <div class="row clearfix" style="padding-left: 30px">
                <h4 style="text-indent: 12px;">常规H&E染色指标</h4>
                <div class="col-md-12 column">
                    <ol class="list-unstyled">
                        <?php foreach($routine as $routine): ?>
                            <li>
                                <?= Html::a("$routine[name]", ['routine','at'=>2, 'id' => $routine['id']], ['title'=>'查看']) ?>
                                <span style="float: right"><?=$routine->add_time?></span>

                            </li>
                        <?php endforeach;?>
                        </ol>
                </div>
            </div>


        <?php endif;?>
        <?php if(count($Particular)>0):?>
            <div class="row clearfix" style="padding-left: 30px">
                <h4 style="text-indent: 12px;">特殊染色指标</h4>
                <div class="col-md-12 column">
                    <ol class="list-unstyled">
                        <?php foreach($Particular as $Particular): ?>
                            <li>
                                <?= Html::a("$Particular[name]", ['particular','at'=>2, 'id' => $Particular['id']], ['title'=>'查看']) ?>
                           <span style="float: right"><?=$Particular->add_time?></span>

                            </li>
                        <?php endforeach;?>
                    </ol>
                </div>
            </div>


        <?php endif;?>

        <?php if(count($pna)>0):?>
            <div class="row clearfix" style="padding-left: 30px">
                <h4 style="text-indent: 12px;">蛋白核酸指标</h4>
                <div class="col-md-12 column">
                    <ol class="list-unstyled">
                        <?php foreach($pna as $pna): ?>
                            <li>
                                <?= Html::a("$pna[name]", ['pna','at'=>2, 'id' => $pna['id']], ['title'=>'查看']) ?>
                                <span style="float: right"><?=$pna->add_time?></span>

                            </li>
                        <?php endforeach;?>
                    </ol>
                </div>
            </div>


        <?php endif;?>
    </div>
</div>