<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = '修改检测试剂: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '检测指标详情', 'url' => ['routine/view','id'=>$model->sid]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="content-update">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('检测指标详情', ['routine/view','id'=>$model->sid]) ?></li>
            <li role="presentation" class="active"><?= Html::a('修改检测指标', '#') ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
