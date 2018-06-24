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
        <div class="col-md-12 column" >
            <div class=" shows" style="padding-top: 5px;padding-bottom: 0;width: 100%">
                <h3>
                    <?=$model['pro_name']?>

                </h3>
                <dl class="show_dl">
                    <dd><span>上传人:</span><?=AdminUser::getUserName($model->pro_user)?></dd>
                    <dd><span>发布时间:</span><?=$model->pro_add_time?></dd>
                </dl>
                <div class="show_p" style="font-family: "微软雅黑", Arial, "Trebuchet MS", Helvetica, Verdana">
                    <?=$model['pro_description']?>                        </p>
                <div>
                <dl class="show_left">
                    <dd><span>检索号:</span><?=$model->pro_retrieve?></dd>

                    <dd><span>项目种属:</span><?=Project::$kind_type[$model->pro_kind_id]?></dd>
                    <dd><span>项目样本总数:</span><?=$model->pro_sample_count?></dd>
                    <dd><span>项目关键词:</span><?=$model->pro_keywords?></dd>
                    <dd><span>项目样本总数:</span><?=$model->pro_sample_count?></dd>
                </dl>
                <?php foreach ($Principal as $Principal):?>
                    <dl class="show_li">
                        <dd><span>项目负责人:</span><?=$Principal->name?></dd>
                        <dd><span>科室:</span><?=$Principal->department?></dd>
                        <dd><span>邮箱:</span><?=$Principal->email?></dd>
                        <dd><span>电话:</span><?=$Principal->telphone?></dd>
                    </dl>


                <?php endforeach;?>


                <?php if(count($child)>0):?>
                    <div class="col-md-12 column" style="padding-left: 0;padding-top: 0;margin-bottom: 30px;">
                        <ul class="list-unstyled list-inline">
                            <li style="font-family: '微软雅黑';float: left">
                                子项目列表:
                            </li>
                            <?php  foreach($child as $child): ?>
                                <li style="font-family: '微软雅黑';float: left">
                                    <?= Html::a("$child[pro_name]", ['show','at'=>1, 'id' => $child['pro_id']], ['title'=>'查看']) ?>

                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif;?>

                <?php if(count($group)>0) :?>
                        <div class="col-md-12 column" style="padding-left: 0;padding-top: 0;margin-bottom: 30px;">
                            <ul class="list-unstyled list-inline">
                                <li style="font-family: '微软雅黑';float: left">
                                    项目分组列表:
                                </li>
                                <?php  foreach($group as $group): ?>
                                    <li style="font-family: '微软雅黑';float: left">
                                        <a class="group<?=$group->id?>" href="group.html?at=1&id=<?=$group->id?>"><?=$group->group_name?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                <?php endif;?>

            </div>

        </div>


    </div>
</div>