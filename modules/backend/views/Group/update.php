<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = '修改分组项目: ' . $group->group_name;
$this->params['breadcrumbs'][] = ['label' => '项目列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="content-update">
    <div class="nav-tabs-custom">


        <div class="tab-content">
            <p>


                <?= Html::a('返回列表', ['group/index'], [
                    'title'=>'返回列表',
                    'class' => 'btn btn-primary',

                ]) ?>

                <?= Html::a('返回项目', ['project/view', 'id' => $group->pro_id], [
                    'title'=>'返回项目',
                    'class' => 'btn btn-primary',

                ]) ?>




            </p>
            <?= $this->render('_form', [
                'model' => $model,
                'group'=>$group
            ]) ?>
        </div>
    </div>
</div>
