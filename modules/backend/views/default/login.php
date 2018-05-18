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
$fieldOptions1 = [
    'options' => ['class' => 'form-control'],
    'inputTemplate' => "{input}"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>
<script src="<?=$assets_url?>/js/require.min.js" data-main="<?=$assets_url?>/js/require-backend.min.js"></script>
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
                    ]); ?>
                        <div id="errtips" class="hide"></div>
                        <input type="hidden" name="__token__" value="68041f02fc8315b7ccdfaeb0e189a743" />                                <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>

                        <?= $form->field($model, 'username',['options'=>['tag'=>false]])->textInput(['autofocus' => true,'class'=>'form-control','id'=>'pd-form-username','placeholder'=>'用户名'])->label(false) ?>

<!--                        <input type="text" class="form-control" id="pd-form-username" placeholder="用户名" name="username" autocomplete="off" value="" data-rule="用户名:required;username" />-->
                        </div>

                        <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></div>
                            <?= $form->field($model, 'password',['options'=>['tag'=>false]])->passwordInput(['autofocus' => true,'class'=>'form-control','id'=>'pd-form-password','placeholder'=>'密码'])->label(false) ?>
                        </div>

                        <div class="form-group">
                            <label class="inline" for="keeplogin">
                                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                                保持会话                                    </label>
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