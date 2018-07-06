<?php

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;
use app\models\Project;
use app\models\Group;
use app\modules\backend\models\AdminUser;
use app\modules\backend\models\operatelog;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pagination yii\data\Pagination */
$this->title = '检测方法列表';
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


            <div class="row clearfix" style="margin-top: 10px;">
                <div class="col-md-12 column">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr class="info head">



                            <th>
                                操作人
                            </th>
                            <th>
                                操作
                            </th>
                            <th>
                                操作对象
                            </th>

                            <th>
                                操作时间
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php if(empty($model)):?>
                            <tr class="error">
                                <td colspan="6">没有数据</td>
                            </tr>

                        <?php else:?>
                            <?php foreach($model as $pid): ?>
                                <tr class="shows success" >

                                    <td>
                                        <?=AdminUser::getUserName($pid['user']);?>
                                    </td>
                                    <td>
                                        <?=operatelog::$operate[$pid['operate']];?>
                                    </td>
                                    <td>
                                        <?=$pid['objectname'];?>
                                    </td>


                                    <td>
                                        <?=$pid['operate_time']?>
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





