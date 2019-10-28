<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2016/12/7
 * Time: 10:55
 * Email:liyongsheng@meicai.cn
 */

/* @var $this yii\web\View */
/* @var $model \app\models\News */
use yii\bootstrap\Html;
use app\widgets\LastNews;
use app\widgets\ConfigPanel;

$this->title = $model->title;

?>

    <div class="container">
        <div style="height: 10px;width: 100%"></div>
        <div class="row clearfix">
            <div class="col-md-12 column">
                <ul class="breadcrumb">
                    <li>
                        <a href="/">首页</a>
                    </li>
                    <li>
                        <a href="/news/list.html">新闻</a>
                    </li>
                    <li>
                        <a ><?=$this->title;?></a>
                    </li>

                </ul>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-md-12 column">
                <div class="page-header text-center">
                    <h3><?=$model->title?></h3>
                    <small><?=date('Y-m-d H:i:s',$model->updated_at)?> <span class="glyphicon glyphicon-eye-open"><?=$model->hits?></span></small>
                </div>
                <p>
                    <?=$model->detail->detail?>
                </p>

            </div>
            <div class="panel-body">
                <div class="row">


                        <?php if($previous = $model->previous()):?>
                    <div class="col-lg-12">
                            上一条 <?=Html::a($previous->title, ['/news/item', 'id'=>$previous->id])?>
                    </div>
                        <?php endif;?>
                        <?php if($next = $model->next()):?>
                        <div class="col-lg-12">
                            下一条 <?=Html::a($next->title, ['/news/item', 'id'=>$next->id])?>
                        </div>
                        <?php endif;?>

                </div>
            </div>
        </div>
        <div style="height: 10px;width: 100%"></div>
    </div>


<?php $this->renderDynamic('\app\models\Content::hitCounters('.$model->id.');')?>