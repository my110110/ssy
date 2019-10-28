<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sample */

$this->title = '添加样品';
$this->params['breadcrumbs'][] = ['label' => '实验样品', 'url' => ['sample/view','id'=>$parent->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('实验样品', ['sample/view','id'=>$parent->id]) ?></li>
            <li role="presentation" class="active"><?= Html::a('新增实验样本的特定组织与细胞标本') ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
                'parent'=>$parent
            ]) ?>
        </div>
    </div>
</div>
