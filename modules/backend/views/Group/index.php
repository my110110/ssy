<?php

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;
use app\models\Project;
use app\modules\backend\models\AdminUser;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pagination yii\data\Pagination */
$this->title = '分组列表';
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

                <?= $form->field($search, 'group_name',
                    ['options'=>
                     ['tag'=>false ],
                    'template' => '<div class=" col-md-2 column">  {input}</div>',

                ])->textInput
                (
                    [
                        'autofocus' => true,
                        'placeholder'=>'分组名称'
                    ]
                ) ?>
                <?= $form->field($search, 'group_retrieve',
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
                                样品个数
                            </th>
                            <th>
                                处理方式
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
    <?php elseif(isset($_GET['Group'])&&!empty(array_filter($_GET['Group']))):?>
    <?php foreach($model as $sarch): ?>
            <tr class="shows success" attr="<?=$sarch['pro_id']?>">

                <td>
                   <?=$sarch['group_name'];?>
                </td>
                <td>
                    <?=$sarch['group_retrieve'];?>
                </td>
                <td>
                    <?= Html::a(Project::getProName($sarch['pro_id']), ['project/view', 'id' => $sarch['pro_id']], ['title'=>'查看']) ?>
                </td>
                <td>
                    <?=$sarch['group_sample_count'];?>
                </td>
                <td>
                    <?=$sarch['group_experiment_type'];?>
                </td>

                <td>
                    <?=AdminUser::getUserName($sarch['group_add_user'])?>
                </td>
                <td>
                    <?=$sarch['group_add_time']?>
                </td>
                <td>
                    <?=$sarch['group_change_time']?>
                </td>
                <td>
                    <?= Html::a('<span class="glyphicon glyphicon-zoom-in"></span>', ['view', 'id' => $sarch['id'],'ret'=>'1'], ['title'=>'查看']) ?>
                    <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $sarch['id'],'ret'=>'1'], ['title'=>'修改']) ?>
                    <?= Html::a('<span class="	glyphicon glyphicon-trash"></span>', ['delete', 'id' => $sarch['id']], [
                        'title'=>'删除',
                        'data' => [
                            'confirm' => '确定要删除这个项目吗?',
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
                               <?=$pid['group_name'];?>
                            </td>
                            <td>
                                <?=$pid['group_retrieve'];?>
                            </td>
                            <td>
                                <?= Html::a(Project::getProName($pid['pro_id']), ['project/view', 'id' => $pid['pro_id']], ['title'=>'查看']) ?>

                            </td>
                            <td>
                                <?=$pid['group_sample_count'];?>
                            </td>
                            <td>
                                <?=$pid['group_experiment_type'];?>
                            </td>

                            <td>
                                <?=AdminUser::getUserName($pid['group_add_user'])?>
                            </td>
                            <td>
                                <?=$pid['group_add_time']?>
                            </td>
                            <td>
                                <?=$pid['group_change_time']?>
                            </td>
                            <td>
                                <?= Html::a('<span class="glyphicon glyphicon-zoom-in"></span>', ['view', 'id' => $pid['id'],'ret'=>'1'], ['title'=>'查看']) ?>
                                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $pid['id'],'ret'=>'1'], ['title'=>'修改']) ?>
                                 <?= Html::a('<span class="	glyphicon glyphicon-trash"></span>', ['delete', 'id' => $pid['id'],'ret'=>'1'], [
                                    'title'=>'删除',
                                    'data' => [
                                        'confirm' => '确定要删除这个项目吗?',
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

<div class="tab-content cos">
    <div class="row clearfix">
        <?php $form = ActiveForm::begin([
            'action' => ['uploadfile'],
            'method' => 'post',
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>

        <?= $form->field($file, 'file',
            ['options'=>
                ['tag'=>false ],
                'template' => '<div class=" col-md-2 column"> 
                            <div class="btn btn-info btn-file">
                                 <i class="glyphicon glyphicon-folder-open">
                         </i>&nbsp;  <span class="hidden-xs">选择 …</span>{input}</span> </div> </div>',

            ])->fileInput() ?>
        <?= Html::submitButton('上传项目', ['class' => 'btn btn-primary uploadfile']) ?>
        <?php ActiveForm::end(); ?>
    </div>

</div>



