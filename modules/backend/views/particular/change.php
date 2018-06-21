<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = '修改实验结果';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-update">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('返回上级', ['stace/view','id'=>$model->yid]) ?></li>
            <li role="presentation" class="active"><?= Html::a('修改实验结果', ['']) ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_sform', [
                'model' => $model,
                'particular'=>$particular,
                'reagent'=>$reagent,
                'kit'=>$kit
            ]) ?>
        </div>
    </div>
</div>
