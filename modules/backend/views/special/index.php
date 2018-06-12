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
$this->title = '常规染色';
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
                <?= Html::a('检测指标列表', ['index'],  ['class' => 'btn btn-dafault ','role'=>'button']) ?>
            </li>
            <li role="presentation">
                <?= Html::a('添加检测指标', ['create'],['class' => 'btn btn-primary  ','role'=>'button']) ?>
            </li>
        </ul>

        <div class="tab-content cos">


            <div class="row clearfix" style="margin-top: 10px;">
                <div class="col-md-12 column">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr class="info head">

                            <th>
                               上传时间
                            </th>
                            <th>
                                检索号
                            </th>
                            <th>
                                名称
                            </th>

                            <th>
                                项目创建人
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
    <?php else:?>
                        <?php foreach($model as $model): ?>

                        <tr class="shows success">

                            <td>
                               <?=$model['add_time'];?>
                            </td>
                            <td>
                                <?=$model['retrieve'];?>
                            </td>
                            <td>
                                <?=$model['name'];?>
                            </td>
                            <td>
                                <?=AdminUser::getDoName($model['id'],1,'special')?>
                            </td>

                            <td>
                                <?=$model['change_time']?>
                            </td>
                            <td>
                                <?= Html::a('<span class="glyphicon glyphicon-zoom-in"></span>', ['view', 'id' => $model['id']], ['title'=>'查看']) ?>
                                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model['id']], ['title'=>'修改']) ?>
                                 <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model['id']], [
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

<div

<script><?php $this->beginBlock('js_end') ?>

        $(function(){

         $('.hides').hide();
         $('.shows').click(function () {
             var attr=$(this).attr('attr');
             var ids='pid_'+attr;
             var node=$('.'+ids);

             node.slideToggle();
         });


        })

    <?php $this->endBlock() ?>

</script>

<?php $this->registerJs($this->blocks['js_end'],\yii\web\View::POS_END); ?>
