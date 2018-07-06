<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = '添加实验分组';
$this->params['breadcrumbs'][] = ['label' => '实验项目', 'url' => ['project/view','id'=>$model->pro_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('实验项目', ['project/view','id'=>$model->pro_id]) ?></li>
            <li role="presentation" class="active"><?= Html::a('添加项目') ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
                'group'=>$group
            ]) ?>
        </div>
    </div>
</div>
