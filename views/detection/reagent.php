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
                    <?=$model['name']?>

                </h3>
                <dl class="show_dl">
                    <dd><span>上传人:</span><?=AdminUser::getDoName($model->id,1,'reagent')?></dd>
                    <dd><span>发布时间:</span><?=$model->add_time?></dd>
                </dl>
                <dl class="show_left">
                    <dd><span>检索号:</span><?=$model->retrieve?></dd>

                </dl>
                <?php if(count($child)>0) :?>


                    <?php foreach ($child as $child):?>
                        <dl class="show_left">
                            <dd><span>公司:</span>
                                <?= $child->company?>
                            </dd>
                            <dd><span>货号:</span><?=$child->number?></dd>
                            <dd><span>配置方法:</span><?=$child->method?></dd>
                            <dd><span>保存条件:</span><?=$child->savetion?></dd>
                            <dd><span>官网地址:</span><?=$child->http?></dd>

                        </dl>



                    <?php endforeach;?>
                <?php endif;?>


            </div>

        </div>


    </div>
</div>