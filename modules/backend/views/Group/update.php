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
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('项目详情', ['project/view','id'=>$group->pro_id]) ?></li>
            <li role="presentation"><?= Html::a('添加项目分组', ['create','id'=>$group->pro_id]) ?></li>
            <li role="presentation" class="active"><?= Html::a('修改项目分组', '#') ?></li>
        </ul>
        <div class="tab-content">
            <?= $this->render('_form', [
                'model' => $model,
                'group'=>$group
            ]) ?>
        </div>
    </div>
</div>
