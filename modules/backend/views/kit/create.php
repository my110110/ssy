<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sample */

$this->title = '添加数据';
$this->params['breadcrumbs'][] = ['label' => '返回上级', 'url' => ["$model->type/view",'id'=>$model->rid]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <div class="tab-content">
    <p>
        <?= Html::a('返回', ["$model->type/view",'id'=>$model->rid], [
            'title'=>'返回',
            'class' => 'btn btn-primary',

        ]) ?>

        <?= Html::a('新增数据', ['#'], [
            'title'=>'添加负责人',
            'class' => 'btn btn-success',

        ]) ?>


    </p>
    </div>
    <div class="nav-tabs-custom">

        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
