<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2016/12/7
 * Time: 10:55
 * Email:liyongsheng@meicai.cn
 */

/* @var $this yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */
use yii\widgets\ListView;
use yii\bootstrap\Html;


?>
<style>
    .caption{text-align: left}
    @media screen and (min-width:1200px) {
        .thumbnail{width:240px;text-align: center;margin-left: auto; margin-right: auto;padding: 0}
        .image-box{border-bottom: 1px solid #ddd;padding: 5px}
        .image-box a{
            height: 230px;width:230px; text-align: center;vertical-align: middle;display: table-cell;
        }
        .image{max-width:100%;max-height:230px;vertical-align:middle;display: inline}
    }
    @media ( min-width:992px ) and ( max-width:1199px ) {
        .thumbnail{width:200px;text-align: center;margin-left: auto; margin-right: auto;padding: 0}
        .image-box{border-bottom: 1px solid #ddd;padding: 5px}
        .image-box a{
            height: 200px;width:200px; text-align: center;vertical-align: middle;display: table-cell;
        }
        .image{max-width:100%;max-height:190px;vertical-align:middle;display: inline}
        h5, .h5 {font-size: 12px}
        .caption{font-size: 12px;}
    }
</style>
<div class="container">
    <div style="height: 10px;width: 100%"></div>
    <div class="row clearfix">
        <div class="col-md-12 column">
            <ul class="breadcrumb">
                <li>
                    <a href="/">首页</a>
                </li>
                <li>
                    <a href="">成功案例</a>
                </li>


            </ul>
        </div>
    </div>
        <div class="row">

            <div class="col-lg-12">

                <div>
                    <?= ListView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "<div class='panel-body'>{items}</div>\n<div class='panel-body'>{pager}</div>",
                        'itemView'=>'_item'
                    ]); ?>
                </div>
            </div>

        </div>
</div>