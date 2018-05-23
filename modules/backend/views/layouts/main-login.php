<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\modules\backend\assets\BackendAsset;
BackendAsset::register($this);
$assets_url=$this->getAssetManager()->getBundle(BackendAsset::className())->baseUrl;

?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>

        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <link href="<?=$assets_url?>/css/backend.min.css"  rel="stylesheet"/>
        <link href="<?=$assets_url?>/css/backend.css"  rel="stylesheet"/>
    </head>
    <body>

    <?php $this->beginBody() ?>
            <div class="login_bg">

                        <?= $content ?>

            </div>

    <?php $this->endBody() ?>
    </body>
    </html>

<?php $this->endPage() ?>