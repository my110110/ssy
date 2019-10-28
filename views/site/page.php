<?php

/* @var $this \yii\web\View */
/* @var $page \app\models\Page */
use yii\helpers\Html;
use app\widgets\LastNews;
use app\widgets\ConfigPanel;

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
                        <a ><?=$page->title;?></a>
                    </li>

                </ul>
            </div>
        </div>

    <div class="row clearfix">
        <div class="col-md-12 column">
            <h3 class="text-center">
                <?= Html::encode($page->title) ?>
            </h3>
            <p>
                <?=$page->content?>
            </p>

        </div>
    </div>
    <div style="height: 10px;width: 100%"></div>
</div>

