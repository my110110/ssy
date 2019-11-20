<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sample */

$this->title = '添加样品';
$this->params['breadcrumbs'][] = ['label' => '实验分组', 'url' => ['group/view','id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('实验分组', ['group/view','id'=>$model->id]) ?></li>
            <li role="presentation" class="active"><?= Html::a('添加样本') ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
                'sample'=>$sample
            ]) ?>
        </div>
    </div>
</div>
