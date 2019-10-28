<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sample */

$this->title = '添加公司信息';
$this->params['breadcrumbs'][] = ['label' => '试剂详情', 'url' => ['reagent/view','id'=>$parent->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('试剂详情', ['reagent/view','id'=>$parent->id]) ?></li>
            <li role="presentation" class="active"><?= Html::a('新增公司信息') ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
                'parent'=>$parent
            ]) ?>
        </div>
    </div>
</div>
