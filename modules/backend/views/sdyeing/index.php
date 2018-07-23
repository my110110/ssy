<?php

use yii\helpers\Html;

use app\models\Pna;
use app\models\Routine;
use app\models\Particular;
use app\modules\backend\models\AdminUser;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pagination yii\data\Pagination */
$this->title = '实验结果列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .head th{
        font-size: inherit;
        font-family: "Microsoft YaHei UI";
    }
</style>
<div class="content-index">
    <div class="nav-tabs-custom">


        <div class="tab-content cos">
            <div class="row clearfix">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>

                <?= $form->field($search, 'section_name',
                    ['options'=>
                        ['tag'=>false ],
                        'template' => '<div class=" col-md-2 column">  {input}</div>',

                    ])->textInput
                (
                    [
                        'autofocus' => true,
                        'placeholder'=>'名称'
                    ]
                ) ?>
                <?= $form->field($search, 'retrieve',
                    ['options'=>
                        ['tag'=>false ],
                        'template' => '<div class=" col-md-2 column">  {input}</div>',

                    ]) ->textInput
                (
                    [
                        'autofocus' => true,
                        'placeholder'=>'检索号'
                    ]
                )?>
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end(); ?>
            </div>

            <div class="row clearfix" style="margin-top: 10px;">
                <div class="col-md-12 column">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr class="info head">

                            <th>
                                名称
                            </th>
                            <th>
                                检索号
                            </th>
                            <th>
                                检测标本
                            </th>
                            <th>
                                检测指标
                            </th>
                            <th>
                                指标类型
                            </th>
                            <th>
                                切片类型
                            </th>
                            <th>
                                创建人
                            </th>
                            <th>
                                创建时间
                            </th>
                            <th>
                                更新时间
                            </th>
                            <th>
                                操作
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(empty($model)):?>
                            <tr class="error">
                                <td colspan="9">没有数据</td>
                            </tr>
                        <?php elseif(isset($_GET['Sdyeing'])&&!empty(array_filter($_GET['Sdyeing']))):?>
                            <?php foreach($model as $sarch): ?>
                                <tr class="shows success" >

                                    <td>
                                        <?=$sarch['section_name'];?>
                                    </td>
                                    <td>
                                        <?=$sarch['retrieve'];?>
                                    </td>
                                    <td>
                                         <?= Html::a(\app\models\Stace::getParName($sarch['yid']), ['stace/view', 'id' => $sarch['yid']], ['title'=>'查看']) ?>
                                    </td>

                               <?php if($sarch['ntype']==1):?>
                                    <td>
                                        <?= Html::a(\app\models\Routine::getParName($sarch['nid']), ['routine/view', 'id' => $sarch['nid']], ['title'=>'查看']) ?>
                                    </td>
                                    <td>
                                        <?='常规H&E染色'?>
                                    </td>
                               <?php elseif($sarch['ntype']==2):?>
                                    <td>
                                         <?= Html::a(\app\models\Particular::getParName($sarch['nid']), ['particular/view', 'id' => $sarch['nid']], ['title'=>'查看']) ?>
                                    </td>
                                   <td>
                                       <?='特殊染色'?>
                                   </td>
                               <?php elseif($sarch['ntype']==3):?>
                                    <td>
                                        <?= Html::a(Pna::getParName($sarch['nid']), ['pna/view', 'id' => $sarch['nid'],'type'=>'1'], ['title'=>'查看']) ?>
                                    </td>
                                   <td>
                                       <?='蛋白指标'?>
                                   </td>
                               <?php elseif($sarch['ntype']==4):?>
                                    <td>
                                        <?= Html::a(Pna::getParName($sarch['nid']), ['pna/view', 'id' => $sarch['yid'],'type'=>'1'], ['title'=>'查看']) ?>
                                    </td>
                                   <td>
                                       <?='核酸指标'?>
                                   </td>
                               <?php endif;?>

                                    <td>
                                        <?=\app\models\Sdyeing::$section_type[$sarch['section_type']]?>
                                    </td>

                                    <td>
                                        <?=AdminUser::getDoName($sarch['id'],1,'sdyeing')?>
                                    </td>
                                    <td>
                                        <?=$sarch['add_time']?>
                                    </td>
                                    <td>
                                        <?=$sarch['change_time']?>
                                    </td>

                                    <td>
                                        <?= Html::a('<span class="glyphicon glyphicon-zoom-in"></span>', ['view', 'id' => $sarch['id'],'ret'=>'1'], ['title'=>'查看']) ?>
                                        <?php if($sarch['ntype']==1):?>
                                            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['routine/change', 'id' => $sarch['id'],'ret'=>'1'], ['title'=>'修改']) ?>
                                        <?php elseif ($sarch['ntype']==2):?>
                                            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['particular/change', 'id' => $sarch['id'],'ret'=>'1'], ['title'=>'修改']) ?>

                                        <?php elseif (in_array($sarch['ntype'],[3,4])):?>
                                            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['pna/change', 'id' => $sarch['id'],'ret'=>'1','ntype'=>$sarch['ntype']], ['title'=>'修改']) ?>

                                        <?php endif;?>                                        <?= Html::a('<span class="	glyphicon glyphicon-trash"></span>', ['delete', 'id' => $sarch['id'],'ret'=>'1'], [
                                            'title'=>'删除',
                                            'data' => [
                                                'confirm' => '确定要删除这个数据吗?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        <?php else:?>
                            <?php foreach($model as $pid): ?>
                                <tr class="shows success" >
                                    <td>
                                        <?=$pid['section_name'];?>
                                    </td>
                                    <td>
                                        <?=$pid['retrieve'];?>
                                    </td>
                                    <td>
                                        <?= Html::a(\app\models\Stace::getParName($pid['yid']), ['stace/view', 'id' => $pid['yid']], ['title'=>'查看']) ?>

                                    </td>

                                   <?php if($pid['ntype']==1):?>
                                    <td>

                                            <?= Html::a(\app\models\Routine::getParName($pid['nid']), ['routine/view', 'id' => $pid['nid']], ['title'=>'查看']) ?>
                                    </td>
                                    <td>
                                        <?='常规H&E染色'?>
                                    </td>
                                   <?php elseif($pid['ntype']==2):?>
                                    <td>
                                            <?= Html::a(\app\models\Particular::getParName($pid['nid']), ['particular/view', 'id' => $pid['nid']], ['title'=>'查看']) ?>
                                    </td>
                                   <td>
                                       <?='特殊染色'?>
                                   </td>
                                  <?php elseif($pid['ntype']==3):?>
                                     <td>
                                            <?= Html::a(\app\models\Pna::getParName($pid['nid']), ['pna/view', 'id' => $pid['nid'],'type'=>'1'], ['title'=>'查看']) ?>
                                     </td>
                                       <td>
                                           <?='蛋白指标'?>
                                       </td>
                                    <?php elseif($pid['ntype']==4):?>
                                    <td>
                                            <?= Html::a(\app\models\Pna::getParName($pid['nid']), ['pna/view', 'id' => $pid['nid'],'type'=>'1'], ['title'=>'查看']) ?>
                                    </td>

                                       <td>
                                           <?='核酸指标'?>
                                       </td>
                                    <?php endif;?>

                                    <td>
                                        <?=\app\models\Sdyeing::$section_type[$pid['section_type']]?>
                                    </td>
                                    <td>
                                        <?=AdminUser::getDoName($pid['id'],1,'sdyeing')?>
                                    </td>

                                    <td>
                                        <?=$pid['add_time']?>
                                    </td>
                                    <td>
                                        <?=$pid['change_time']?>
                                    </td>
                                    <td>
                                        <?= Html::a('<button type="button" class="btn btn-default btn-xs">查看</button>', ['view', 'id' => $pid['id'],'ret'=>'1'], ['title'=>'查看']) ?>
                                        <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
                                       <?php if($pid['ntype']==1):?>
                                            <?= Html::a('<button type="button" class="btn btn-warning btn-xs">修改</button>', ['routine/change', 'id' => $pid['id'],'ret'=>'1'], ['title'=>'修改']) ?>
                                        <?php elseif ($pid['ntype']==2):?>
                                            <?= Html::a('<button type="button" class="btn btn-warning btn-xs">修改</button>', ['particular/change', 'id' => $pid['id'],'ret'=>'1'], ['title'=>'修改']) ?>

                                        <?php elseif (in_array($pid['ntype'],[3,4])):?>
                                            <?= Html::a('<button type="button" class="btn btn-warning btn-xs">修改</button>', ['pna/change', 'id' => $pid['id'],'ret'=>'1','ntype'=>$pid['ntype']], ['title'=>'修改']) ?>

                                        <?php endif;?>

                                        <?= Html::a('<button type="button" class="btn btn-danger btn-xs">删除</button>', ['delete', 'id' => $pid['id']], [
                                            'title'=>'删除',
                                            'data' => [
                                                'confirm' => '确定要删除这个数据吗?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                        <?php endif;?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<?php // 显示分页
echo LinkPager::widget([
    'pagination' => $pagination,
    'firstPageLabel'=>"First",
    'prevPageLabel'=>'Prev',
    'nextPageLabel'=>'Next',
    'lastPageLabel'=>'Last',
]);
?>




