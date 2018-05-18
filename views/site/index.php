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

$this->title = ArrayHelper::getValue(Yii::$app->params,'homeTitle', 'YiiCms首页');
$carouselItems = [];
?>
<div style="height: 10px;width: 100%"></div>
<div class="container">
    <div class="row clearfix">
        <div class="col-md-12 column">

            <h3 class="text-left">
                成功案例
            </h3>
            <div class="row">


                <?php if (!empty($products)):foreach ($products as $model): ?>
                <div class="col-md-4">
                    <div class="thumbnail">
                        <img alt="<?= $model->title ?>" src="<?=$model->image ?>" >
                        <div class="caption">
                            <h3>
                                <a href="<?= Url::to(['/products/item', 'id' => $model->id]) ?>"
                                   title="<?= $model->title ?>">
                                    <?= StringHelper::truncateUtf8String($model->title, 13, false) ?>
                                </a>
                            </h3>
                            <p>
                                <?= $model->description ?>                            </p>

                        </div>
                    </div>
                </div>
                <?php endforeach;endif; ?>
            </div>

            <ol class="list-inline">
                <li>
                    友情链接：
                </li>
                <?=\app\widgets\Blogroll::widget()?>
            </ol>
        </div>
    </div>
</div>