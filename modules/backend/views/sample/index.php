<?php

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;
use app\models\Project;
use app\models\Group;
use app\modules\backend\models\AdminUser;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pagination yii\data\Pagination */
$this->title = '样本列表';
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

                <?= $form->field($search, 'name',
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
                                所属项目
                            </th>
                            <th>
                                所属分组
                            </th>
                            <th>
                                描述
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
                                <td colspan="7">没有数据</td>
                            </tr>
                        <?php elseif(isset($_GET['Sample'])&&!empty(array_filter($_GET['Sample']))):?>
                            <?php foreach($model as $sarch): ?>
                                <tr class="shows success" >

                                    <td>
                                        <?=$sarch['name'];?>
                                    </td>
                                    <td>
                                        <?=$sarch['retrieve'];?>
                                    </td>
                                    <td>
                                        <?= Html::a(Project::getProName($sarch['pid']), ['project/view', 'id' => $sarch['pid']], ['title'=>'查看']) ?>
                                    </td>
                                    <td>
                                        <?= Html::a(Group::getParName($sarch['gid']), ['group/view', 'id' => $sarch['gid']], ['title'=>'查看']) ?>
                                    </td>
                                    <td>
                                        <?=$sarch['descript'];?>
                                    </td>


                                    <td>
                                        <?=AdminUser::getUserName($sarch['add_user'])?>
                                    </td>
                                    <td>
                                        <?=$sarch['add_time']?>
                                    </td>
                                    <td>
                                        <?=$sarch['change_time']?>
                                    </td>
                                    <td>
                                        <?= Html::a('<span class="glyphicon glyphicon-zoom-in"></span>', ['view', 'id' => $sarch['id'],'ret'=>'1'], ['title'=>'查看']) ?>
                                        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $sarch['id'],'ret'=>'1'], ['title'=>'修改']) ?>
                                        <?= Html::a('<span class="	glyphicon glyphicon-trash"></span>', ['delete', 'id' => $sarch['id'],'ret'=>'1'], [
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
                                        <?=$pid['name'];?>
                                    </td>
                                    <td>
                                        <?=$pid['retrieve'];?>
                                    </td>
                                    <td>
                                        <?= Html::a(Project::getProName($pid['pid']), ['project/view', 'id' => $pid['pid']], ['title'=>'查看']) ?>
                                    </td>
                                    <td>
                                        <?= Html::a(Group::getParName($pid['gid']), ['group/view', 'id' => $pid['gid']], ['title'=>'查看']) ?>

                                    </td>
                                    <td>
                                        <?=$pid['descript'];?>
                                    </td>


                                    <td>
                                        <?=AdminUser::getUserName($pid['add_user'])?>
                                    </td>
                                    <td>
                                        <?=$pid['add_time']?>
                                    </td>
                                    <td>
                                        <?=$pid['change_time']?>
                                    </td>
                                    <td>
                                        <?= Html::a('<span class="glyphicon glyphicon-zoom-in"></span>', ['view', 'id' => $pid['id'],'ret'=>'1'], ['title'=>'查看']) ?>
                                        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $pid['id'],'ret'=>'1'], ['title'=>'修改']) ?>
                                        <?= Html::a('<span class="	glyphicon glyphicon-trash"></span>', ['delete', 'id' => $pid['id']], [
                                            'title'=>'删除',
                                            'data' => [
                                                'confirm' => '确定要删除这个数据吗?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
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





