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
    <div class="shows" style="width: 80%;margin: 0 auto;border: none">

        <?php if(empty($model)):?>

        <?php elseif(isset($_GET['Project'])&&!empty(array_filter($_GET['Project']))):?>
            <?php foreach($model as $sarch): ?>
                <div class="col-md-12 column">
                    <div class="jumbotron" style="padding:0 ;padding-top: 5px;padding-bottom: 0;">
                        <h3>
                            <?=$sarch['pro_name']?>
                        </h3>
                        <p style="font-size: 14px;font-family: '微软雅黑'">
                            <?=$sarch['pro_description']?>                        </p>
                        <p>
                            <?= Html::a('查看详情', ['show', 'id' => $sarch['pro_id'],'at'=>1], ['class' => 'btn btn-primary btn-large','title'=>'查看']) ?>
                            <?= Html::a('下载项目', ['export', 'id' => $sarch['pro_id'],'at'=>1], ['class' => 'btn btn-primary btn-large','title'=>'查看']) ?>

                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else:?>
            <?php foreach($model as $pid): ?>

                <div class="col-md-12 column">
                    <div class="shows" style="padding-top: 5px;padding-bottom: 0;">
                        <h3 style="text-align: center">
                            <?=$pid['pro_name']?>
                        </h3>
                        <p style="font-size: 14px;font-family: '微软雅黑'">
                            <?=$pid['pro_description']?>                        </p>
                        <p>
                            <?php if(isset($pid['child'])):?>
                        <div class="col-md-12 column">
                            <ul class="list-unstyled list-inline">
                                <li style="font-family: '微软雅黑'">
                                    子项目列表:
                                </li>
                                 <?php  foreach($pid['child'] as $child): ?>
                                <li>
                                    <?= Html::a("$child[pro_name]", ['show','at'=>1, 'id' => $child['pro_id']], ['title'=>'查看']) ?>

                                </li>
                                    <?php endforeach; ?>
                            </ul>
                        </div>
                            <?php endif;  ?>
                        <?= Html::a('查看详情', ['show', 'id' => $pid['pro_id'],'at'=>1], ['class' => 'btn btn-primary btn-large','title'=>'查看']) ?>
                        <?= Html::a('下载项目', ['export', 'id' => $pid['pro_id'],'at'=>1], ['class' => 'btn btn-success btn-large','title'=>'查看']) ?>

                        </p>
                    </div>
                </div>

              <?php endforeach;?>
        <?php endif;?>


    </div>
</div>