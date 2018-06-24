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
            <div class=" shows" style="padding-top: 5px;padding-bottom: 0;width: 100%">
                <h3>
                    <?=$model['name']?>

                </h3>
                <dl class="show_dl">
                    <dd><span>上传人:</span>
                        <?=AdminUser::getDoName($model->id,1,'routine')?>

                    </dd>
                    <dd><span>发布时间:</span><?=$model->add_time?></dd>
                </dl>

                <dl class="show_left">
                    <dd><span>检索号:</span><?=$model->retrieve?></dd>

                    <dd><span>Official Symbol:</span><?=$model->OfficialSymbol?></dd>
                    <dd><span>Official Full Name:</span><?=$model->OfficialFullName?></dd>
                    <dd><span>Gene ID:</span><?=$model->GeneID?></dd>
                    <dd><span>基因/核酸功能:</span><?=$model->function?></dd>
                    <dd><span>NCBI Gene Database:</span><?=$model->NCBIgd?></dd>
                    <dd><span>GeneGards网址:</span><?=$model->GeneGards?></dd>
                    <dd><span>阳性结果判定标准:</span><?=$model->standard?></dd>
                    <dd><span>阳性对照组织/细胞:</span><?=$model->cells?></dd>


                </dl>



                <?php if(count($child)>0):?>
                    <div class="col-md-12 column" style="padding-left: 0;padding-top: 0;margin-bottom: 30px;">
                        <ul class="list-unstyled list-inline">
                            <li style="font-family: '微软雅黑';float: left">
                                <?php if($model->type==1):?>
                                    抗体列表
                                <?php else:?>
                                    核酸试剂盒列表
                                <?php endif;?>
                            </li>
                            <?php  foreach($child as $child): ?>
                                <li style="font-family: '微软雅黑';float: left">
                                    <?= Html::a("$child[name]", ['kit','at'=>2, 'id' => $child['id']], ['title'=>'查看']) ?>

                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif;?>



            </div>

        </div>


    </div>
</div>