<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = '修改指标: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '项目列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="content-update">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('检测指标列表', ['particular/view','id'=>$model->pid]) ?></li>
            <li role="presentation" class="active"><?= Html::a('修改检测指标', '#') ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
