<?php
use yii\helpers\Json;
use mdm\admin\components\MenuHelper;
use yii\web\UrlManager;
/**
 * @var \yii\web\View $this
 */
?>
<aside class="main-sidebar">
    <section class="sidebar" style="height: auto;padding-top: 5px">
        <ul class="sidebar-menu">
            <li><a href="/backend/project/index.html"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;<span>实验项目</span></a>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-medkit" aria-hidden="true"></i>&nbsp;<span>检测指标</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="/backend/routine/index.html"><i class="fa fa-circle-o" aria-hidden="true"></i>  <span>常规染色</span></a></li>
                    <li><a href="/backend/particular/index.html"><i class="fa fa-circle-o" aria-hidden="true"></i><span>特殊染色</span></a></li>
                    <li><a href="/backend/pna/index.html?type=1"><i class="fa fa-circle-o" aria-hidden="true"></i><span>蛋白指标</span></a></li>
                    <li><a href="/backend/pna/index.html?type=2"><i class="fa fa-circle-o" aria-hidden="true"></i><span>核酸指标</span></a></li>
                </ul>
            </li>
            <!-- <li class="treeview">
                <a href="/backend/config/index.html"><i class="fa fa-bars"></i>
                    <span>网站配置</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    
                </ul>
            </li> -->
            <li class="treeview">
                <a href="#"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;<span>系统配置</span> <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="/backend/config/base-config.html"><i class="fa fa-circle-o" aria-hidden="true"></i><span>基础配置</span></a></li>
                    <li><a href="/backend/admin-user/index.html"><i class="fa fa-circle-o" aria-hidden="true"></i><span>管理员列表</span></a></li>
                    <li><a href="/backend/operatelog/index.html"><i class="fa fa-circle-o" aria-hidden="true"></i><span>操作日志</span></a></li>
                </ul>
            </li>   
<!--            <li class="treeview">-->
<!--                <a href="/gii.html"><i class="fa fa-gavel" aria-hidden="true"></i>&nbsp;<span>开发工具</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>-->
<!--                <ul class="treeview-menu">-->
<!--                    <li><a href="/debug/default/index.html"><i class="fa fa-circle-o" aria-hidden="true"></i><span>debug</span></a></li>-->
<!--                    <li><a href="/gii.html"><i class="fa fa-circle-o" aria-hidden="true"></i><span>gii</span></a></li>-->
<!--                </ul>-->
<!--            </li>-->
        </ul>
    </section>
</aside>
