<?php

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;
use app\models\Project;
use app\models\Principal;
use yii\grid\CheckboxColumn;

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
        <div class="tab-content">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => CheckboxColumn::className()],
                    [
                        'attribute' => 'pro_id',
                        'options' => ['style' => 'width:50px'],
                        'format' => 'html',
                    ],
                    'pro_description',
                    [
                        'attribute' => 'pro_description',
                        'options' => ['style' => 'width:60px'],
                        'format' => 'html',


                    ],
                    'pro_description',
                    [
                        'attribute' => 'pro_description',
                        'options' => ['style' => 'width:60px'],
                        'format' => 'html',


                    ],

                    [
                        'class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',
                        'options' => ['style' => 'width:60px']
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>