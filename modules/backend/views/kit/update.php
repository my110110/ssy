<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = '修改公司信息: ' . $model->company;
$this->params['breadcrumbs'][] = ['label' => '返回上级', 'url' => ["$model->type/view",'id'=>$model->rid]];
$this->params['breadcrumbs'][] = '修改';
?>

<div class="content-update">

    <div class="nav-tabs-custom">
        <p>
            <?= Html::a('返回上级', ["$model->type/view",'id'=>$model->rid], [
                'title'=>'返回',
                'class' => 'btn btn-primary',

            ]) ?>
            <?= Html::a('返回详情', ["view",'id'=>$model->id], [
                'title'=>'返回',
                'class' => 'btn btn-warning',

            ]) ?>
            <?= Html::a('修改数据', ['#'], [
                'title'=>'修改数据',
                'class' => 'btn btn-success',

            ]) ?>


        </p>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
