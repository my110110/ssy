<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = '修改案例: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '成功案例', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="content-update">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('成功案例', ['index']) ?></li>
            <li role="presentation"><?= Html::a('添加案例', ['create']) ?></li>
            <li role="presentation" class="active"><?= Html::a('修改案例', '#') ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
