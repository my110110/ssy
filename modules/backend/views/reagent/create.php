<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sample */

$this->title = '添加检测试剂';
$this->params['breadcrumbs'][] = ['label' => '返回上级', 'url' => ["$model->type/view",'id'=>$model->sid]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">

            <li role="presentation"><?= Html::a('返回上级', ["$model->type/view",'id'=>$model->sid]) ?></li>
            <li role="presentation" class="active"><?= Html::a('新增检测试剂') ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
