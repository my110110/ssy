<?php

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;
use app\models\Project;
use app\models\Principal;
use app\modules\backend\models\AdminUser;
use yii\grid\CheckboxColumn;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pagination yii\data\Pagination */
$this->title = '项目列表';
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
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <?= Html::a('实验项目', ['index'],  ['class' => 'btn btn-dafault ','role'=>'button']) ?>
            </li>
            <?php if(AdminUser::getUserRole(yii::$app->user->id)>0):?>
            <li role="presentation">
                <?= Html::a('添加项目', ['create'],['class' => 'btn btn-primary  ','role'=>'button']) ?>
            </li>
            <?php endif;?>
        </ul>

        <div class="tab-content cos">
            <div class="row clearfix">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>

                <?= $form->field($search, 'pro_name',
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
                <?= $form->field($search, 'pro_retrieve',
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
                <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end(); ?>
            </div>

            <div class="row clearfix" style="margin-top: 10px;">
                <div class="col-md-12 column">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr class="info head">

                            <th>
                                项目名称
                            </th>
                            <th>
                                项目检索号
                            </th>
                            <th>
                                项目种属
                            </th>
                            <th>
                                项目创建人
                            </th>
                            <th>
                                项目创建时间
                            </th>
                            <th>
                                项目更新时间
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
    <?php elseif(isset($_GET['Project'])&&!empty(array_filter($_GET['Project']))):?>
    <?php foreach($model as $sarch): ?>
            <tr class="shows success" attr="<?=$sarch['pro_id']?>">

                <td>
                    <?=$sarch['pro_name'];?>
                </td>
                <td>
                    <?=$sarch['pro_retrieve'];?>
                </td>
                <td>
                    <?=Project::$kind_type[$sarch['pro_kind_id']];?>
                </td>
                <td>
                    <?=AdminUser::getUserName($sarch['pro_user'])?>
                </td>
                <td>
                    <?=$sarch['pro_add_time']?>
                </td>
                <td>
                    <?=$sarch['pro_update_time']?>
                </td>
                <td>
                    <?= Html::a('<button type="button" class="btn btn-default btn-xs">查看</button>', ['view', 'id' => $sarch['pro_id']], ['title'=>'查看']) ?>
                    <?= Html::a('<button type="button" class="btn btn-primary btn-xs">下载</button>', ['export', 'id' => $sarch['pro_id']], ['title'=>'下载']) ?>
                     <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
                    <?= Html::a('<button type="button" class="btn btn-warning btn-xs">修改</button>', ['update', 'id' => $sarch['pro_id']], ['title'=>'修改']) ?>
                    <?= Html::a('<button type="button" class="btn btn-danger btn-xs">删除</button>', ['delete', 'id' => $sarch['pro_id']], [
                        'title'=>'删除',
                        'data' => [
                            'confirm' => '确定要删除这个项目吗?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?php endif;?>
                </td>
            </tr>

    <?php endforeach; ?>
<?php else:?>
                        <?php foreach($model as $pid): ?>

                        <tr class=" success" >

                            <td class="shows" attr="<?=$pid['pro_id']?>">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>&nbsp;&nbsp;<?=$pid['pro_name'];?>
                            </td>
                            <td>
                                <?=$pid['pro_retrieve'];?>
                            </td>
                            <td>
                                <?=Project::$kind_type[$pid['pro_kind_id']];?>
                            </td>
                            <td>
                                <?=AdminUser::getUserName($pid['pro_user'])?>
                            </td>
                            <td>
                                <?=$pid['pro_add_time']?>
                            </td>
                            <td>
                                <?=$pid['pro_update_time']?>
                            </td>
                            <td>
                                <?= Html::a('<button type="button" class="btn btn-default btn-xs">查看</button>', ['view', 'id' => $pid['pro_id']], ['title'=>'查看']) ?>
                                <?= Html::a('<button type="button" class="btn btn-primary btn-xs">下载</button>', ['export', 'id' => $pid['pro_id']], ['title'=>'下载']) ?>

                                <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
                                <?= Html::a('<button type="button" class="btn btn-warning btn-xs">修改</button>', ['update', 'id' => $pid['pro_id']], ['title'=>'修改']) ?>
                                 <?= Html::a('<button type="button" class="btn btn-danger btn-xs">删除</button>', ['delete', 'id' => $pid['pro_id']], [
                                    'title'=>'删除',
                                    'data' => [
                                        'confirm' => '确定要删除这个项目吗?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                                <?php endif;?>
                            </td>
                        </tr>


                                <?php if(isset($pid['child'])){ foreach($pid['child'] as $child): ?>
                                        <tr class="hides warning pid_<?=$child['pro_pid']?>" >
                                            <td>
                                                <i class="fa fa-angle-down" aria-hidden="true" style="margin-left:12px"></i>&nbsp;&nbsp;<?=$child['pro_name'];?>
                                            </td>
                                            <td>
                                                <?=$child['pro_retrieve'];?>
                                            </td>
                                            <td>
                                                <?=Project::$kind_type[$child['pro_kind_id']];?>
                                            </td>
                                            <td>
                                                <?=AdminUser::getUserName($child['pro_user'])?>
                                            </td>
                                            <td>
                                                <?=$child['pro_add_time']?>
                                            </td>
                                            <td>
                                                <?=$child['pro_update_time']?>
                                            </td>
                                            <td>
                                                <?= Html::a('<button type="button" class="btn btn-default btn-xs">查看</button>', ['view', 'id' => $child['pro_id']], ['title'=>'查看']) ?>
                                                <?= Html::a('<button type="button" class="btn btn-primary btn-xs">下载</button>', ['export', 'id' => $child['pro_id']], ['title'=>'下载']) ?>
                                                <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
                                                <?= Html::a('<button type="button" class="btn btn-warning btn-xs">修改</button>', ['update', 'id' => $child['pro_id']], ['title'=>'修改']) ?>
                                                <?= Html::a('<button type="button" class="btn btn-danger btn-xs">删除</button>', ['delete', 'id' => $child['pro_id']], [

                                                    'title'=>'删除',
                                                    'data' => [
                                                        'confirm' => '确定要删除这个项目吗?',
                                                        'method' => 'post',
                                                    ],
                                                ]) ?>
                                              <?php endif;?>
                                            </td>
                                        </tr>
                                <?php endforeach;}  ?>
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
<?php if(AdminUser::getUserRole(yii::$app->user->id)>0):?>
<div class="pull-right">
<div class="tab-content cos" style="margin-right: 20px;">
    <div class="row clearfix">
        <?php $form = ActiveForm::begin([
            'action' => ['uploadfile'],
            'method' => 'post',
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>

        <?= $form->field($file, 'file',
            ['options'=>
                ['tag'=>false ],
                'template' => '<div class=" col-md-2 column ace-file-input"> 
                             {input}</div>',

            ])->fileInput() ?>
        <?= Html::submitButton('上传项目', ['class' => 'btn btn-primary uploadfile']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
    <?php endif;?>
</div>


<script><?php $this->beginBlock('js_end') ?>

        $(function(){

         $('.hides').hide();
         $('.shows').click(function () {
             var attr=$(this).attr('attr');
             var ids='pid_'+attr;
             var node=$('.'+ids);

           if(node.is(':hidden')){
               node.show();
           }else {
               node.hide();
           }
         });


        })

    <?php $this->endBlock() ?>

</script>

<?php $this->registerJs($this->blocks['js_end'],\yii\web\View::POS_END); ?>
