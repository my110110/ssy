<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $adList array */
use app\widgets\LastNews;
use app\widgets\ConfigPanel;
use yii\widgets\ListView;
use yii\bootstrap\Carousel;
use yii\helpers\Url;
use app\models\Project;
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
                    <dd><span>上传人:</span><?=AdminUser::getUserName($model->add_user)?></dd>
                    <dd><span>发布时间:</span><?=$model->add_time?></dd>
                </dl>
                <div class="show_p" style="font-family: "微软雅黑", Arial, "Trebuchet MS", Helvetica, Verdana">
                    <?=$model['descript']?>                        </p>
                <div>
                <dl class="show_left">
                    <dd><span>检索号:</span><?=$model->retrieve?></dd>

                </dl>


                <?php if(count($child)>0):?>
                    <div class="col-md-12 column" style="padding-left: 0;padding-top: 0;margin-bottom: 30px;">
                        <ul class="list-unstyled list-inline">
                            <li style="font-family: '微软雅黑';float: left">
                                标本列表:
                            </li>
                            <?php  foreach($child as $child): ?>
                                <li style="font-family: '微软雅黑';float: left">
                                    <?= Html::a("$child[name]", ['stace','at'=>1, 'id' => $child['id']], ['title'=>'查看']) ?>

                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif;?>


            </div>

        </div>


    </div>
</div>