<?php

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;
use app\models\Project;
use app\models\Principal;
use yii\grid\CheckboxColumn;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pagination yii\data\Pagination */

$this->title = '项目列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><?= Html::a('实验项目', ['index']) ?></li>
            <li role="presentation"><?= Html::a('添加项目', ['create']) ?></li>
        </ul>

        <div class="tab-content cos">
            <div class="content-search">

                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'post',
                ]); ?>

                <?= $form->field($searchModel, 'pro_name',['options'=>
                    ['tag'=>false ],
                    'template' => '{input}'

                ])->textInput
                (
                    [
                        'autofocus' => true,
                        'placeholder'=>'项目名称'
                    ]
                ) ?>



                <?= $form->field($searchModel, 'pro_retrieve') ?>
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end(); ?>

            </div>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => CheckboxColumn::className(),
                        'options' => ['style' => 'width:5%;text-align:center']

                    ],

                    [
                        'attribute' => 'pro_name',
                        'options' => ['style' => 'width:15%;;text-align:center']
                    ],
                    [
                        'attribute' => 'pro_retrieve',
                        'options' => ['style' => 'width:15%;;text-align:center']
                    ],

                    [
                        'attribute' => 'pro_kind_id',
                        'options' => ['style' => '10%;text-align:center'],
                        'value'=>function($dataProvider){
                               return Project::$kind_type[$dataProvider->pro_kind_id];
                        }
                    ],
                    [
                        'attribute' => 'pro_sample_count',
                        'options' => ['style' => 'width:10%;text-align:center']
                    ],

                    [
                        'attribute' => 'pro_add_time',
                        'options' => ['style' => 'width:15%;text-align:center']
                    ],
                    [
                        'attribute' => 'pro_description',
                        'options' => ['style' => 'width:15%;text-align:center']
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',
                        'header'=>'操作',
                        'options' => ['style' => 'width:15%;text-align:center']
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>