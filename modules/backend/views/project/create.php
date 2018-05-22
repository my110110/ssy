<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = '添加项目';
$this->params['breadcrumbs'][] = ['label' => '实验项目', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('实验项目', ['index']) ?></li>
            <li role="presentation" class="active"><?= Html::a('添加项目', ['create']) ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
                'principal'=>$principal
            ]) ?>
        </div>
    </div>
</div>
