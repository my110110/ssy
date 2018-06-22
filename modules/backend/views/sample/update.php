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

        <div class="tab-content">
            <p>


                <?= Html::a('返回列表', ['sample/index'], [
                    'title'=>'返回列表',
                    'class' => 'btn btn-primary',

                ]) ?>

                <?= Html::a('返回分组', ['group/view', 'id' => $model->id], [
                    'title'=>'返回项目',
                    'class' => 'btn btn-primary',

                ]) ?>




            </p>
            <?= $this->render('_form', [
                'model' => $model,
                'sample'=>$sample
            ]) ?>
        </div>
    </div>
</div>
