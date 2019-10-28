<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = '修改指标: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '项目列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="content-update">
    <div class="nav-tabs-custom">

        <p>


            <?= Html::a('返回列表', ['testmethod/index'], [
                'title'=>'返回列表',
                'class' => 'btn btn-primary',

            ]) ?>

            <?= Html::a('检测指标列表', ['particular/view', 'id' => $model->pid], [
                'title'=>'返回项目',
                'class' => 'btn btn-primary',

            ]) ?>




        </p>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
