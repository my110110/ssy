<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = '修改实验项目: ' . $model->pro_name;
$this->params['breadcrumbs'][] = ['label' => '项目列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="content-update">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('项目列表', ['index']) ?></li>
            <li role="presentation"><?= Html::a('添加实验项目', ['create']) ?></li>
            <li role="presentation" class="active"><?= Html::a('修改实验项目', '#') ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
                'principal'=>$principal
            ]) ?>
        </div>
    </div>
</div>
