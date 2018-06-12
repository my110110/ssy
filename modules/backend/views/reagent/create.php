<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sample */

$this->title = '添加检测试剂';
$this->params['breadcrumbs'][] = ['label' => '检测指标', 'url' => ['reagent/view','id'=>$parent->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('检测指标详情', ['reagent/view','id'=>$parent->id]) ?></li>
            <li role="presentation" class="active"><?= Html::a('新增检测试剂') ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
                'parent'=>$parent
            ]) ?>
        </div>
    </div>
</div>
