<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2016/12/7
 * Time: 10:55
 * Email:liyongsheng@meicai.cn
 */

/* @var $this yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */
use yii\grid\GridView;
use yii\bootstrap\Html;


?>
<div class="container">
    <div style="height: 10px;width: 100%"></div>
    <div class="row clearfix">
        <div class="col-md-12 column">
            <ul class="breadcrumb">
                <li>
                    <a href="/">首页</a>
                </li>
                <li>
                    <a >新闻公告</a>
                </li>

            </ul>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions'=>['class'=>'table-simple'],
                    'showHeader'=>false,
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        [
                            'attribute'=>'title',
                            'format'=>'raw',
                            'value'=>function($item){
                                $html = '<h4>'.Html::a($item->title, ['/news/item', 'id'=>$item->id]).'</h4>';
                                $html .= '<p>'.Html::encode($item->description).'</p>';
                                return $html;
                            }
                        ],
                        [
                            'attribute'=>'created_at',
                            'format'=>'date',
                            'options'=>['class'=>'text-right','style'=>'width:100px']
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
