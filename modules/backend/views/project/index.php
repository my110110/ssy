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
                    'method' => 'get',
                ]); ?>

                <?= $form->field($searchModel, 'pro_name',
                    ['options'=>
                     ['tag'=>false ],
                    'template' => '<div class=" col-md-2 column">  {input}</div>',

                ])->textInput
                (
                    [
                        'autofocus' => true,
                        'placeholder'=>'项目名称'
                    ]
                ) ?>
                <?= $form->field($searchModel, 'pro_retrieve',
                    ['options'=>
                        ['tag'=>false ],
                        'template' => '<div class=" col-md-2 column">  {input}</div>',

                    ]) ->textInput
                (
                    [
                        'autofocus' => true,
                        'placeholder'=>'项目检索号'
                    ]
                )?>
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end(); ?>
            </div>
            <div style="width: 100%;height: 10px;"></div>
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
                        'header' =>'更多操作',
                        'format'=>'raw',
                        'options' => ['style' => 'width:10%;text-align:center'],
                        'value' => function($dataProvider){
                            $button = '' ;
                            $button .= Html::a('<span class="glyphicon glyphicon-plus  btn btn-success btn-sm"></span>',  ['principal/create','pro_id'=>$dataProvider->pro_id], ['title' => '添加负责人']) ;
                            $button .=  Html::a('    <span class="glyphicon glyphicon-plus  btn btn-warning btn-sm"></span>', ['principal/create','pro_pid'=>$dataProvider->pro_id], ['title' => '添加子项目']) ;
                            return $button;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'header'=>'操作',
                        'options' => ['style' => 'width:5%;text-align:center']
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>

<?= Html::a('添加请假单', ['principal/create'], ['class' => 'btn btn-success','data-toggle'=>'modal','data-target'=>'#ajax']) ?>

<div class="modal bs-example-modal-lg" id="ajax">

    <div class="modal-dialog">

        <div class="modal-content width_reset" id="tmpl-modal-output-render"> </div>

    </div>

</div>
