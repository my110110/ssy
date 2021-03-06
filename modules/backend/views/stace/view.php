    <?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\backend\models\AdminUser;
use app\models\Project;
use app\models\Stace;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '样品管理', ['sample/view', 'id' => $model->sid]];

?>
<div class="content-view">


    <div class="clearfix">
        <div class="pull-left">


        <?php if($ret==1):?>
            <?= Html::a('返回列表', ['stace/index'], [
                'title'=>'返回列表',
                'class' => 'btn btn-primary',

            ]) ?>
        <?php else:?>
            <?= Html::a('返回样本', ['sample/view', 'id' => $model->sid], [
                'title'=>'返回项目',
                'class' => 'btn btn-primary',

            ]) ?>
        <?php endif;?>
        <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>
        <?= Html::a('新增实验结果', [''], [
            'title'=>'返回项目',
            'class' => 'btn btn-success n_add',

        ]) ?>
        <?= Html::a('修改', ['update', 'id' => $model->id], [
                'class' => 'btn btn-warning','title'=>'修改'])
        ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'title'=>'删除',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif;?>
        </div>
    <?php if(AdminUser::getUserRole(yii::$app->user->id)==1):?>

         <p class="r_add" style="float: left;display: none" >
            <?= Html::a('常规H&E染色', ['routine/add', 'id' => $model->id], ['class' => 'btn btn-default','title'=>'修改']) ?>
            <?= Html::a('特殊染色', ['particular/add', 'id' => $model->id], ['class' => 'btn btn-default','title'=>'修改']) ?>
            <?= Html::a('蛋白', ['pna/add', 'id' => $model->id,'ntype'=>'3'], ['class' => 'btn btn-default','title'=>'修改']) ?>
            <?= Html::a('核酸', ['pna/add', 'id' => $model->id,'ntype'=>'4'], ['class' => 'btn btn-default','title'=>'修改']) ?>

        </p>
        <div class="pull-right">
        <div class="tab-content cos">
            <div class="row clearfix">
                <?php $form = ActiveForm::begin([
                    'action' => ['sdyeing/uploadfile','pid'=>$model->id],
                    'method' => 'post',
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>

                <?= $form->field($file, 'file',
                    ['options'=>
                        ['tag'=>false ],
                        'template' => '<div class="  ace-file-inputs"> 
                                 {input}</div>',

                    ])->fileInput() ?>
                <div class="  ace-pid-input">
                    <select id="sdyeing-nid" class="part form-control" name="ntype" aria-invalid="false">
                        <option value="1">常规H&E染色</option>
                        <option value="2">特殊染色</option>
                        <option value="3">蛋白</option>
                        <option value="3">核酸</option>

                    </select>

                    <div class="help-block"></div>
                </div>
                <?= Html::submitButton('导入实验结果', ['class' => 'btn btn-primary uploadfile']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        </div>
    <?php endif;?>
    <div class="row clearfix" style="margin-top: 40px;">
        <div class="col-md-12 column">
            <table class="table table-hover table-bordered">
                <tbody>
                <tr class="info">

                  <td class="col-md-2">名称</td>
                    <td class="col-md-10"><?=$model->name?></td>
                </tr>
                <tr class="default">

                    <td class="col-md-2">检索号</td>
                    <td class="col-md-10"><?=$model->retrieve?></td>
                </tr>



                <tr class="info">
                    <td class="col-md-2">样品描述</td>
                    <td class="col-md-10"><?=$model->description?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">组织/细胞位置</td>
                    <td class="col-md-10"><?=$model->postion?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">取材</td>
                    <td class="col-md-10"><?=$model->materials?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">保存</td>
                    <td class="col-md-10"><?=$model->saves?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">固定</td>
                    <td class="col-md-10"><?=$model->fixed?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">包埋</td>
                    <td class="col-md-10"><?=$model->embedding?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">存放位置</td>
                    <td class="col-md-10"><?=$model->place?></td>
                </tr>
                <tr class="default">
                    <td class="col-md-2">添加人</td>
                    <td class="col-md-10"><?=AdminUser::getUserName($model->add_user)?></td>
                </tr>
                <tr class="info">
                    <td class="col-md-2">添加时间</td>
                    <td class="col-md-10"><?=$model->add_time?></td>
                </tr>
                <?php if(!empty($model->change_user)):?>
                <tr class="warning">
                    <td class="col-md-2">修改人</td>
                    <td class="col-md-10"><?=AdminUser::getUserName($model->change_user)?></td>
                </tr>
                    <tr class="default">
                        <td class="col-md-2">修改时间</td>
                        <td class="col-md-10"><?=$model->change_time?></td>
                    </tr>
                <?php endif;?>
               <tr>
                   <td colspan="2">
                       <?= Html::a('查看实验结果', ['sdyeing/index', 'yid' => $model->id], [
                           'title'=>'返回项目',
                           'class' => 'btn btn-primary',

                       ]) ?>
                       <?= Html::a('导出实验结果', ['sdyeing/exports', 'id' => $model->id], [
                           'title'=>'返回项目',
                           'class' => 'btn btn-success',

                       ]) ?>
                   </td>
               </tr>
                </tbody>
            </table>


</div>
        <script><?php $this->beginBlock('js_end') ?>

            $(function(){

                $('.n_add').click(function () {
                 $('.r_add').show();
                 return false;
                });


            })

            <?php $this->endBlock() ?>

        </script>

        <?php $this->registerJs($this->blocks['js_end'],\yii\web\View::POS_END); ?>
