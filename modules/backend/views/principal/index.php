<?php

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;
use app\models\Principal;
use yii\grid\CheckboxColumn;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel app\models\Principal */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pagination yii\data\Pagination */

$this->title =   "$project->pro_name".'项目负责人';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><?= Html::a('实验项目负责人', ['index','id'=>$project->pro_id]) ?></li>
            <li role="presentation"><?= Html::a('添加项目负责人', ['create','id'=>$project->pro_id]) ?></li>
        </ul>


            <?= GridView::widget([
                'dataProvider' => $dataProvider,

                'columns' => [
                    [
                        'class' => CheckboxColumn::className(),
                        'options' => ['style' => 'width:5%;text-align:center']

                    ],

                    [
                        'attribute' => 'name',
                        'options' => ['style' => 'width:15%;;text-align:center']
                    ],
                    [
                        'attribute' => 'department',
                        'options' => ['style' => 'width:15%;;text-align:center']
                    ],


                    [
                        'attribute' => 'email',
                        'options' => ['style' => 'width:10%;text-align:center']
                    ],

                    [
                        'attribute' => 'telphone',
                        'options' => ['style' => 'width:20%;text-align:center']
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',
                        'header'=>'操作',
                        'options' => ['style' => 'width:5%;text-align:center']
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>


