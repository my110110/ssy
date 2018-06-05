<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = '修改样品: ' . $sample->name;
$this->params['breadcrumbs'][] = ['label' => '返回分组', 'url' => ['group/view','id'=>$model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="content-update">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('返回分组', ['group/view','id'=>$model->id]) ?></li>
            <li role="presentation"><?= Html::a('添加项目分组', ['create','id'=>$model->id]) ?></li>
            <li role="presentation" class="active"><?= Html::a('修改项目分组', '#') ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
                'sample'=>$sample
            ]) ?>
        </div>
    </div>
</div>
