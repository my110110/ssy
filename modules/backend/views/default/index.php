<?php
/** @var $this yii\web\View */
use yii\helpers\Url;

$this->title = '后台首页';
?>
<div class="backend-default-index">
    <div class="row">

        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><span class="fa fa-television"></span>系统信息</h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body no-padding">
                    <table class="table table-condensed table-striped">
                        <tbody>
                        <tr>
                            <th style="width: 150px">Yii 版本</th>
                            <td><?= Yii::getVersion() ?></td>
                        </tr>
                        <tr>
                            <th>Yii ENV</th>
                            <td><?= YII_ENV; ?></td>
                        </tr>
                        <tr>
                            <th>Yii DUBUG</th>
                            <td><?= YII_DEBUG; ?></td>
                        </tr>
                        <tr>
                            <th>操作系统</th>
                            <td><?= PHP_OS ?></td>
                        </tr>
                        <tr>
                            <th>PHP 版本</th>
                            <td><?= PHP_VERSION ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
