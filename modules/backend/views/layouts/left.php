<?php
use yii\helpers\Json;
use mdm\admin\components\MenuHelper;
use yii\web\UrlManager;
/**
 * @var \yii\web\View $this
 */
?>
<!--<aside class="main-sidebar">-->
<!--    <section class="sidebar" style="height: auto;padding-top: 5px">-->
<!--        <ul class="sidebar-menu">-->
<!--            <li><a href="/backend/project/index.html"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;<span>实验项目</span></a>-->
<!--            </li>-->
<!--            <li class="treeview">-->
<!--                <a href="#" class="test1"><i class="fa fa-medkit" aria-hidden="true"></i>&nbsp;<span>检测指标</span>-->
<!--                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>-->
<!--                <ul class="treeview-menu">-->
<!--                    <li><a href="/backend/routine/index.html"><i class="fa fa-circle-o" aria-hidden="true"></i>  <span>常规染色</span></a></li>-->
<!--                    <li><a href="/backend/particular/index.html"><i class="fa fa-circle-o" aria-hidden="true"></i><span>特殊染色</span></a></li>-->
<!--                    <li><a href="/backend/pna/index.html?type=1"><i class="fa fa-circle-o" aria-hidden="true"></i><span>蛋白指标</span></a></li>-->
<!--                    <li><a href="/backend/pna/index.html?type=2"><i class="fa fa-circle-o" aria-hidden="true"></i><span>核酸指标</span></a></li>-->
<!--                </ul>-->
<!--            </li>-->
<!--            <!-- <li class="treeview">-->
<!--                <a href="/backend/config/index.html"><i class="fa fa-bars"></i>-->
<!--                    <span>网站配置</span>-->
<!--                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>-->
<!--                <ul class="treeview-menu">-->
<!--                    -->
<!--                </ul>-->
<!--            </li> -->-->
<!--            <li class="treeview">-->
<!--                <a href="#"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;<span>系统配置</span> <span class="pull-right-container">-->
<!--                        <i class="fa fa-angle-left pull-right"></i></span></a>-->
<!--                <ul class="treeview-menu">-->
<!--                    <li><a href="/backend/config/base-config.html"><i class="fa fa-circle-o" aria-hidden="true"></i><span>基础配置</span></a></li>-->
<!--                    <li><a href="/backend/admin-user/index.html"><i class="fa fa-circle-o" aria-hidden="true"></i><span>管理员列表</span></a></li>-->
<!--                    <li><a href="/backend/operatelog/index.html"><i class="fa fa-circle-o" aria-hidden="true"></i><span>操作日志</span></a></li>-->
<!--                </ul>-->
<!--            </li>   -->
<!--            <li class="treeview">-->
<!--                <a href="/gii.html"><i class="fa fa-gavel" aria-hidden="true"></i>&nbsp;<span>开发工具</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>-->
<!--                <ul class="treeview-menu">-->
<!--                    <li><a href="/debug/default/index.html"><i class="fa fa-circle-o" aria-hidden="true"></i><span>debug</span></a></li>-->
<!--                    <li><a href="/gii.html"><i class="fa fa-circle-o" aria-hidden="true"></i><span>gii</span></a></li>-->
<!--                </ul>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </section>-->
<!--</aside>-->
<aside class="main-sidebar">
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 893px;">
        <section class="sidebar" style="height: 893px; overflow: hidden; width: auto;">
            
            <ul class="sidebar-menu tree" data-widget="tree">
                <li class="active" icon="fa fa-th">
                    <a href="/backend/project/index.html">
                        <i class="fa fa-file-excel-o"></i>
                        <span>实验项目</span></a>
                </li>
                <li class="treeview" icon="fa fa-medkit">
                    <a href="检测指标">
                        <i class="fa fa-medkit"></i>
                        <span>检测指标</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                    <ul class="treeview-menu">
                        <li><a href="/backend/routine/index.html"><i class="fa fa-circle-o" aria-hidden="true"></i>  <span>常规染色</span></a></li>
                        <li><a href="/backend/particular/index.html"><i class="fa fa-circle-o" aria-hidden="true"></i><span>特殊染色</span></a></li>
                        <li><a href="/backend/pna/index.html?type=1"><i class="fa fa-circle-o" aria-hidden="true"></i><span>蛋白指标</span></a></li>
                        <li><a href="/backend/pna/index.html?type=2"><i class="fa fa-circle-o" aria-hidden="true"></i><span>核酸指标</span></a></li>
                    </ul>
                </li>
                <li class="treeview" icon="fa fa-bars"><a href="/backend/rbac/route/index.html"><i class="fa fa-bars"></i>  <span>后台配置</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                    <ul class="treeview-menu">
                            <li><a href="/backend/admin-user/index.html"><i class="fa fa-circle-o"></i>  <span>管理员列表</span></a></li>
                            <li><a href="/backend/rbac/assignment/index.html"><i class="fa fa-circle-o"></i>  <span>权限配置</span></a></li>
                            <li><a href="/backend/rbac/role/index.html"><i class="fa fa-circle-o"></i>  <span>角色列表</span></a></li>
                            <li><a href="/backend/rbac/permission/index.html"><i class="fa fa-circle-o"></i>  <span>权限列表</span></a></li>
                            <li><a href="/backend/rbac/rule/index.html"><i class="fa fa-circle-o"></i>  <span>规则列表</span></a></li>
                            <li><a href="/backend/rbac/route/index.html"><i class="fa fa-circle-o"></i>  <span>路由列表</span></a></li>
                            <li><a href="/backend/rbac/menu/index.html"><i class="fa fa-circle-o"></i>  <span>后台菜单</span></a></li>
                    </ul>
                </li>
                <li class="treeview" icon="fa fa-share"><a href="/gii.html"><i class="fa fa-share"></i>  <span>开发工具</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li><a href="/debug/default/index.html"><i class="fa fa-circle-o"></i>  <span>debug</span></a></li>
                            <li><a href="/gii.html"><i class="fa fa-circle-o"></i>  <span>gii</span></a></li>
                        </ul>
                </li>
                
        </section>
            <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 893px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
    </div>
</aside>