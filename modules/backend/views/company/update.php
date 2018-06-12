<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = '修改样品: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '返回样品详情', 'url' => ['sample/view','id'=>$model->sid]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="content-update">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('返回样品详情', ['sample/view','id'=>$model->sid]) ?></li>
            <li role="presentation"><?= Html::a('新增实验样本的特定组织与细胞标本', ['create','id'=>$model->sid]) ?></li>
            <li role="presentation" class="active"><?= Html::a('修改项目分组', '#') ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
                'parent'=>$parent
            ]) ?>
        </div>
    </div>
</div>
