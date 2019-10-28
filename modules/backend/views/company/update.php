<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = '修改公司信息: ' . $model->company;
$this->params['breadcrumbs'][] = ['label' => '试剂详情', 'url' => ['reagent/view','id'=>$model->rid]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="content-update">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('试剂详情', ['reagent/view','id'=>$model->rid]) ?></li>
            <li role="presentation" class="active"><?= Html::a('修改公司信息', '#') ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
                'parent'=>$parent
            ]) ?>
        </div>
    </div>
</div>
