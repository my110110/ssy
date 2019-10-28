<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\modules\backend\assets\BackendAsset;
use yii\bootstrap\Alert;

BackendAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
$assets_url=$this->getAssetManager()->getBundle(BackendAsset::className())->baseUrl;

?>
<?php if (Yii::$app->controller->action->id === 'login'): ?>
    <?= $this->render('main-login', [
        'content' => $content
    ]) ?>
<?php else: ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link href="<?=$assets_url?>/css/backend.min.css"  rel="stylesheet"/>
        <link href="<?=$assets_url?>/css/style.css"  rel="stylesheet"/>

        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini fixed">
    <?php $this->beginBody() ?>

    <div class="wrap" style="height: auto;">
        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>
        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php endif ?>
<style type="text/css">
    .ace-file-input{
        display: inline-block;
        padding-right: 0;
        margin-right: 0;
        position:absolute;
        right: 100px;
    }
    .ace-file-input1{
        display: inline-block;
        padding-right: 0;
        margin-right: 0;
        position:absolute;
        right: 100px;
    }
    .uploadfile1{
        position: absolute;
        right: 45px;
        height: 27px;
        line-height: 5px;
        margin: 0;
        padding: 0;
    }
    .ace-file-input2{
        display: inline-block;
        padding-right: 0;
        margin-right: 0;
        position:absolute;
        left: 15px;
    }
    .uploadfile2{
        position: absolute;
        left: 245px;
        height: 27px;
        line-height: 5px;
        margin: 0;
        padding: 0;
    }
    .ace-file-inputs{
        display: inline-block;
        padding-right: 0;
        margin-right: 0;
        position:absolute;
        right: 200px;
    }
    #uploadfile-file {

        height: 27px;
        width: 100%;
        line-height: 25px;
        border: 1px solid #ccc;
        background: #ffffff;
        margin-right: 0;
        padding-right: 0;
    }
    .uploadfile{
        position: absolute;
        right: 45px;
        height: 27px;
        line-height: 5px;
        margin: 0;
        padding: 0;
    }
    .ace-pid-input{
        width: auto;
        line-height: 1px;
    }
    .part{
        position: absolute;
        right: 130px;
        width: 85px;
        height: 27px;
        line-height: 27px;
        font-size: 12px;
        padding: 0;
        margin: 0;

    }
    .part option{
        height: 24px;
        line-height: 1px;
        font-size: 12px;

    }

</style>
