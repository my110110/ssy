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
                    <dd><span>阳性对照:</span><?=$model->positive?></dd>
                    <dd><span>阴性对照:</span><?=$model->negative?></dd>
                    <dd><span>结果判断:</span><?=$model->judge?></dd>
                    <dd><span>注意事项:</span><?=$model->matters?></dd>
                </dl>
                <?php if(count($child)>0) :?>




                        <div class="col-md-12 column" style="padding-left: 0;padding-top: 0;margin-bottom: 5px;">
                            <ul class="list-unstyled list-inline">
                                <li style="font-family: '微软雅黑';float: left">
                                    自配试剂列表:
                                </li>
                                <?php  foreach($child as $child): ?>
                                    <li style="font-family: '微软雅黑';float: left">
                                        <?= Html::a("$child->name", ['reagent','at'=>2, 'id' => $child->id,'type'=>'testmethod'], ['title'=>'查看']) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>




                <?php endif;?>
                <?php if(count($child)>0) :?>




                    <div class="col-md-12 column" style="padding-left: 0;padding-top: 0;margin-bottom: 30px;">
                        <ul class="list-unstyled list-inline">
                            <li style="font-family: '微软雅黑';float: left">
                                商品试剂列表:
                            </li>
                            <?php  foreach($kit as $kit): ?>
                                <li style="font-family: '微软雅黑';float: left">
                                    <?= Html::a("$kit->name", ['kit','at'=>2, 'id' => $kit->id], ['title'=>'查看']) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>




                <?php endif;?>

            </div>

        </div>


    </div>
</div>