<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Routine */

$this->title = '添加检测指标';
$this->params['breadcrumbs'][] = ['label' => '检测指标列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('检测指标列表', ['index','type'=>$model->type]) ?></li>
            <li role="presentation" class="active"><?= Html::a('添加检测指标', ['']) ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
