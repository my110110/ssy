<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2016/12/7
 * Time: 15:25
 * Email:liyongsheng@meicai.cn
 */

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\backend\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\backend\assets\BackendAsset;
BackendAsset::register($this);

$assets_url=$this->getAssetManager()->getBundle(BackendAsset::className())->baseUrl;
$this->title = Yii::$app->name;

?>


<div class="container">
    <div class="login-wrapper">
        <div class="login-screen">
            <div class="well">
                <div class="login-form">
                    <img id="profile-img" class="profile-img-card" src="<?=$assets_url?>/img/avatar.png" />
                    <p id="profile-name" class="profile-name-card"></p>

                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'enableClientValidation' => false,
//                        'fieldConfig' => [
//                                'template' => '  <div class="input-group">
//                            <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
//                        {input}</div>{error}'
//                            ],  //设置模板的样式
                    ]); ?>

                        <?= $form->field(
                                            $model, 'username',
                                            ['options'=>
                                                ['tag'=>false ],
                                                'template' => '<div class="input-group">
                                                                    <div class="input-group-addon">
                                                                      <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                                                    </div> {input}
                                                                  </div>{error}'
                                            ]
                                        )->textInput
                                       (
                                                [
                                                        'autofocus' => true,
                                                        'class'=>'form-control',
                                                        'id'=>'pd-form-username',
                                                        'placeholder'=>'用户名'
                                                ]
                                        )->error(['style'=>'color:red;text-align:center;']);
                        ?>
                        <?= $form->field(
                                            $model, 'password',
                                            [
                                                    'options'=>
                                                        ['tag'=>false],
                                                        'template' => '  <div class="input-group">
                                                                               <div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></div>
                                                                           {input}</div>{error}'
                                            ]
                                         )->passwordInput
                                         (
                                                             [
                                                                'autofocus' => true,'
                                                                class'=>'form-control',
                                                                 'id'=>'pd-form-password',
                                                                 'placeholder'=>'密码'
                                                             ]
                                         )->error( ['style'=>'color:red;text-align:center;']);
                        ?>
                        <div class="form-group">
                            <label class="inline" for="keeplogin">
                                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                                                               </label>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg btn-block">登 录</button>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>