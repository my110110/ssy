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

        <div class="tab-content">
            <p>


                <?= Html::a('返回列表', ['stace/index'], [
                    'title'=>'返回列表',
                    'class' => 'btn btn-primary',

                ]) ?>

                <?= Html::a('返回样品详情', ['sample/view', 'id' => $model->sid], [
                    'title'=>'返回项目',
                    'class' => 'btn btn-primary',

                ]) ?>




            </p>
            <?= $this->render('_form', [
                'model' => $model,
                'parent'=>$parent
            ]) ?>
        </div>
    </div>
</div>
