<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\widgets\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Carousel;
use yii\helpers\Url;

AppAsset::register($this);
$carouselItems = [];
if (isset($this->params['adList'])) {
    foreach ($this->params['adList'] as $item) {
        $carouselItems[] = [
            'content' => '<a href="' . $item['link'] . '" target="_black"><img src="' . $item['image'] . '" style="width:100%"/></a>',
//        'caption'=>'<h4>'.$item['title'].'</h4>',
        ];
    }
}
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
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?baf532329283c0cae060310499633101";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
        (function(){
            var src = (document.location.protocol == "http:") ? "http://js.passport.qihucdn.com/11.0.1.js?44fe98c387976b344e710998b9ca68bb":"https://jspassport.ssl.qhimg.com/11.0.1.js?44fe98c387976b344e710998b9ca68bb";
            document.write('<script src="' + src + '" id="sozz"><\/script>');
        })();
    </script>
</head>
<body  class="skin-block fixed">
<?php $this->beginBody() ?>
<div class="wrap">
    <div class="main-header">
        <?php NavBar::begin([
            'brandLabel' => $brandLabel,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar  navbar-static-top navbar-default ',
            ],
        ]);
        echo Nav::widget(json_decode(Yii::$app->params['nav'], true));
        ?>
        <?php NavBar::end(); ?>
    </div>
    <div class="carousel slide" id="carousel-375217">
        <?= Carousel::widget([
            'options'=>['class'=>'carousel slide', 'data-ride'=>"carousel"],
            'items' => $carouselItems,
            'controls'=>['<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>',
                '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>'],
        ])?>


    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>

</div>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">&copy;  <?= date('Y') ?> 版权所有 侵权必究</div>
        </div>
        <div class="row">

            <div class="col-lg-3">
                <p>技术支持<a href="www.letmigo.com">郑永辉先生</a> <?= \app\widgets\Hook::widget(['configName'=>'tongji']); ?></p>
            </div>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
<?= \app\widgets\Hook::widget(['configName'=>'tongji']); ?>
</body>
</html>
<?php $this->endPage() ?>
