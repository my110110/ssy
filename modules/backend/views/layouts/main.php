<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\modules\backend\assets\BackendAsset;
use yii\bootstrap\Alert;

BackendAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
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
        padding-right: 0;
        margin-right: 0;
    }
    #uploadfile-file {
        height: 23px;
        width: 100%;
        line-height: 23px;
        border: 1px solid #ccc;
        background: #ffffff;
        margin-right: 0;
        padding-right: 0;
    }
    .uploadfile{
        height: 23px;
        line-height: 1px;
    }
    .ace-pid-input{
        width: auto;
        line-height: 1px;
    }
    .part{
        height: 23px;
        line-height: 23px;
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
