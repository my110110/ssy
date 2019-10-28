<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;


AppAsset::register($this);
$carouselItems = [];

$brandLabel = Yii::$app->name;
if(!empty(Yii::$app->params['logo'])){
    $brandLabel = '<img src="'.Yii::getAlias(Yii::$app->params['logo']).'"/>';
}


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) . '-' . Yii::$app->name ?></title>
    <?php $this->head() ?>

</head>
<style type="text/css">

    .show_dl{
        width: auto;
        height: auto;
    }
    .show_left{
        width: auto;
        height: auto;
        display: block;
        clear: both;
        overflow: hidden;
    }
    .show_dl dd{
        display: inline;
        padding-right: 5px;
        font-size: 14px;
        font-family: "微软雅黑", Arial, "Trebuchet MS", Helvetica, Verdana;
        color: #999;
    }
    .show_left dd{
        overflow: hidden;
        clear: both;
        float: left;
        margin-right: 10px;
        font-family: "微软雅黑", Arial, "Trebuchet MS", Helvetica, Verdana;
        font-size: 14px;
        color: #999;
    }
    .show_li{
        overflow: hidden;
        clear: both;
        margin-bottom: 2px;
    }
    .show_li dd{
        float: left;margin-right: 10px;
        font-family: "微软雅黑", Arial, "Trebuchet MS", Helvetica, Verdana;
        font-size: 14px;
        color: #999;
    }
    .show_li dd span,.show_left dd span, .show_dl dd span{
        color: #000;
        font-size: 13px;
        margin-right: 3px;
    }
    .show_p{
        font-size: 15px;
        text-align:left;
        line-height: inherit;
        font-family: "微软雅黑";
        padding-top: 2px;
    }
    .show_h4{
        width: 100%;
        text-align: left;
        clear: both;
        color: #00a0e9;
        font-size: 16px;
        font-family: "微软雅黑", Arial, "Trebuchet MS", Helvetica, Verdana;
    }
    .show_h5{
        width: 100%;
        text-align: left;
        clear: both;
        margin-top: 10px;
        color: #0a568c;
        font-size: 16px;
        font-family: "微软雅黑", Arial, "Trebuchet MS", Helvetica, Verdana;
    }
    .show_group{
        padding: 5px 0;
        height: auto;
        width: auto;
        border-bottom: 1px dashed yellow;
    }
    .shows{
        padding-right: 0;
        padding-left: 0;
        width: 100%;
    }
    .shows h3{
        text-align: center;
    }
    .footer{
        clear: both;
        width: 100%;
        position: fixed;
        bottom: 0;
    }
</style>
<body  class="skin-block fixed">
<?php $this->beginBody() ?>
<div class="container" style="width: 100%;border: none;background-color: #f8f8f8">
    <div class="row clearfix" style="width: 80%;margin: 0 auto;border: none">
        <div>
            <nav class="navbar navbar-default" role="navigation" style="border: none">


                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                   <?php if(isset($_GET['at'])&&$_GET['at']==1):?>
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="/?at=1">项目列表</a>
                        </li>
                        <li>
                            <a href="/detection.html?at=2">检测指标</a>
                        </li>

                    </ul>
                    <?php else:?>
                       <ul class="nav navbar-nav">
                           <li>
                               <a href="/?at=1">项目列表</a>
                           </li>
                           <li  class="active">
                               <a href="/detection.html?at=2">检测指标</a>
                           </li>

                       </ul>
                   <?php endif;?>
                    <form class="navbar-form navbar-right" role="search" style="padding-top: 10px;" action="/?at=1">
                        <div class="form-group">
                            <input type="text" name="Project[pro_name]" class="form-control" placeholder="项目名称" />
                        </div>
                        <div class="form-group">
                            <input type="text"  name="Project[pro_retrieve]" class="form-control" placeholder="项目检索号"/>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>

                </div>

            </nav>
        </div>
    </div>
</div>
<?php $this->beginBody() ?>
<div class="login_bg">

    <?= $content ?>

</div>

<?php $this->endBody() ?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12" style="text-align: center">&copy;  <?= date('Y') ?> 版权所有 侵权必究</div>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
