<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
$this->title = $model->pro_name;
$this->params['breadcrumbs'][] = ['label' => '产品管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="content-view">


    <p>
        <?= Html::a('Additems', ['create', 'pro_pid' => $model->pro_id], [
            'title'=>'添加子项目',
            'class' => 'btn btn-primary',

        ]) ?>
        <?= Html::a('Addprincipal', ['principal/create', 'pro_id' => $model->pro_id], [
            'title'=>'添加负责人',
            'class' => 'btn btn-success',

        ]) ?>
        <?= Html::a('Update', ['update', 'pro_id' => $model->pro_id], ['class' => 'btn btn-warning','title'=>'修改']) ?>
        <?= Html::a('Delete', ['delete', 'pro_id' => $model->pro_id], [
            'class' => 'btn btn-danger',
            'title'=>'删除',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pro_id',
            'pro_name',
            'pro_description',
            'pro_keywords',
            'pro_add_time',
            'pro_add_time',


        ],
    ]) ?>

</div>
